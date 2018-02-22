<?php

$contents = '';
$rootpath = realpath (__DIR__ . '/..');
$basepath =  $rootpath . '/collections';

foreach (glob ($basepath . '/*') as $collection) {
  if (!is_dir ($collection)) continue;

  $bookheader = false;
  foreach (glob ($collection . '/*.xml') as $songfile) {
    $xml = simplexml_load_string(str_replace('xmlns=', 'ns=', file_get_contents($songfile)));

    $sb = $xml->properties->songbooks->songbook[0];
    $songnumber = $sb['entry'];
    if (!$bookheader) {
        $bookheader = true;
        $songbook = $sb['name']->__toString();
        $contents .= 
            '# ' . $sb['name']->__toString() . ' (/' . basename($collection) . ")\n\n" .
            "| Ssz. | Az ének címe/kezdete |\n" .
            "| ---: | :------------------- |\n";
    }

    $title = $xml->properties->titles->title[0]->__toString();
    $contents .= 
      '| ' . $songnumber . '. '.
      '| [' . $title . '](https://github.com/sdahun/songs/blob/master/collections/' . 
      basename($collection) . '/' . basename($songfile) . ") |\n";
  }
  $contents .= "\n";
}

file_put_contents($rootpath . '/Contents.md', $contents);
echo("Contents (re)generated successfully!\n");
