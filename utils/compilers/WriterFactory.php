<?php

namespace sdahun\songs;

class WriterFactory {
    public static function getWriter ($prefs) {
        switch ($prefs->get ('output_format')) {
            case 1: return new \sdahun\songs\writer\OpenLPWriter ($prefs);
            case 2: return new \sdahun\songs\writer\QueleaWriter ($prefs);
            case 3: return new \sdahun\songs\writer\FreeWorshipWriter ($prefs);
            case 4: return new \sdahun\songs\writer\EasyWorshipWriter ($prefs);
            case 5: return new \sdahun\songs\writer\PowerPointWriter ($prefs);
            case 6: return new \sdahun\songs\writer\TextWriter ($prefs);
            case 7: return new \sdahun\songs\writer\SongBookWriter ($prefs);
            default: throw new \Exception('Writer format not found for '. $formatId . '!');
        }
    }
}
