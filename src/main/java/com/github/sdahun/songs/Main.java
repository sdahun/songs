package com.github.sdahun.songs;

import com.fasterxml.jackson.databind.ObjectMapper;
import org.openlyrics.jlyrics.IOFactory;
import org.openlyrics.jlyrics.Song;
import org.openlyrics.jlyrics.masswriter.IMassWriter;
import org.openlyrics.jlyrics.masswriter.MassWriterType;
import org.openlyrics.jlyrics.reader.ILyricsReader;
import org.openlyrics.jlyrics.reader.ReaderType;
import org.openlyrics.jlyrics.transform.ConfigSongBookData;
import org.openlyrics.jlyrics.transform.SongTransformer;
import org.openlyrics.jlyrics.transform.SongTransformerConfig;
import org.openlyrics.jlyrics.writer.*;

import java.io.*;
import java.util.*;
import java.util.regex.Matcher;
import java.util.regex.Pattern;
import java.util.stream.Collectors;

import static org.openlyrics.jlyrics.util.SongUtils.repeat;

public class Main {

    public static void main(String[] args) {
        System.out.println(repeat("=", 60));
        System.out.print(repeat(" ", 20));
        System.out.println("ÉNEKSZÖVEG ÁTALAKÍTÓ");
        System.out.println(repeat("=", 60));

        SongTransformerConfig config = askForConfig();

        System.out.println("Kis türelmet, az átalakítás folyamatban...");

        IMassWriter massWriter;

        try {
            switch (config.getWriterFormat()) {
                case 1:
                    massWriter = IOFactory.getNewMassWriter(MassWriterType.OPENLP);
                    massWriter.init(massWriter.generateFilename(), null, config);
                    break;
                case 2:
                    massWriter = IOFactory.getNewMassWriter(MassWriterType.ZIP);
                    massWriter.init(massWriter.generateFilename(), new FreeShowWriter(), config);
                    break;
                case 3:
                    massWriter = IOFactory.getNewMassWriter(MassWriterType.EASYWORSHIP);
                    massWriter.init(massWriter.generateFilename(), null, config);
                    break;
                case 4:
                    massWriter = IOFactory.getNewMassWriter(MassWriterType.ZIP);
                    massWriter.init(massWriter.generateFilename(), new OpenLyricsWriter(), config);
                    break;
                case 5:
                    massWriter = IOFactory.getNewMassWriter(MassWriterType.ZIP);
                    massWriter.init(massWriter.generateFilename(), new PptxWriter(), config);
                    break;
                default:
                    massWriter = IOFactory.getNewMassWriter(MassWriterType.ZIP);
                    massWriter.init(massWriter.generateFilename(), new TextWriter(), config);
                    break;
            }

            for (ConfigSongBookData book : config.getSongbooks()) {
                String songlist = config.getSelectedSongs().get(config.getSongbooks().indexOf(book));

                if (songlist == null && config.getSelectedSongs().get(-1) != null) {
                    songlist = "0"; //all song from all songbook
                }

                if (songlist != null) {
                    System.out.println("Énekek átalakítása a következő énekesből: " + book.getName());
                    if (songlist.equals("0")) {
                        songlist = "1-999";
                    }

                    ILyricsReader reader = IOFactory.getNewReader(ReaderType.OPENLYRICS);
                    SongTransformer transformer = new SongTransformer();

                    for (String part : songlist.split(",")) {
                        List<Integer> elems = Arrays.stream(part.split("-")).mapToInt(Integer::parseInt).boxed().collect(Collectors.toList());
                        if (elems.size() == 1) {
                            elems.add(elems.get(0));
                        }

                        if (elems.get(0) <= elems.get(1)) {
                            for (int i = elems.get(0); i <= elems.get(1); i++) {
                                String path = String.format("%s/%03d.xml", book.getFolder(), i);
                                try (InputStream is = Main.class.getClassLoader().getResourceAsStream(path)) {
                                    Song song = reader.read(is);
                                    massWriter.add(transformer.transform(song, config));
                                } catch (Exception e) {
                                    //if not found, skip
                                }
                            }
                        }
                    }
                }
            }
            massWriter.close();

        } catch (Exception e) {
            throw new RuntimeException(e);
        }
    }

    private static SongTransformerConfig loadSongbookDatasToConfig(SongTransformerConfig config) {
        return config
            .addSongbookData(new ConfigSongBookData("A", "Adj zengő éneket!", "adj_zengo_eneket"))
            .addSongbookData(new ConfigSongBookData("B", "Baptista gyülekezeti énekeskönyv", "baptista_gyulekezeti_enekeskonyv"))
            .addSongbookData(new ConfigSongBookData("T", "Dicsérem Neved 1", "dicserem_neved_1"))
            .addSongbookData(new ConfigSongBookData("V", "Dicsérem Neved 2", "dicserem_neved_2"))
            .addSongbookData(new ConfigSongBookData("W", "Dicsérem Neved 3", "dicserem_neved_3"))
            .addSongbookData(new ConfigSongBookData("X", "Dicsérem Neved 4", "dicserem_neved_4"))
            .addSongbookData(new ConfigSongBookData("Y", "Dicsérem Neved 5", "dicserem_neved_5"))
            .addSongbookData(new ConfigSongBookData("E", "Erőm és énekem az Úr", "erom_es_enekem_az_ur"))
            .addSongbookData(new ConfigSongBookData("H", "Hitünk énekei", "hitunk_enekei"))
            .addSongbookData(new ConfigSongBookData("Q", "Hozsánna énekes", "hozsanna"))
            .addSongbookData(new ConfigSongBookData("S", "Szent az Úr", "szent_az_ur"))
            .addSongbookData(new ConfigSongBookData("U", "Üdv- és adventi énekek", "udv_es_adventi_enekek"))
            .addSongbookData(new ConfigSongBookData("Z", "Zuglói Adventista Gyülekezeti Énekeskönyv", "zugloi_adventista_gyulekezeti_enekeskonyv"))
        ;
    }

    private static SongTransformerConfig askForConfig() {
        SongTransformerConfig config;

        int questionNumber = 0;
        Scanner scanner = new Scanner(System.in);

        //does old config exists?
        if (new File("config.json").isFile()) {

            if (choice(scanner, ++questionNumber, "Már létezik konfigurációs fájl. Szeretnéd azt használni?", true)) {
                try (FileInputStream is = new FileInputStream("config.json")) {
                    ObjectMapper mapper = new ObjectMapper();
                    config = mapper.readValue(is, SongTransformerConfig.class);
                    loadSongbookDatasToConfig(config);
                } catch (IOException e) {
                    throw new RuntimeException(e);
                }
                return config;
            }
        }

        config = loadSongbookDatasToConfig(new SongTransformerConfig());

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

        List<String> writerFormats = new ArrayList<>(Arrays.asList(
                "OpenLP (songs.sqlite adatbázisfájlban)",
                "FreeShow (show fájlok zip fájlban)",
                "EasyWorship (schedule fájlban)",
                "OpenLyrics (xml fájlok zip fájlban)",
                "Powerpoint (pptx fájlok zip fájlban)",
                "Csak szöveg (txt fájlok zip fájlban)"
        ));

        config.setWriterFormat(getNumber(
                scanner,
                listToQuestion(++questionNumber, "Milyen formátumba kerüljenek az énekek?", writerFormats, false),
                1,
                writerFormats.size()
        ));

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
                            config.getSongbookNames(), true));

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
                                    config.getSongbookById(i).getName())
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
        return config;
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