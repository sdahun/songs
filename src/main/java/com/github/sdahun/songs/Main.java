package com.github.sdahun.songs;

import com.fasterxml.jackson.databind.ObjectMapper;
import org.openlyrics.jlyrics.IOFactory;
import org.openlyrics.jlyrics.Song;
import org.openlyrics.jlyrics.hymnbook.Hymnbooks;
import org.openlyrics.jlyrics.masswriter.IMassWriter;
import org.openlyrics.jlyrics.reader.ILyricsReader;
import org.openlyrics.jlyrics.reader.ReaderType;
import org.openlyrics.jlyrics.transform.SongTransformer;
import org.openlyrics.jlyrics.transform.SongTransformerConfig;
import org.openlyrics.jlyrics.writer.*;

import java.io.*;
import java.util.*;
import java.util.regex.Matcher;
import java.util.regex.Pattern;
import java.util.stream.Collectors;

import static com.github.sdahun.songs.MassWriterFactory.getMassWriter;
import static org.openlyrics.jlyrics.util.SongUtils.repeat;

public class Main {
    SongTransformerConfig config = new SongTransformerConfig();
    Hymnbooks books = new Hymnbooks();

    public static void main(String[] args) {
        new Main().generate();
    }

    public void generate() {
        System.out.println(repeat("=", 60));
        System.out.print(repeat(" ", 20));
        System.out.println("ÉNEKSZÖVEG ÁTALAKÍTÓ");
        System.out.println(repeat("=", 60));

        //load hymnbooks data
        try (InputStream hymnInputStream = Main.class.getClassLoader().getResourceAsStream("hymnbooks.json")) {
            books.loadFromJson(hymnInputStream);
        } catch (IOException e) {
            throw new RuntimeException(e);
        }

        askForConfiguration();

        System.out.println("Kis türelmet, az átalakítás folyamatban...");

        IMassWriter massWriter = getMassWriter(OutputType.values()[config.getWriterFormat()], config);

        //iterate through all the hymnbooks
        for (int i = 0; i < books.size(); i++) {

            String songlist = config.getSelectedSongs().get(i);

            if (songlist == null && config.getSelectedSongs().get(-1) != null) {
                songlist = "0"; //all song from all songbook
            }

            if (songlist == null) {
                continue;
            }

            System.out.println("Énekek átalakítása a következő énekesből: " + books.get(i).getName());

            if (songlist.equals("0")) {
                songlist = "1-" + books.get(i).getCount();
            }

            try {
                ILyricsReader reader = IOFactory.getNewReader(ReaderType.OPENLYRICS);
                SongTransformer transformer = new SongTransformer(books, config);

                for (String part : songlist.split(",")) {
                    List<Integer> elems = Arrays.stream(part.split("-"))
                        .mapToInt(Integer::parseInt)
                        .boxed()
                        .collect(Collectors.toList());

                    if (elems.size() == 1) {
                        elems.add(elems.get(0));
                    }

                    if (elems.get(0) <= elems.get(1)) {
                        for (int j = elems.get(0); j <= elems.get(1); j++) {
                            String path = String.format("%s/%03d.xml", books.get(i).getFolder(), j);
                            try (InputStream is = Main.class.getClassLoader().getResourceAsStream(path)) {
                                Song song = reader.read(is);
                                massWriter.add(transformer.transform(song));
                            } catch (Exception e) {
                                //if missing, skip
                            }
                        }
                    }
                }
            } catch (Exception e) {
                throw new RuntimeException(e);
            }
        }

        try {
            massWriter.close();
        } catch (Exception e) {
            throw new RuntimeException(e);
        }
    }

