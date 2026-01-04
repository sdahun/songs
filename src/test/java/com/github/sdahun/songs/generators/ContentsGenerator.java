package com.github.sdahun.songs.generators;

import org.openlyrics.jlyrics.Song;
import org.openlyrics.jlyrics.exception.LyricsException;
import org.openlyrics.jlyrics.hymnbook.Hymnbook;
import org.openlyrics.jlyrics.hymnbook.Hymnbooks;
import org.openlyrics.jlyrics.song.properties.Songbook;

import java.io.FileOutputStream;
import java.nio.charset.StandardCharsets;
import java.util.Optional;

public class ContentsGenerator implements IGenerator {
    private Hymnbooks hymnbooks;
    private final StringBuilder contents = new StringBuilder();
    private Hymnbook lastHymnbook;
    private int outsideCounter = 0;

    @Override
    public void init(Hymnbooks hymnbooks) {
        this.hymnbooks = hymnbooks;
        lastHymnbook = new Hymnbook();
        contents.append("# Tartalomjegyzék\n");
    }

    @Override
    public void add(String path, Song song) {
        Songbook songbook = song.getProperties().getSongbooks().isEmpty() ?
                new Songbook().setName("Énekeskönyvön kívüli énekek").setEntry(String.valueOf(++outsideCounter)) :
                song.getProperties().getSongbooks().get(0);

        Hymnbook thisHymnbook = Optional.ofNullable(hymnbooks.getHymnbookByName(songbook.getName()))
                        .orElse(hymnbooks.get(hymnbooks.size()-1));

        if (!thisHymnbook.equals(lastHymnbook)) {
            lastHymnbook = thisHymnbook;
            contents
                .append("\n## ")
                .append(thisHymnbook.getName())
                .append(" (/")
                .append(thisHymnbook.getFolder())
                .append(")\n\n| Ssz. | Az ének címe/kezdete |\n| ---: | :------------------- |\n");
        }

        contents
            .append("| ")
            .append(songbook.getEntry())
            .append(". | [")
            .append(song.getProperties().getTitles().get(0).getTitle())
            .append("](./src/main/resources/")
            .append(path)
            .append(") |\n");
    }

    @Override
    public void close() throws LyricsException {
        try (FileOutputStream contentsFOS = new FileOutputStream("Contents.md")) {
            contentsFOS.write(contents.toString().getBytes(StandardCharsets.UTF_8));
        } catch (Exception e) {
            throw new LyricsException(e.getMessage());
        }
    }
}
