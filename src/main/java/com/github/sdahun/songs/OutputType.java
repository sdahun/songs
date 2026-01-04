package com.github.sdahun.songs;

import lombok.Getter;

import java.util.Arrays;
import java.util.List;
import java.util.stream.Collectors;

@Getter
public enum OutputType {
    OPENLP("OpenLP (songs.sqlite adatbázisfájlban)"),
    FREESHOW("FreeShow (show fájlok zip fájlban)"),
    EASYWORSHIP("EasyWorship (schedule fájlban)"),
    QUELEA("Quelea Song Pack (.qsp fájlban)"),
    OPENLYRICS("OpenLyrics (xml fájlok zip fájlban)"),
    POWERPOINT("Powerpoint (pptx fájlok zip fájlban)"),
    TEXT("Csak szöveg (txt fájlok zip fájlban)");

    private final String description;

    OutputType(String description) {
        this.description = description;
    }

    public static List<String> getDescriptions() {
        return Arrays.stream(OutputType.values())
            .map(OutputType::getDescription)
            .collect(Collectors.toList());
    }
}
