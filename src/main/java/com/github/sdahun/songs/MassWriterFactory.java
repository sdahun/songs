package com.github.sdahun.songs;

import org.openlyrics.jlyrics.IOFactory;
import org.openlyrics.jlyrics.masswriter.IMassWriter;
import org.openlyrics.jlyrics.masswriter.MassWriterType;
import org.openlyrics.jlyrics.transform.SongTransformerConfig;
import org.openlyrics.jlyrics.writer.*;

public class MassWriterFactory {
    public static IMassWriter getMassWriter(OutputType type, SongTransformerConfig config) {
        IMassWriter writer;
        try {
            switch (type) {
                case OPENLP:
                    writer = IOFactory.getNewMassWriter(MassWriterType.OPENLP);
                    writer.init(writer.generateFilename(), null, config);
                    break;
                case FREESHOW:
                    writer = IOFactory.getNewMassWriter(MassWriterType.ZIP);
                    writer.init(writer.generateFilename(), new FreeShowWriter(), config);
                    break;
                case EASYWORSHIP:
                    writer = IOFactory.getNewMassWriter(MassWriterType.EASYWORSHIP);
                    writer.init(writer.generateFilename(), null, config);
                    break;
                case QUELEA:
                    writer = IOFactory.getNewMassWriter(MassWriterType.ZIP).setFileExtension(".qsp");
                    writer.init(writer.generateFilename(), new QueleaWriter(), config);
                    break;
                case OPENLYRICS:
                    writer = IOFactory.getNewMassWriter(MassWriterType.ZIP);
                    writer.init(writer.generateFilename(), new OpenLyricsWriter(), config);
                    break;
                case POWERPOINT:
                    writer = IOFactory.getNewMassWriter(MassWriterType.ZIP);
                    writer.init(writer.generateFilename(), new PptxWriter(), config);
                    break;
                case TEXT:
                    writer = IOFactory.getNewMassWriter(MassWriterType.ZIP);
                    writer.init(writer.generateFilename(), new TextWriter(), config);
                    break;
                default: //openlyrics in zip
                    writer = IOFactory.getNewMassWriter(MassWriterType.ZIP);
                    writer.init(writer.generateFilename(), new OpenLyricsWriter(), config);
                    break;
            }
        } catch (Exception e) {
            throw new RuntimeException(e);
        }
        return writer;
    }
}
