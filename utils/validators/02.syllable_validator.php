<?php

require(dirname(__FILE__).'/syllable_exceptions.php');


function get_inner_xml($str) {
  $from = strpos($str, '>') + 1;
  $to = strrpos($str, '<');
  return substr($str, $from, $to-$from);
}


$invalid_count = 0;
echo("Validate syllables in verses...\n");
foreach ($all_files as $collection_path => $collection_files) {

  echo('  Validating '.basename($collection_path)."...\n");
  foreach ($collection_files as $file) {
    if (!file_exists($file)) continue;

    $xml = simplexml_load_string (str_replace ('xmlns=', 'ns=', file_get_contents($file)));
    $display_file = basename(dirname($file)).'/'.basename($file);
    $syllables = [];
    $verses = $xml->xpath ('/song/lyrics/verse');

    foreach ($verses as $verse) {
      $versetype = substr($verse['name'],0,1);
      //we only check "verse" type
      if ($versetype != 'v') continue;

      $lines = explode('<br/>', get_inner_xml($verse->lines->asXML()));
      $linescount = count($lines);

      if (count($syllables) == 0) {
        //add this verse to syllables
        for ($i = 0; $i < $linescount; $i++) {
          preg_match_all('/(*UTF8)[aáeéiíoóöőuúüű]/i', $lines[$i], $matches);
          $syllables[] = count($matches[0]);
        }
      }
      else {
        //compare lines count
        if ($linescount != count($syllables)) {
          if (!in_array( ($display_file . ';' . $verse['name']), $linecount_exceptions)) {
            ++$invalid_count;
            echo("  The number of lines is not matching in " . $verse['name'] . "!\n".
                 "    File: " . $display_file . "\n\n");
          }
        }
        else {
          //check syllables line-by-line
          for ($i = 0; $i < $linescount; $i++) {
            preg_match_all('/(*UTF8)[aáeéiíoóöőuúüű]/i', $lines[$i], $matches);
            if ($syllables[$i] != count($matches[0])) {
              if (!in_array( ($display_file.';'.$verse['name'].';'.($i+1)), $syllable_exceptions)) {
                ++$invalid_count;
                echo("  ERROR! The number of syllables is different!\n".
                     "    File: " . $display_file . ', '. $verse['name'] . ", line: " . ($i+1) . "!\n".
                     "    This line: " . count($matches[0]) . ', first line: ' . $syllables[$i] ."\n\n");
              }
            }
          }
        }
      }
    }
  }
}

echo("The validation of syllables has been finished.\n");

if ($invalid_count > 0)
  throw new Exception('There were '.$invalid_count.' syllable validation error'.($invalid_count > 1 ? 's' : '').'!');
