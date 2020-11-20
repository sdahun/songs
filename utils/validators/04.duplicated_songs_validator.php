<?php

require('duplicate_exceptions.php');

function get_collection_name ($name) {
  switch ($name) {
    case 'Adj zengő éneket!':                         return 'adj_zengo_eneket';
    case 'Baptista gyülekezeti énekeskönyv':          return 'baptista_gyulekezeti_enekeskonyv';
    case 'Dicsérem Neved 1':                          return 'dicserem_neved_1';
    case 'Dicsérem Neved 2':                          return 'dicserem_neved_2';
    case 'Dicsérem Neved 3':                          return 'dicserem_neved_3';
    case 'Dicsérem Neved 4':                          return 'dicserem_neved_4';
    case 'Dicsérem Neved 5':                          return 'dicserem_neved_5';
    case 'Erőm és énekem az Úr':                      return 'erom_es_enekem_az_ur';
    case 'Evangélikus énekeskönyv':                   return 'evangelikus_enekeskonyv';
    case 'Hitünk énekei':                             return 'hitunk_enekei';
    case 'Hozsánna énekes':                           return 'hozsanna';
    case 'Református énekeskönyv':                    return 'reformatus_enekeskonyv';
    case 'Szent az Úr':                               return 'szent_az_ur';
    case 'Üdv- és adventi énekek':                    return 'udv_es_adventi_enekek';
    case 'Zuglói Adventista Gyülekezeti Énekeskönyv': return 'zugloi_adventista_gyulekezeti_enekeskonyv';
  }
  echo('Unknown book! '.$name."\n");
  exit;
}


$invalid_count = 0;
echo("Validate duplicated songs...\n");

$songtitles = [];

foreach (glob (COLLECTIONS_PATH . '/*') as $collection) {
  if (!is_dir($collection)) continue;

  foreach( glob ($collection.'/*.xml') as $file) {
    $xml = simplexml_load_string (str_replace ('xmlns=', 'ns=', file_get_contents($file)));
    $title = $xml->properties->titles->title[0]->__toString();
    $books = [];
    foreach($xml->properties->songbooks->songbook as $sb) {
      $books[] = 
        COLLECTIONS_PATH . '/' .
        get_collection_name($sb['name']->__toString()) . '/' .
        sprintf("%03d", $sb['entry']->__toString()) . '.xml';
    }
    $songtitles[$title][] = ['file' => $file, 'books' => $books];
  }
}  

foreach ($songtitles as $title => $entries) {
  if (count ($entries) < 2) continue;

  foreach ($entries as $search_in) {
    foreach ($entries as $search_for) {
      $search_in_file = basename(dirname($search_in['file'])).'/'.basename($search_in['file']);
      $search_for_file = basename(dirname($search_for['file'])).'/'.basename($search_for['file']);
      if (isset($duplicate_exceptions[$search_in_file])) {
        if ($duplicate_exceptions[$search_in_file] == $search_for_file)
          continue;
      }
      if (!in_array($search_for['file'], $search_in['books'])) {
        ++$invalid_count;
        echo('The "' . $title . '" song can be found in' . "\n".
          $search_for['file']."\n".
          "but it is not mentioned in\n".
          $search_in['file']."\n".
          str_repeat('-',30)."\n");
      }
    }
  }
}

echo("The validation of duplication has been finished.\n");

if ($invalid_count > 0)
  throw new Exception('There were '.$invalid_count.' duplication validation error'.($invalid_count > 1 ? 's' : '').'!');
