<?php

namespace sdahun\songs\converter;

use \DomDocument;
use \sdahun\songs\Preferences;
use \sdahun\songs\Collections;
use \sdahun\songs\converter\General;

class XmlConfigurator {

    public static function configure($xmlstr, Preferences $prefs) {
        $xml = new DomDocument;
        $xml->preserveWhiteSpace = false;
        $xml->formatOutput = true;
        $xml->loadXml($xmlstr);

        $lyricsXml = '';
        $verseOrder = $xml->getElementsByTagName('verseOrder')[0]->nodeValue;

        //intro slide
        if ($prefs->get('intro_slide')) {
            $lyricsXml .= 
                '<verse name="i1"><lines>' .
                $xml->getElementsByTagName('title')[0]->nodeValue;

            if (!in_array(substr($lyricsXml, -1), ['!', '?']))
                $lyricsXml .= '...';

            if ($prefs->get('intro_songbook')) {
                $songbook = $xml->getElementsByTagName('songbook')[0];

                $lyricsXml .= '<br/><br/>' . $songbook->getAttribute('name');

                if ($prefs->get('intro_songnumber'))
                    $lyricsXml .= '<br/>' . $songbook->getAttribute('entry') . '. ének';
            }

            $lyricsXml .= '</lines></verse>';

            $xml->getElementsByTagName('verseOrder')[0]->nodeValue = 'i1 ' . $verseOrder;
        }

        //pick up all verses
        $verses = [];
        foreach ($xml->getElementsByTagName('verse') as $verseNode)
            $verses [$verseNode->getAttribute('name')] = General::getInnerXml($xml->saveXML($verseNode->firstChild));

        //remove all nodes
        $xml->getElementsByTagName('lyrics')[0]->nodeValue = '';

        //add verses in verseOrder order
        $added = [];
        foreach (explode (' ', $verseOrder) as $verse) {
            if (!$prefs->get('song_repeat_verses') && in_array($verse, $added)) continue;
            $added[] = $verse;

            $lyricsXml .= '<verse name="' . $verse . '"><lines>';

            $lines = explode('<br/>', $verses[$verse]);

            if ($prefs->get('song_linebreak')) {
                if ($prefs->get('song_ucfirst'))
                    array_walk($lines, 
                        function (&$item, $key) {
                            $item = mb_convert_case(mb_substr ($item, 0, 1), MB_CASE_UPPER) . mb_substr($item, 1);
                        }
                    );
                $lyricsXml .= implode('<br/>', $lines);
            }
            else {
                if ($prefs->get('song_separator'))
                    $lyricsXml .= implode(' / ', $lines);
                else
                    $lyricsXml .= implode(' ', $lines);
            }

            $lyricsXml .= '</lines></verse>';
        }

        //tag slide
        if ($prefs->get('tag_slide')) {
            $lyricsXml .= '<verse name="t1"><lines>';

            if ($prefs->get('quick_search')) {
                $songbook = $xml->getElementsByTagName('songbook')[0];
                $lyricsXml .= 
                    Collections::getQuickSearchName ($songbook->getAttribute('name')) .
                    sprintf('%03d', $songbook->getAttribute('entry'));
            }
            $lyricsXml .= '</lines></verse>';
        }

        //append all lyrics
        $lyrics = $xml->createDocumentFragment();
        $lyrics->appendXML($lyricsXml);
        $xml->getElementsByTagName('lyrics')[0]->appendChild($lyrics);

        //nice output format
        $xml->loadXml($xml->saveXML());

        return $xml->saveXML();
    }
}