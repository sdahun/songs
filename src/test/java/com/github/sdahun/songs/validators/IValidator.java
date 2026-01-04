package com.github.sdahun.songs.validators;

import org.openlyrics.jlyrics.Song;
import org.openlyrics.jlyrics.exception.LyricsException;

public interface IValidator {
    void init() throws LyricsException;
    void checkValidity(String path, Song song) throws LyricsException;
    void close() throws LyricsException;
}
