<?php


$invalid_count = 0;
echo("Validate verseorder...\n");
foreach (glob (COLLECTIONS_PATH . '/*') as $collection) {
  if (!is_dir($collection)) continue;
  
  echo('  Validating '.basename($collection)."...\n");
  foreach (glob ($collection . '/*.xml') as $file) {

    $xml = simplexml_load_string (str_replace ('xmlns=', 'ns=', file_get_contents($file)));

    $verseOrder = $xml->properties->verseOrder->__toString();
    $verseOrder = explode(' ', $verseOrder);
    $verseOrder = array_unique($verseOrder);

    $verseTypes = [];
    $verseCount = count($xml->lyrics->verse);
    for ($i=0; $i < $verseCount; $i++)
      $verseTypes[] = $xml->lyrics->verse[$i]['name']->__toString();

    foreach ($verseOrder as $vo)
      if (!in_array($vo, $verseTypes)) {
        ++$invalid_count;
        echo('  The "' . $vo . '" defined in verseOrder, but not found in lyrics!'."\n".
             '    File: '.basename(dirname($file)).'/'.basename($file) . "\n\n");
      }

    foreach ($verseTypes as $vt)
      if (!in_array($vt, $verseOrder)) {
        ++$invalid_count;
        echo('  The "' . $vt . '" defined in lyrics, but not found in verseOrder!'."\n".
             '    File: '.basename(dirname($file)).'/'.basename($file) . "\n\n");
      }
  }
}

echo("The validation of verseorder has been finished.\n");

if ($invalid_count > 0)
  throw new Exception('There were '.$invalid_count.' verseorder validation error'.($invalid_count > 1 ? 's' : '').'!');
