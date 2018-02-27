<?php

namespace sdahun\songs\converter;

use \Exception;
use \SimpleXmlElement;
use \sdahun\songs\Preferences;
use \sdahun\songs\Collections;

class Xml2Txt {
    static public function convert($xmlsrc, Preferences $prefs) {
        $xml = new SimpleXmlElement($xmlsrc);

        $result = '';
        if ($prefs->get('intro_slide')) {
            $title = $xml->properties->titles->title[0]->__toString();

            if (!in_array(substr($title, -1), ['!', '?']))
                $title .= '...';

            $result .= "Intro\r\n" . $title . "\r\n";

            if ($prefs->get('intro_songbook')) {
                $result .= "\n" . $xml->properties->songbooks->songbook[0]['name']->__toString() . "\r\n";

                if ($prefs->get('intro_songnumber')) {
                    $result .= $xml->properties->songbooks->songbook[0]['entry']->__toString() . ". ének\r\n";
                }
            }
            $result .= "\r\n";
        }

        $verses = [];
        foreach ($xml->lyrics->verse as $verse) {
            $verseName = $verse['name']->__toString();
            $verseText = self::getInnerXml($verse->lines->asXml());
            $verses[$verseName] = $verseText;
        }

        $added = [];
        foreach (explode (' ', $xml->properties->verseOrder->__toString()) as $verse) {
            if (!$prefs->get('song_repeat_verses') && in_array($verse, $added)) continue;
            $added[] = $verse;
            $result .= self::getVerseName (substr ($verse, 0, 1)) . ' ' . substr ($verse, 1)."\r\n";

            $lines = explode('<br/>', $verses[$verse]);

            if ($prefs->get('song_linebreak')) {
                if ($prefs->get('song_ucfirst'))
                    array_walk($lines, 
                        function (&$item, $key) {
                            $item = mb_convert_case(mb_substr ($item, 0, 1), MB_CASE_UPPER) . mb_substr($item, 1);
                        }
                    );
                $result .= implode("\r\n", $lines) . "\r\n\r\n";
            }
            else {
                if ($prefs->get('song_separator'))
                    $result .= implode(' / ', $lines) . "\r\n\r\n";
                else
                    $result .= implode(' ', $lines) . "\r\n\r\n";
            }
        }

        if ($prefs->get('tag_slide')) {
            $result .= "Tag\n";
            if ($prefs->get('quick_search'))
                $result .= Collections::getQuickSearchName($xml->properties->songbooks->songbook[0]['name']) .
                           sprintf('%03d', $xml->properties->songbooks->songbook[0]['entry']) . "\n";
        }

        return iconv('utf-8', 'windows-1250', $result);
    }

    static private function getInnerXml($str) {
        $from = strpos($str, '>') + 1;
        $to = strrpos($str, '<');
        return substr($str, $from, $to-$from);
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
            default: throw new Exception('Please add more type: „' . $name . '” !');
        }
    }
}