    private void askForConfiguration() {
        int questionNumber = 0;
        Scanner scanner = new Scanner(System.in);

        //does old config exists?
        if (new File("config.json").isFile()) {

            if (choice(scanner, ++questionNumber, "Már létezik konfigurációs fájl. Szeretnéd azt használni?", true)) {
                try (FileInputStream is = new FileInputStream("config.json")) {
                    ObjectMapper mapper = new ObjectMapper();
                    config = mapper.readValue(is, SongTransformerConfig.class);
                } catch (IOException e) {
                    throw new RuntimeException(e);
                }
                return;
            }
        }

        config.setIntroSlide(choice(scanner, ++questionNumber, "Legyen nyitó dia az ének címével?", true));
        if (config.isIntroSlide()) {
            config.setIntroSongBook(choice(scanner, ++questionNumber, "Szerepeljen a nyitó dián az énekeskönyv neve?", false));

            if (config.isIntroSongBook()) {
                config.setIntroSongNumber(choice(scanner, ++questionNumber, "Szerepeljen a nyitó dián az ének sorszáma?", false));
            }
        }

        config.setLineBreak(choice(scanner, ++questionNumber, "Az énekszöveg soronként legyen tördelve?", true));
        if (!config.isLineBreak()) {
            config.setSolidusSeparator(choice(scanner, ++questionNumber, "A sorok legyenek perjellel (/) elválasztva?", false));
        }

        config.setFirstUppercase(choice(scanner, ++questionNumber, "A sorok első betűje legyen nagybetűs?", false));
        config.setRepeatVerses(choice(scanner, ++questionNumber, "Az ismétlődő diák (refrén) ismétlődjenek?", false));
        config.setEmptySlide(choice(scanner, ++questionNumber, "Legyen utolsó utáni üres dia?", false));
        config.setTagSlide(choice(scanner, ++questionNumber, "Legyen az utolsó dia után gyorskereső hivatkozás??", false));

        List<String> writerFormats = OutputType.getDescriptions();

        config.setWriterFormat(getNumber(
                scanner,
                listToQuestion(++questionNumber, "Milyen formátumba kerüljenek az énekek?", writerFormats, false),
                1,
                writerFormats.size()
        )-1);

        config.setBatchSize(getNumber(scanner, "Hány ének kerüljön egy fájlba? (0 = mind egybe)", 0, 1000));

        if (getNumber(
                scanner,
                listToQuestion(++questionNumber, "Mely énekeket szeretnéd átalakítani?", Arrays.asList(
                        "Az összes énekeskönyv összes énekét",
                        "Csak a kiválasztott énekeskönyvekből kérek énekeket"
                ), false),
                1, 2) == 1) {
            config.getSelectedSongs().put(-1, "all");
        } else {
            String selectedBooks = getRange(
                    scanner,
                    listToQuestion(++questionNumber, "Sorold fel a kiválasztott énekeskönyvek sorszámát!",
                            books.getHymnbookNames(), true));

            Arrays.stream(selectedBooks.split(","))
                .collect(Collectors.toList())
                .forEach(part -> {
                    List<Integer> elems = Arrays.stream(part.split("-")).mapToInt(Integer::parseInt).boxed().collect(Collectors.toList());
                    if (elems.size() == 1) {
                        elems.add(elems.get(0));
                    }

                    if (elems.get(0) <= elems.get(1)) {
                        for (int i = elems.get(0) - 1; i < elems.get(1); i++) {
                            config.getSelectedSongs().put(i, getRange(
                                scanner,
                                String.format("  - Sorold fel a kiválasztott énekek sorszámát ebből az énekeskönyvből: %s\n    Válasz? (0 = mind) (pl.: 1-100,150): ",
                                    books.get(i).getName())
                        ));
                    }
                }
            });

            System.out.println("Beállítások mentése...");
            try {
                FileOutputStream os = new FileOutputStream("config.json");
                ObjectMapper mapper = new ObjectMapper();
                mapper.writeValue(os, config);
            } catch (IOException e) {
                throw new RuntimeException(e);
            }
        }
    }

    private static boolean choice(Scanner sc, int qNumber, String question, boolean defaultChoice) {
        String answer = "x";
        while (!answer.equals("I") && !answer.equals("N") && !answer.isEmpty()) {
            System.out.format("%d.) " + question + " (" + (defaultChoice ? "I/n" : "i/N") + "): ", qNumber);
            answer = sc.nextLine().toUpperCase();
        }
        switch(answer) {
            case "I": return true;
            case "N": return false;
            default: return defaultChoice;
        }
    }

    private static String listToQuestion(int qNumber, String epilog, List<String> options, boolean multiple) {
        StringBuilder sb = new StringBuilder();
        sb.append(qNumber).append(".) ").append(epilog).append("\n");
        int[] optionNumber = { 0 };
        options.forEach(option -> sb
                .append("    ")
                .append(++optionNumber[0])
                .append(".) ")
                .append(option)
                .append("\n")
        );
        if (!multiple) {
            sb.append("  Válasz? (1-").append(options.size()).append("): ");
        } else {
            sb.append("  Válasz? (pl.: 1-3,5): ");
        }
        return sb.toString();
    }

    private static int getNumber(Scanner sc, String question, int minValue, int maxValue) {
        int answer = minValue-1;
        while (answer < minValue || answer > maxValue) {
            System.out.print(question + ": ");
            try {
                answer = Integer.parseInt(sc.nextLine());
            }
            catch (NumberFormatException e) {
                answer = 0;
            }
            if (answer < minValue) {
                System.out.println("Az érték nem lehet kisebb, mint " + minValue + "!");
            }
            if (answer > maxValue) {
                System.out.println("Az érték nem lehet nagyobb, mint " + maxValue + "!");
            }
        }
        return answer;
    }

    private static String getRange(Scanner sc, String question) {
        boolean match = false;
        String answer = "";
        Pattern pattern = Pattern.compile("^[0-9,\\-]+$");

        while (!match) {
            System.out.print(question);
            answer = sc.nextLine();
            Matcher matcher = pattern.matcher(answer);
            match = matcher.find();
        }
        return answer;
    }

}