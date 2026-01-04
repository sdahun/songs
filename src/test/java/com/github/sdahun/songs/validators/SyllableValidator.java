package com.github.sdahun.songs.validators;

import com.fasterxml.jackson.databind.ObjectMapper;
import com.fasterxml.jackson.databind.type.CollectionType;
import com.fasterxml.jackson.databind.type.TypeFactory;
import org.openlyrics.jlyrics.Song;
import org.openlyrics.jlyrics.exception.LyricsException;
import org.openlyrics.jlyrics.song.lyrics.ILyricsEntry;
import org.openlyrics.jlyrics.song.lyrics.Verse;

import java.io.IOException;
import java.io.InputStream;
import java.util.*;

import static org.openlyrics.jlyrics.util.SongUtils.getVerseTextContent;

public class SyllableValidator implements IValidator {
    private Set<String> syllableExceptions = new HashSet<>();
    private Set<String> linecountExceptions = new HashSet<>();

    public SyllableValidator() {
        try {
            readSyllableExceptions();
            readLineCountExceptions();
        } catch (Exception e) {
            System.out.println("Can't load exception resources for syllable checking...");
        }
    }

    private void readSyllableExceptions() throws IOException {
        InputStream is = this.getClass().getClassLoader().getResourceAsStream("syllable_exceptions.json");
        if (is != null) {
            ObjectMapper mapper = new ObjectMapper();
            CollectionType typeReference = TypeFactory.defaultInstance().constructCollectionType(Set.class, String.class);
            syllableExceptions = mapper.readValue(is, typeReference);
            is.close();
        }
    }

    private void readLineCountExceptions() throws IOException {
        InputStream is = this.getClass().getClassLoader().getResourceAsStream("linecount_exceptions.json");
        if (is != null) {
            ObjectMapper mapper = new ObjectMapper();
            CollectionType typeReference = TypeFactory.defaultInstance().constructCollectionType(Set.class, String.class);
            linecountExceptions = mapper.readValue(is, typeReference);
            is.close();
        }
    }

    @Override
    public void init() {
        //
    }

    @Override
    public void checkValidity(String path, Song song) throws LyricsException {
        Map<Integer, Integer> syllablesPerLine = new HashMap<>();
        List<String> errors = new ArrayList<>();

        for (ILyricsEntry entry : song.getLyrics()) {
            if (entry instanceof Verse) {
                Verse verse = (Verse) entry;
                //check only verses, omit chorus, bridge, etc.
                if (verse.getName().charAt(0) != 'v') continue;

                String[] lines = getVerseTextContent(verse, false).split("\n");
                if (syllablesPerLine.isEmpty()) {
                    //collect syllables
                    for (int i = 0; i < lines.length; i++) {
                        //count only syllables
                        syllablesPerLine.put(i, lines[i].replaceAll("[^aeiouáéíóöőúüűAEIOUÁÉÍÓÖŐÚÜŰ]", "").length());
                    }
                } else {
                    //compare lines count
                    if (syllablesPerLine.size() != lines.length) {
                        String diffIdentity = path + ";" + verse.getName();
                        if (!linecountExceptions.contains(diffIdentity)) {
                            errors.add("Sorok száma eltérés! " + diffIdentity);
                        } else {
                            linecountExceptions.remove(diffIdentity);
                        }
                    } else {
                        //compare syllables
                        for (int i = 0; i < lines.length; i++) {
                            if (syllablesPerLine.get(i) != lines[i].replaceAll("[^aeiouáéíóöőúüűAEIOUÁÉÍÓÖŐÚÜŰ]", "").length()) {
                                String diffIdentity = path + ";" + verse.getName() + ";" + (i+1);
                                if (!syllableExceptions.contains(diffIdentity)) {
                                    errors.add("Mássalhangó eltérés! " + diffIdentity);
                                } else {
                                    syllableExceptions.remove(diffIdentity);
                                }
                            }
                        }
                    }
                }
            }
        }
        if (!errors.isEmpty()) {
            throw new LyricsException(String.join("\n", errors));
        }
    }

    @Override
    public void close() throws LyricsException {
        if (!syllableExceptions.isEmpty()) {
            throw new LyricsException("Az alábbi magánhangzó-kivételek feleslegesek!\n"+String.join("\n", syllableExceptions));
        }

        if (!linecountExceptions.isEmpty()) {
            throw new LyricsException("Az alábbi sorok száma eltérés-kivételek feleslegesek!\n"+String.join("\n", linecountExceptions));
        }
    }
}
