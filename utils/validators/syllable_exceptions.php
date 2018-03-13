<?php

//checked errors, which are errors in the original text, can't fix in text
//format: file;verse
$linecount_exceptions = [
    'szent_az_ur/013.xml;v2',
  ];
  
  //format: file;verse;line
  $syllable_exceptions = [
    'baptista_gyulekezeti_enekeskonyv/217.xml;v2;2',

    'dicserem_neved_2/013.xml;v2;1',
    'dicserem_neved_2/013.xml;v2;2',

    'dicserem_neved_3/002.xml;v2;4',

    'dicserem_neved_4/006.xml;v2;3',
    'dicserem_neved_4/006.xml;v2;6',

    'erom_es_enekem_az_ur/003.xml;v2;3',
    'erom_es_enekem_az_ur/003.xml;v2;4',

    'erom_es_enekem_az_ur/013.xml;v2;1',
    'erom_es_enekem_az_ur/013.xml;v2;2',
    'erom_es_enekem_az_ur/013.xml;v2;3',

    'erom_es_enekem_az_ur/018.xml;v2;1',
    'erom_es_enekem_az_ur/018.xml;v2;2',
    'erom_es_enekem_az_ur/018.xml;v3;2',

    'erom_es_enekem_az_ur/022.xml;v2;1',
    'erom_es_enekem_az_ur/022.xml;v2;2',
    'erom_es_enekem_az_ur/022.xml;v2;3',
    'erom_es_enekem_az_ur/022.xml;v3;1',
    'erom_es_enekem_az_ur/022.xml;v3;2',
    'erom_es_enekem_az_ur/022.xml;v3;3',

    'erom_es_enekem_az_ur/023.xml;v2;1',
    'erom_es_enekem_az_ur/023.xml;v2;2',
    'erom_es_enekem_az_ur/023.xml;v2;4',

    'erom_es_enekem_az_ur/025.xml;v4;1',
    'erom_es_enekem_az_ur/025.xml;v4;2',
    'erom_es_enekem_az_ur/025.xml;v4;4',

    'erom_es_enekem_az_ur/028.xml;v2;1',
    'erom_es_enekem_az_ur/028.xml;v2;2',
    'erom_es_enekem_az_ur/028.xml;v2;5',

    'erom_es_enekem_az_ur/031.xml;v2;2',
    'erom_es_enekem_az_ur/031.xml;v2;4',
    'erom_es_enekem_az_ur/031.xml;v3;2',
    'erom_es_enekem_az_ur/031.xml;v3;4',

    'erom_es_enekem_az_ur/032.xml;v2;1',
    'erom_es_enekem_az_ur/032.xml;v2;2',
    'erom_es_enekem_az_ur/032.xml;v2;3',
    'erom_es_enekem_az_ur/032.xml;v3;1',
    'erom_es_enekem_az_ur/032.xml;v3;3',
    'erom_es_enekem_az_ur/032.xml;v3;4',

    'erom_es_enekem_az_ur/034.xml;v2;2',
    'erom_es_enekem_az_ur/034.xml;v2;3',

    'erom_es_enekem_az_ur/038.xml;v2;2',
    'erom_es_enekem_az_ur/038.xml;v2;3',
    'erom_es_enekem_az_ur/038.xml;v2;4',
    'erom_es_enekem_az_ur/038.xml;v2;6',
    'erom_es_enekem_az_ur/038.xml;v2;8',

    'erom_es_enekem_az_ur/039.xml;v3;5',
    'erom_es_enekem_az_ur/039.xml;v3;6',

    'hozsanna/001.xml;v2;1',
    'hozsanna/001.xml;v2;3',
    'hozsanna/001.xml;v2;4',
    'hozsanna/001.xml;v2;5',
    'hozsanna/001.xml;v2;6',
    'hozsanna/001.xml;v2;7',
    'hozsanna/001.xml;v2;8',

    'hozsanna/002.xml;v2;4',

    'hozsanna/003.xml;v5;3',
    'hozsanna/003.xml;v5;4',
    
    'hozsanna/013.xml;v2;1',
    'hozsanna/013.xml;v2;2',

    'hozsanna/015.xml;v2;3',
    'hozsanna/015.xml;v2;6',

    'hozsanna/018.xml;v2;3',

    'hozsanna/021.xml;v2;1',
    'hozsanna/021.xml;v2;3',

    'hozsanna/023.xml;v2;2',

    'hozsanna/024.xml;v2;2',
    'hozsanna/024.xml;v2;3',
    'hozsanna/024.xml;v2;4',

    'szent_az_ur/001.xml;v2;1',
    'szent_az_ur/001.xml;v2;3',
  
    'szent_az_ur/002.xml;v2;2',
    'szent_az_ur/002.xml;v2;3',
  
    'szent_az_ur/004.xml;v2;3',
    'szent_az_ur/004.xml;v3;3',
    'szent_az_ur/004.xml;v4;3',
  
    'szent_az_ur/005.xml;v2;1',
    'szent_az_ur/005.xml;v3;1',

    'szent_az_ur/007.xml;v2;3',

    'szent_az_ur/009.xml;v2;5',

    'szent_az_ur/010.xml;v2;1',

    'szent_az_ur/011.xml;v2;1',
    'szent_az_ur/011.xml;v2;2',
    'szent_az_ur/011.xml;v2;3',
    'szent_az_ur/011.xml;v2;5',

    'szent_az_ur/012.xml;v2;1',

    'szent_az_ur/022.xml;v2;1',
    'szent_az_ur/022.xml;v2;3',

    'szent_az_ur/026.xml;v2;2',
    'szent_az_ur/026.xml;v3;4',

    'szent_az_ur/027.xml;v2;3',
    'szent_az_ur/027.xml;v2;4',

    'szent_az_ur/028.xml;v2;1',
    'szent_az_ur/028.xml;v3;1',
    'szent_az_ur/028.xml;v3;2',

    'szent_az_ur/031.xml;v2;4',

    'szent_az_ur/038.xml;v2;1',
    'szent_az_ur/038.xml;v2;3',
    
  ];
  
  