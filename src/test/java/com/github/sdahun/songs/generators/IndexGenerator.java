package com.github.sdahun.songs.generators;

import lombok.Data;
import lombok.experimental.Accessors;
import org.openlyrics.jlyrics.Song;
import org.openlyrics.jlyrics.exception.LyricsException;
import org.openlyrics.jlyrics.hymnbook.Hymnbook;
import org.openlyrics.jlyrics.hymnbook.Hymnbooks;
import org.openlyrics.jlyrics.song.properties.Songbook;
import org.openlyrics.jlyrics.song.properties.Theme;

import java.io.FileOutputStream;
import java.nio.charset.StandardCharsets;
import java.util.*;

public class IndexGenerator implements IGenerator {
    private Hymnbooks hymnbooks;
    private Map<Hymnbook, List<SongTheme>> indices;
    private int outsideCounter = 0;

    @Override
    public void init(Hymnbooks hymnbooks) {
        this.hymnbooks = hymnbooks;
        indices = new TreeMap<>(Comparator.comparing(Hymnbook::getName));
    }

    @Override
    public void add(String path, Song song) {
        //pick up only if it has themes
        if (song.getProperties().getThemes().isEmpty()) {
            return;
        }

        Songbook songbook = song.getProperties().getSongbooks().isEmpty() ?
                new Songbook().setName("Énekeskönyvön kívüli énekek").setEntry(String.valueOf(++outsideCounter)) :
                song.getProperties().getSongbooks().get(0);

        Hymnbook hymnbook = Optional.ofNullable(hymnbooks.getHymnbookByName(songbook.getName()))
                .orElse(hymnbooks.get(hymnbooks.size()-1));

        SongData songData = new SongData()
                .setNumber(songbook.getEntry())
                .setTitle(song.getProperties().getTitles().get(0).getTitle())
                .setPath("src/main/resources/" + path);

        indices.computeIfAbsent(hymnbook, k -> new ArrayList<>());

        List<SongTheme> songThemes = indices.get(hymnbook);

        for (Theme theme: song.getProperties().getThemes()) {
            SongTheme songTheme = songThemes.stream()
                    .filter(x -> x.getTheme().equals(theme.getTheme()))
                    .findFirst()
                    .orElse(null);

            if (songTheme == null) {
                songTheme = new SongTheme().setTheme(theme.getTheme());
                songThemes.add(songTheme);
            }

            songTheme.getSongs().add(songData);
        }
    }

    @Override
    public void close() throws LyricsException {
        //build README.md
        StringBuilder sb = new StringBuilder();
        sb.append("# Énekeskönyvek tárgymutatói\n\n");


        for (Hymnbook book: indices.keySet()) {
            sb.append("* [")
                .append(book.getName())
                .append("](")
                .append(book.getFolder())
                .append("_index.md)\n");
        }

        try (FileOutputStream fos = new FileOutputStream("docs/index/README.md")) {
            fos.write(sb.toString().getBytes(StandardCharsets.UTF_8));
        } catch (Exception e) {
            throw new LyricsException(e.getMessage());
        }

        //build songbooks indices
        for (Map.Entry<Hymnbook, List<SongTheme>> entry: indices.entrySet()) {
            StringBuilder index = new StringBuilder();
            index.append("# ")
                .append(entry.getKey().getName())
                .append(" - Tárgymutató\n");

            entry.getValue().sort(Comparator.comparing(SongTheme::getTheme));

            for (SongTheme theme: entry.getValue()) {
                index.append("\n## ")
                    .append(theme.getTheme())
                    .append("\n\n")
                    .append("| Ssz. | Az ének címe/kezdete |\n")
                    .append("| ---: | :------------------- |\n");

                theme.getSongs().sort(Comparator.comparing(SongData::getPath));

                for (SongData data: theme.getSongs()) {
                    index.append("| ")
                        .append(data.getNumber())
                        .append(" | [")
                        .append(data.getTitle())
                        .append("](../../")
                        .append(data.getPath())
                        .append(")|\n");
                }
            }

            try (FileOutputStream fos = new FileOutputStream("docs/index/" + entry.getKey().getFolder() + "_index.md")) {
                fos.write(index.toString().getBytes(StandardCharsets.UTF_8));
            } catch (Exception e) {
                throw new LyricsException(e.getMessage());
            }
        }
    }

    @Data
    @Accessors(chain = true)
    class SongTheme {
        private String theme;
        private List<SongData> songs = new ArrayList<>();
    }

    @Data
    @Accessors(chain = true)
    class SongData {
        private String number;
        private String title;
        private String path;
    }
}
