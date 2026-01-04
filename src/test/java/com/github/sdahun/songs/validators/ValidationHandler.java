package com.github.sdahun.songs.validators;

import org.xml.sax.SAXException;
import org.xml.sax.SAXParseException;
import org.xml.sax.helpers.DefaultHandler;

import java.util.ArrayList;
import java.util.List;

class ValidationHandler extends DefaultHandler {
    private final List<String> errors = new ArrayList<>();

    @Override
    public void fatalError(final SAXParseException ex) {
        add(ex);
    }

    @Override
    public void error(final SAXParseException ex) {
        add(ex);
    }

    @Override
    public void warning(final SAXParseException ex) {
        add(ex);
    }

    void add(final SAXException ex) {
        errors.add(ex.getMessage());
    }

    List<String> getErrors() {
        return errors;
    }
}
