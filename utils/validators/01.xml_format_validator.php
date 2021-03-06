<?php

define ('RNG_PATH', dirname(__FILE__).'/openlyrics-0.8.rng');

$invalid_count = 0;
echo("Validate xml files for openlyrics 0.8 format...\n");

foreach ($all_files as $collection_path => $collection_files) {
  echo('  Validating '.basename($collection_path)."...\n");
  foreach( $collection_files as $file) {
    if (!file_exists($file)) continue;
    $xml = new DOMDocument();
    $xml->load($file);
    if (!$xml->relaxNGValidate(RNG_PATH)) {
      ++$invalid_count;
      echo('  Invalid XML: '.basename(dirname($file)).'/'.basename($file)."\n  ".$lasterror."\n\n");
    }
  }
}

echo("Xml file validation has been finished.\n");

if ($invalid_count > 0)
  throw new Exception('There were '.$invalid_count.' xml validation error'.($invalid_count > 1 ? 's' : '').'!');

