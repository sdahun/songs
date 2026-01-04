package com.github.sdahun.songs.validators;

import org.openlyrics.jlyrics.Song;
import org.openlyrics.jlyrics.exception.LyricsException;
import org.openlyrics.jlyrics.song.lyrics.ILyricsEntry;
import org.openlyrics.jlyrics.song.lyrics.Verse;
import org.openlyrics.jlyrics.song.lyrics.VerseLine;
import org.openlyrics.jlyrics.song.lyrics.linepart.ILinePart;
import org.openlyrics.jlyrics.song.lyrics.linepart.Text;

import javax.swing.*;
import java.awt.*;
import java.awt.font.FontRenderContext;
import java.awt.geom.AffineTransform;
import java.io.File;
import java.util.ArrayList;
import java.util.List;

public class WidthValidator implements IValidator {
    FontRenderContext frc;
    Font font;

    @Override
    public void init() throws LyricsException {
        try {
            AffineTransform affineTransform = new AffineTransform();
            frc = new FontRenderContext(affineTransform, true, true);
            Font baseFont = Font.createFont(Font.TRUETYPE_FONT, new File("c:/Users/Zsolt/.fonts/MinionPro-Bold.otf"));
            font = baseFont.deriveFont(Font.BOLD, 48f);
        } catch (Exception e) {
            throw new LyricsException(e.getMessage());
        }
    }

    @Override
    public void checkValidity(String path, Song song) throws LyricsException {
        List<String> errors = new ArrayList<>();

        for (ILyricsEntry entry: song.getLyrics()) {
            if (entry instanceof Verse) {
                Verse verse = (Verse) entry;
                for (VerseLine line: verse.getLines()) {
                    for (ILinePart part: line.getParts()) {
                        if (part instanceof Text) {
                            Text text = (Text) part;
                            long width = Math.round(font.getStringBounds(text.getContent(), frc).getWidth() * 1.33d);
                            if (width > 1024) {
                                errors.add(
                                    "Túl hosszú sor! "+ verse.getName() + ": " + text.getContent() + "; Hossz:" + width);
                            }
                            //System.out.println(width + ":" + text.getContent());
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

    }
}
