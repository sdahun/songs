package com.github.sdahun.songs;

import com.fasterxml.jackson.databind.ObjectMapper;
import com.fasterxml.jackson.databind.type.CollectionType;
import com.fasterxml.jackson.databind.type.TypeFactory;
import com.github.sdahun.songs.generators.ContentsGenerator;
import com.github.sdahun.songs.generators.IGenerator;
import com.github.sdahun.songs.generators.IndexGenerator;
import com.github.sdahun.songs.generators.WordlistGenerator;
import com.github.sdahun.songs.validators.IValidator;
import com.github.sdahun.songs.validators.SyllableValidator;
import com.github.sdahun.songs.validators.WidthValidator;
import com.github.sdahun.songs.validators.XmlValidator;
import org.apache.commons.collections4.list.TreeList;
import org.openlyrics.jlyrics.Song;
import org.openlyrics.jlyrics.exception.LyricsException;
import org.openlyrics.jlyrics.hymnbook.Hymnbook;
import org.openlyrics.jlyrics.hymnbook.Hymnbooks;
import org.openlyrics.jlyrics.reader.OpenLyricsReader;

import java.io.*;
import java.nio.charset.StandardCharsets;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.*;
import java.util.regex.Matcher;
import java.util.regex.Pattern;
import java.util.stream.Collectors;
import java.util.stream.Stream;

import static org.openlyrics.jlyrics.util.SongUtils.*;

public class Validator {

    private final Hymnbooks hymnbooks = new Hymnbooks();
    private final List<IValidator> validators = new ArrayList<>();
    private final List<IGenerator> generators = new ArrayList<>();
    private List<String> songPaths = new ArrayList<>();
    private final List<String> invalidSongs = new ArrayList<>();
    private boolean partialValidation = false;

    public static void main(String[] args) {
        new Validator().validate();
    }

    private void validate() {
        try {
            invalidSongs.clear();

            System.out.println("Read hymnbooks data...");
            readHymnbooks();

            //TODO: check only selected songs not all
            System.out.println("Load paths for affected songs...");
            loadSongPaths();

            System.out.println("Initialize validators...");
            addValidators();
            validators.forEach(IValidator::init);

            System.out.println("Initialize generators...");
            addGenerators();
            generators.forEach(g -> g.init(hymnbooks));

            OpenLyricsReader xmlReader = new OpenLyricsReader();

            for (String path: songPaths) {
                System.out.print("    " + path + "...");

                Song song = xmlReader.read(this.getClass().getClassLoader().getResourceAsStream(path));

                List<String> errors = new ArrayList<>();
                for (IValidator validator: validators) {
                    try {
                        validator.checkValidity(path, song);
                    } catch (LyricsException e) {
                        errors.add(e.getMessage());
                    }
                }

                generators.forEach(g -> g.add(path, song));

                if (!errors.isEmpty()) {
                    invalidSongs.add(path);
                    System.out.println("\n      " + String.join("\n", errors).replaceAll("\n", "\n      "));
                } else {
                    System.out.println("ok");
                }
            }

            if (!partialValidation) {
                validators.forEach(IValidator::close);
            }
            generators.forEach(IGenerator::close);

            //dump songpaths, on error just invalid songs
            List<String> dumpSonglist = invalidSongs.isEmpty() ? songPaths : invalidSongs;
            String songlist = "[\n  \"" + String.join("\",\n  \"", dumpSonglist) + "\"\n]\n";
            Files.write(Paths.get("songlist.json"), songlist.getBytes(StandardCharsets.UTF_8));

        } catch (Exception e) {
            System.out.println(e.getMessage());
        }
    }

    private void readHymnbooks() throws IOException {
        InputStream is = this.getClass().getClassLoader().getResourceAsStream("hymnbooks.json");
        if (is != null) {
            hymnbooks.loadFromJson(is);
            is.close();
        }
    }

    private void addValidators() {
        validators.add(new XmlValidator());
        validators.add(new SyllableValidator());
        validators.add(new WidthValidator());
    }

    private void addGenerators() {
        generators.add(new WordlistGenerator());
        if (!partialValidation) {
            generators.add(new ContentsGenerator());
            generators.add(new IndexGenerator());
        }
    }

    private void loadSongPaths() {
        if (new File("songlist.json").isFile()) {
            //load filelist
            partialValidation = true;
            try (FileInputStream is = new FileInputStream("songlist.json")) {
                ObjectMapper mapper = new ObjectMapper();
                CollectionType typeReference = TypeFactory.defaultInstance().constructCollectionType(List.class, String.class);
                songPaths = mapper.readValue(is, typeReference);
                //use just the existing files
                songPaths = songPaths.stream()
                        .filter(p ->new File("src/main/resources/" + p).isFile())
                        .collect(Collectors.toList());

                if (songPaths.isEmpty()) {
                    loadSongPathsFromGitStatus();
                }
            } catch (IOException e) {
                throw new RuntimeException(e);
            }

        } else {
            //all xml file from resources
            partialValidation = false;
            for (Hymnbook book: hymnbooks) {
                try (InputStream is = this.getClass().getClassLoader().getResourceAsStream(book.getFolder() + "/")) {
                    if (is != null) {
                        songPaths.addAll(
                            Stream.of(new String(readAllBytes(is))
                                .split("\n"))
                                .map(file -> book.getFolder() + "/" + file)
                                .collect(Collectors.toList())
                        );
                    }
                } catch (Exception e) {
                    throw new LyricsException(e.getMessage());
                }
            }
        }
    }

    private void loadSongPathsFromGitStatus() {
        StringBuilder output = new StringBuilder();
        ProcessBuilder pb = new ProcessBuilder("git", "status");
        pb.redirectErrorStream(true); // STDERR → STDOUT

        try {
            Process process = pb.start();

            try (BufferedReader reader = new BufferedReader(new InputStreamReader(process.getInputStream()))) {

                String line;
                while ((line = reader.readLine()) != null) {
                    output.append(line).append(System.lineSeparator());
                }
            }

            int exitCode = process.waitFor();
            if (exitCode != 0) {
                throw new RuntimeException("git status exited with code: " + exitCode);
            }
        }
        catch (IOException | InterruptedException e) {
            throw new RuntimeException(("Process error: " + e.getMessage()));
        }

        String[] patterns = {
                "new file:   src\\/main\\/resources\\/(.*\\.xml)",
                "modified:   src\\/main\\/resources\\/(.*\\.xml)",
                "\\tsrc\\/main\\/resources\\/(.*\\.xml)"
        };

        for (String patternString: patterns) {
            Pattern pattern = Pattern.compile(patternString);
            Matcher matcher = pattern.matcher(output.toString());

            while (matcher.find()) {
                songPaths.add(matcher.group(1));
            }
        }

        Collections.sort(songPaths);
    }
}
