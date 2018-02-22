<?php

$contents = '';
$rootpath = realpath (__DIR__ . '/..');
$basepath =  $rootpath . '/collections';

foreach (glob ($basepath . '/*') as $collection) {
  if (!is_dir ($collection)) continue;

  $songbook = '';
  foreach (glob ($collection . '/*.xml') as $songfile) {
    $xml = simplexml_load_string(str_replace('xmlns=', 'ns=', file_get_contents($songfile)));

    $sb = $xml->properties->songbooks->songbook[0];
    $songnumber = $sb['entry'];
    if ($songbook == '') {
        $songbook = $sb['name']->__toString();
        $contents .= '# ' . $songbook . "\n\n| Az ének címe/kezdete | Sorszáma |\n| :------------------- | -------: |\n";
    }

    $title = $xml->properties->titles->title[0]->__toString();
    $contents .= '| ' . $title . ' | ' . $songnumber . " |\n";
  }
  $contents .= "\n";
}

file_put_contents($rootpath . '/Contents.md', $contents);
echo("Contents (re)generated successfully!\n");
