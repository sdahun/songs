package com.github.sdahun.songs.generators;

import org.openlyrics.jlyrics.Song;
import org.openlyrics.jlyrics.exception.LyricsException;
import org.openlyrics.jlyrics.hymnbook.Hymnbooks;

import java.io.FileOutputStream;
import java.nio.charset.StandardCharsets;
import java.util.HashMap;
import java.util.Map;
import java.util.Set;

import static org.openlyrics.jlyrics.util.SongUtils.extractWords;

public class WordlistGenerator implements IGenerator {
    private Map<String, Set<String>> wordlist;

    @Override
    public void init(Hymnbooks hymnbooks) {
        wordlist = new HashMap<>();
    }

    @Override
    public void add(String path, Song song) {
        extractWords(song, wordlist, "hu");
    }

    @Override
    public void close() throws LyricsException {
        try {
            for (String lang :wordlist.keySet()) {
                FileOutputStream fos = new FileOutputStream("wordlist-" + lang + ".txt");
                fos.write(String.join("\n", wordlist.get(lang)).getBytes(StandardCharsets.UTF_8));
                fos.close();
            }
        } catch (Exception e) {
            throw new LyricsException(e.getMessage());
        }
    }
}
