<?php

$wordlist = [];
echo("Extracting words for manual spellchecking...\n");
foreach (glob (COLLECTIONS_PATH . '/*') as $collection) {
    if (!is_dir($collection)) continue;

    //skip given collection
    if (basename($collection) == 'hitunk_enekei') continue;
  
    echo('  Extracting '.basename($collection)."...\n");
    foreach (glob ($collection . '/*.xml') as $file) {

        $xml = simplexml_load_string (str_replace ('xmlns=', 'ns=', file_get_contents($file)));

        if (count($xml->lyrics->verse) > 0) {
            foreach ($xml->lyrics->verse as $verse) {
                if (isset($verse['lang'])) {
                    if ($verse['lang'] != 'hu') continue;
                }
                $content = $verse->lines->asXML();
                $content = substr($content, strpos($content, '>')+1);
                $content = substr($content, 0, strrpos($content, '<'));
                $content = str_replace(
                    [',', '.', '?', '!',':',';','„','”','(',')','–', '…', '’', "\r\n",'<br/>'],
                    [ '',  '',  '',  '', '', '', '', '', '', '', '',  '',  '',     '',    ' '],
                    $content);
    
                $words = explode(" ", $content);
                $wordcount = count($words);
                for ($wc=0; $wc<$wordcount; $wc++) {
                    if ($words[$wc] == '') continue;
                    $word = mb_convert_case ($words[$wc], MB_CASE_LOWER);
                    if (in_array($word, $wordlist) === false)
                        $wordlist[] = $word;
                }
            }
        }
    }    
}
    
sort($wordlist, SORT_LOCALE_STRING);
    
file_put_contents(COMPILATIONS_PATH . '/wordlist.txt', implode("\r\n", $wordlist));

echo("The extraction of words has been finished.\n");
