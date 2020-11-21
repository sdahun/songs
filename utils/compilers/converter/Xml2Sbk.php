<?php

namespace sdahun\songs\converter;

use \Exception;
use \SimpleXmlElement;
use \sdahun\songs\converter\General;

class Xml2Sbk {
    public static function convert($xmlsrc) {
        $xml = new SimpleXmlElement($xmlsrc);

        $result = '';
        $verseNumber = 1;
        foreach ($xml->lyrics->verse as $verse) {
            $result .= $verseNumber . '. ';
            $verseText = General::getInnerXml($verse->lines->asXml());

            //Workaround: double new line means new slide in EasyWorship, but CR-LF-LF will do
            $verseText = str_replace('<br/><br/>', "\r\n\n", $verseText);

            $result .= str_replace('<br/>', "\r\n", $verseText) . "\r\n";

            $verseNumber++;
        }

        if (isset($xml->properties->authors))
        foreach ($xml->properties->authors->author as $authorObj) {
            if ($authorObj['type']->__toString() == 'words')
                $result .= $authorObj->__toString() . "\r\n";
        }

        //cut down the double new line at the end of result
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
}
