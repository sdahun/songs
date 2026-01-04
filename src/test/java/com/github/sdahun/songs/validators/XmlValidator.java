package com.github.sdahun.songs.validators;

import com.thaiopensource.util.PropertyMapBuilder;
import com.thaiopensource.validate.Flag;
import com.thaiopensource.validate.ValidateProperty;
import com.thaiopensource.validate.ValidationDriver;
import com.thaiopensource.validate.prop.rng.RngProperty;
import org.openlyrics.jlyrics.Song;
import org.openlyrics.jlyrics.exception.LyricsException;
import org.xml.sax.InputSource;
import org.xml.sax.SAXException;

import java.io.IOException;
import java.io.InputStream;

public class XmlValidator implements IValidator {
    private ValidationDriver validationDriver;
    private ValidationHandler handler;

    @Override
    public void init() {
        handler = new ValidationHandler();

        PropertyMapBuilder pmb = new PropertyMapBuilder();
        pmb.put(ValidateProperty.ERROR_HANDLER, handler);
        pmb.put(RngProperty.CHECK_ID_IDREF, Flag.PRESENT);

        validationDriver = new ValidationDriver(pmb.toPropertyMap());
        try (InputStream is = this.getClass().getClassLoader().getResourceAsStream("schema/openlyrics-0.8.rng")) {
            validationDriver.loadSchema(new InputSource(is));
        } catch (IOException | SAXException e) {
            throw new LyricsException(e.getMessage());
        }
    }

    @Override
    public void checkValidity(String path, Song song) throws LyricsException {
        try {
            if (!validationDriver.validate(new InputSource(this.getClass().getClassLoader().getResourceAsStream(path)))) {
                throw new LyricsException("XML schema validation error! " + String.join("; ", handler.getErrors()));
            }
        } catch (SAXException | IOException e) {
            throw new LyricsException(e.getMessage());
        }
    }

    @Override
    public void close() throws LyricsException {
    }
}
