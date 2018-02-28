<?php

namespace sdahun\songs\converter;

use \Exception;
use \SimpleXmlElement;
use \sdahun\songs\converter\General;

class Xml2Txt {
    static public function convert($xmlsrc) {
        $xml = new SimpleXmlElement($xmlsrc);

        $result = '';
        foreach ($xml->lyrics->verse as $verse) {
            $verseName = $verse['name']->__toString();
            $verseText = General::getInnerXml($verse->lines->asXml());
            $result .= self::getVerseName (substr ($verseName, 0, 1)) . ' ' . substr ($verseName, 1)."\r\n";

            //Workaround: double new line means new slide in EasyWorship, but CR-LF-LF will do
            $verseText = str_replace('<br/><br/>', "\r\n\n", $verseText);

            $result .= str_replace('<br/>', "\r\n", $verseText) . "\r\n\r\n";
        }

        //cut down the double new line at the end of result
        return iconv('utf-8', 'windows-1250', substr($result, 0, -2));
    }

    static private function getVerseName($name) {
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
