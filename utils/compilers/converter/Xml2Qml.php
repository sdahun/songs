<?php

namespace sdahun\songs\converter;

use \Exception;
use \SimpleXmlElement;
use \sdahun\songs\converter\General;

class Xml2Qml {
    public static function convert($xmlsrc) {
        $xml = new SimpleXmlElement($xmlsrc);

        $result = '<song><updateInDB>true</updateInDB>';
        $title = $xml->properties->titles->title[0]->__toString();
        $result .= '<title>' . self::c($title) . '</title>';

        $author = [];
        if (isset($xml->properties->authors))
            foreach ($xml->properties->authors->author as $authorObj)
                $author[] = $authorObj->__toString();

        $author = implode('; ', $author);
        $result .= '<author>' . self::c($author) . '</author>';

        $ccli = $xml->properties->ccliNo->__toString();
        $result .= '<ccli>' . self::c($ccli) . '</ccli>';

        $copyright = $xml->properties->copyright->__toString();
        $result .= '<copyright>' . self::c($copyright) . '</copyright>';

        $result .= '<year></year><publisher></publisher><key></key><capo></capo><notes></notes><lyrics>';

        foreach ($xml->lyrics->verse as $verse) {
            $verseName = $verse['name']->__toString();
            $verseText = General::getInnerXml($verse->lines->asXml());
            $result .= 
                '<section title="' .
                self::getVerseName (substr ($verseName, 0, 1)) . ' ' . self::c(substr ($verseName, 1)) .
                '" capitalise="true">' .
                '<theme>fontname:Noto Sans$translatefontname:Noto Sans$fontcolour:0xffffffff$' .
                'translatefontcolour:0xf5f5f5ff$isFontBold:true$isFontItalic:false$'.
                'isTranslateFontBold:true$isTranslateFontItalic:true$backgroundcolour:0x000000ff$'.
                'shadowcolor:0x000000ff$shadowX:0.0$shadowY:0.0$shadowradius:2.0$shadowspread:0.0$'.
                'shadowuse:true$textposition:-1$textalignment:0</theme>'.
                '<smalllines>' . self::c($title) . "\n" . self::c($author) .
                (strlen($ccli) > 0 ? '('.self::c($ccli).')' : '');
            if (substr($result, -1) != "\n")
                $result .= "\n";
            
            $result .= '</smalllines><lyrics>';

            $verseText = str_replace('<br/><br/>', "\n&#160;\n", $verseText);

            $result .= self::c(str_replace('<br/>', "\n", $verseText)) . "\n</lyrics></section>";
        }

        $result .= '</lyrics><translation></translation><translationoptions></translationoptions></song>';
        return $result;
    }

    private static function getVerseName($name) {
        switch ($name) {
            case 'v': return 'Verse';
            case 'c': return 'Chorus';
            case 'p': return 'Pre-Chorus';
            case 'b': return 'Bridge';
            case 'e': return 'End';
            case 'o': return 'Slide';
            case 't': return 'Tag';
            case 'i': return 'Intro';
            default: throw new Exception('Please add more type: "' . $name . '" !');
        }
    }

    private static function c($str) {
        return mb_encode_numericentity($str, [0x80, 0xffff, 0, 0xffff]);
    }
}
