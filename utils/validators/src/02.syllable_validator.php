<?php

define ('COLLECTIONS_PATH', realpath (dirname(__FILE__) . '/../../../collections'));

function get_inner_xml($str) {
  $from = strpos($str, '>') + 1;
  $to = strrpos($str, '<');
  return substr($str, $from, $to-$from);
}

$invalid_count = 0;
echo("Validate syllables in verses...\n");
foreach (glob (COLLECTIONS_PATH . '/*') as $collection) {
  if (!is_dir($collection)) continue;
  
  echo('  Validating '.basename($collection)."...\n");
  foreach (glob ($collection . '/*.xml') as $file) {

    $xml = simplexml_load_string (str_replace ('xmlns=', 'ns=', file_get_contents($file)));
    $syllables = [];
    $verses = $xml->xpath ('/song/lyrics/verse');

    foreach ($verses as $verse) {
      $versetype = substr($verse['name'],0,1);
      $lines = explode('<br/>', get_inner_xml($verse->lines->asXML()));
      $linescount = count($lines);

      if (isset($syllables[$versetype])) {
        //existing verse type: compare
        if ($linescount != count($syllables[$versetype])) {
          ++$invalid_count;
          echo("  The number of lines is not matching in " . $verse['name'] . "!\n".
               "    File: " . basename(dirname($file)).'/'.basename($file)."\n\n");
        }
        else {
          for ($i = 0; $i < $linescount; $i++) {
            preg_match_all('/(*UTF8)[aáeéiíoóöőuúüű]/i', $lines[$i], $matches);
            if ($syllables[$versetype][$i] != count($matches[0])) {
              ++$invalid_count;
              echo("  The number of syllables is different in " . $verse['name'] . ", line: " . ($i+1) . "!\n".
                   "    File: " . basename(dirname($file)).'/'.basename($file)."\n".
                   "    There are ". $syllables[$versetype][$i] ." syllables in the same line of the first verse and ".
                   count($matches[0]) ." syllables in this line.\n\n");
            }            
          }
        }
      }
      else {
        //new verse type: add to syllables
        $syllables[$versetype] = [];
        for ($i = 0; $i < $linescount; $i++) {
          preg_match_all('/(*UTF8)[aáeéiíoóöőuúüű]/i', $lines[$i], $matches);
          $syllables[$versetype][] = count($matches[0]);
        }
      }
    }
  }
}

echo("The validation of syllables has been finished.\n");

if ($invalid_count > 0)
  throw new Exception('There were '.$invalid_count.' syllable validation error'.($invalid_count > 1 ? 's' : '').'!');
