package com.github.sdahun.songs.generators;

import org.openlyrics.jlyrics.Song;
import org.openlyrics.jlyrics.exception.LyricsException;
import org.openlyrics.jlyrics.hymnbook.Hymnbooks;

public interface IGenerator {
    void init(Hymnbooks hymnbooks);
    void add(String path, Song song);
    void close() throws LyricsException;
}
