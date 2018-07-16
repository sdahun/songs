<?php

$bible_abbrev = [
  '1Móz', '2Móz',  '3Móz',  '4Móz', '5Móz', 'Józs', 'Bír',  'Ruth',    '1Sám',    '2Sám', '1Kir',
  '2Kir', '1Krón', '2Krón', 'Ezsd', 'Neh',  'Eszt', 'Jób',  'Zsolt',   'Péld',    'Préd', 'Énekek',
  'Ézs',  'Jer',   'JSir',  'Ez',   'Dán',  'Hós',  'Jóel', 'Ám',      'Abd',     'Jón',  'Mik',
  'Náh',  'Hab',   'Zof',   'Hag',  'Zak',  'Mal',  'Mt',   'Mk',      'Lk',      'Jn',   'ApCsel',
  'Róm',  '1Kor',  '2Kor',  'Gal',  'Ef',   'Fil',  'Kol',  '1Thessz', '2Thessz', '1Tim', '2Tim',
  'Tit',  'Filem', 'Zsid',  'Jak',  '1Pt',  '2Pt',  '1Jn',  '2Jn',     '3Jn',     'Júd',  'Jel'
];

$fnames = [];
$book_names = [];

foreach (glob (COLLECTIONS_PATH . '/*') as $collection) {
    if (!is_dir ($collection)) continue;

    $colname = basename ($collection);
    $bible_titles = [];
    $named_titles = [];

    foreach (glob ($collection . '/*.xml') as $file) {

        $xml = simplexml_load_string(str_replace('xmlns=', 'ns=', file_get_contents($file)));

        $book = $xml->properties->songbooks->songbook[0]['name']->__toString();

        if (!isset ($book_names[$colname]))
            $book_names[$colname] = $book;

        if (isset($xml->properties->themes)) {
            foreach($xml->properties->themes->theme as $theme) {
                $th = $theme->__toString();
    
                $is_bible = false;
                foreach ($bible_abbrev as $abbr) {
                    if (substr($th, 0, strlen($abbr)+1) == $abbr.' ') {
                        $is_bible = true;
                        break;
                    }
                }
    
                if ($is_bible) {
                    if (!isset($bible_titles[$abbr]))
                        $bible_titles[$abbr] = [];

                    $bible_titles[$abbr][] = [
                        $th => $xml->properties->titles->title[0]->__toString().
                        ' - '.
                        basename($file, '.xml')
                    ];
                }
                else {
                    if (!isset($named_titles[$th]))
                        $named_titles[$th] = [];

                    $named_titles[$th][] = [
                        'title' => $xml->properties->titles->title[0]->__toString(),
                        'number' => ltrim(basename($file, '.xml'), '0'),
                    ];
                }
            }
        }
    }
    
    if (count ($named_titles) > 0) {
        ksort($named_titles);
        $result = '# ' . $book . " - Tárgymutató\n\n";
        foreach ($named_titles as $theme => $songs) {
            $result .= '## ' . $theme . "\n\n| Ssz. | Az ének címe/kezdete |\n| ---: | :------------------- |\n";

            foreach ($songs as $song) {
                $result .= 
                    '| ' . $song['number'] . ' | [' . $song['title'] .
                    '](../../collections/' . $colname . '/' . sprintf('%03d', $song['number']) . ".xml) |\n";
            }
            $result .= "\n";
        }
        $fname = ROOT_PATH . '/docs/index/' . $colname . '_index.md';
        $fnames[] = $fname;
        file_put_contents($fname, $result);
    }
}

$result = "# Énekeskönyvek tárgymutatói\n\n";

foreach($fnames as $fname) {
    $result .= '* ['.$book_names[basename($fname, '_index.md')].']('.basename($fname).")\n";
}

file_put_contents( ROOT_PATH . '/docs/index/README.md', $result);
echo('Indices (re)generated successfully!'."\n");
