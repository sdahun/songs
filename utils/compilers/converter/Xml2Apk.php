<?php

namespace sdahun\songs\converter;

use \Exception;
use \SimpleXmlElement;
use \sdahun\songs\converter\General;

class Xml2Apk {
    public static function convert($xmlsrc) {
        $xml = new SimpleXmlElement($xmlsrc);

        $result = "\xef\xbb\xbf"; //BOM
        $result .= $xml->properties->titles->title[0]->__toString() . str_repeat("\r\n", 9);
        foreach ($xml->lyrics->verse as $verse) {
            $verseName = $verse['name']->__toString();
            $verseType = substr ($verseName, 0, 1);
            $verseNumber = substr ($verseName, 1);
            $result .= ($verseType == "v" ? $verseNumber.'. ' : '') . self::getVerseName ($verseType) ."\r\n";

            $verseText = General::getInnerXml($verse->lines->asXml());
            $result .= str_replace('<br/>', "\r\n", $verseText) . "\r\n\r\n";
        }

        //cut down the double new line at the end of result
        return substr($result, 0, -2);
    }

    private static function getVerseName($name) {
        switch ($name) {
            case 'v': return 'versszak';
            case 'c': return 'Refrén';
            case 'p': return 'Elő-refrén';
            case 'b': return 'Átvezetés';
            case 'e': return 'Lezárás';
            case 'o': return 'Dia';
            case 't': return 'Tag';
            case 'i': return 'Bevezetés';
            default: throw new Exception('Please add more type: "' . $name . '" !');
        }
    }
}
