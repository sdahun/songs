<?php

//checked errors, which are errors in the original text, can't fix in text
//format: file;verse
$linecount_exceptions = [
    'szent_az_ur/013.xml;v2',
    'adj_zengo_eneket/070.xml;v3',
    'adj_zengo_eneket/094.xml;v2',
  ];
  
  //format: file;verse;line
  $syllable_exceptions = [
    'adj_zengo_eneket/011.xml;v2;5',
    'adj_zengo_eneket/011.xml;v3;5',

    'adj_zengo_eneket/013.xml;v2;3',
    'adj_zengo_eneket/013.xml;v3;1',
    'adj_zengo_eneket/013.xml;v3;3',

    'adj_zengo_eneket/019.xml;v2;4',
    'adj_zengo_eneket/019.xml;v2;6',

    'adj_zengo_eneket/022.xml;v2;2',
    'adj_zengo_eneket/022.xml;v3;2',

    'adj_zengo_eneket/024.xml;v2;1',
    'adj_zengo_eneket/024.xml;v2;2',
    'adj_zengo_eneket/024.xml;v2;3',
    'adj_zengo_eneket/024.xml;v3;1',
    'adj_zengo_eneket/024.xml;v3;3',
    'adj_zengo_eneket/024.xml;v3;4',

    'adj_zengo_eneket/027.xml;v2;2',

    'adj_zengo_eneket/028.xml;v2;1',
    'adj_zengo_eneket/028.xml;v2;3',

    'adj_zengo_eneket/032.xml;v2;1',
    'adj_zengo_eneket/032.xml;v2;2',
    'adj_zengo_eneket/032.xml;v2;3',

    'adj_zengo_eneket/035.xml;v2;7',

    'adj_zengo_eneket/048.xml;v2;2',
    'adj_zengo_eneket/048.xml;v2;4',
    'adj_zengo_eneket/048.xml;v2;6',

    'adj_zengo_eneket/050.xml;v2;1',
    'adj_zengo_eneket/050.xml;v2;3',

    'adj_zengo_eneket/058.xml;v2;3',

    'adj_zengo_eneket/059.xml;v3;2',

    'adj_zengo_eneket/061.xml;v2;1',
    'adj_zengo_eneket/061.xml;v2;2',

    'adj_zengo_eneket/063.xml;v2;1',
    'adj_zengo_eneket/063.xml;v2;2',
    'adj_zengo_eneket/063.xml;v2;5',
    'adj_zengo_eneket/063.xml;v2;7',
    'adj_zengo_eneket/063.xml;v2;8',

    'adj_zengo_eneket/068.xml;v6;3',
    'adj_zengo_eneket/068.xml;v6;5',

    'adj_zengo_eneket/070.xml;v3;3',

    'adj_zengo_eneket/071.xml;v2;1',

    'adj_zengo_eneket/073.xml;v2;2',
    'adj_zengo_eneket/073.xml;v2;6',
    'adj_zengo_eneket/073.xml;v2;7',

    'adj_zengo_eneket/076.xml;v2;1',
    'adj_zengo_eneket/076.xml;v3;1',
    'adj_zengo_eneket/076.xml;v3;2',

    'adj_zengo_eneket/077.xml;v5;1',
    'adj_zengo_eneket/077.xml;v5;2',
    'adj_zengo_eneket/077.xml;v5;3',
    'adj_zengo_eneket/077.xml;v5;4',

    'adj_zengo_eneket/078.xml;v2;3',
    'adj_zengo_eneket/078.xml;v3;1',
    'adj_zengo_eneket/078.xml;v3;3',
    'adj_zengo_eneket/078.xml;v4;1',
    'adj_zengo_eneket/078.xml;v4;3',
    'adj_zengo_eneket/078.xml;v5;1',
    'adj_zengo_eneket/078.xml;v5;3',

    'adj_zengo_eneket/079.xml;v2;3',
    'adj_zengo_eneket/079.xml;v2;5',
    'adj_zengo_eneket/079.xml;v4;3',

    'adj_zengo_eneket/086.xml;v2;4',
    'adj_zengo_eneket/086.xml;v3;4',

    'adj_zengo_eneket/087.xml;v2;4',

    'adj_zengo_eneket/088.xml;v2;1',
    'adj_zengo_eneket/088.xml;v2;3',
    'adj_zengo_eneket/088.xml;v2;4',
    'adj_zengo_eneket/088.xml;v3;3',
    'adj_zengo_eneket/088.xml;v3;4',

    'adj_zengo_eneket/089.xml;v2;1',
    'adj_zengo_eneket/089.xml;v2;3',
    'adj_zengo_eneket/089.xml;v3;1',

    'adj_zengo_eneket/091.xml;v2;3',
    'adj_zengo_eneket/091.xml;v3;3',

    'adj_zengo_eneket/094.xml;v3;3',

    'adj_zengo_eneket/096.xml;v2;2',
    'adj_zengo_eneket/096.xml;v2;3',
    'adj_zengo_eneket/096.xml;v2;6',
    'adj_zengo_eneket/096.xml;v2;7',

    'adj_zengo_eneket/097.xml;v2;1',
    'adj_zengo_eneket/097.xml;v2;2',
    'adj_zengo_eneket/097.xml;v2;3',
    'adj_zengo_eneket/097.xml;v2;5',
    'adj_zengo_eneket/097.xml;v2;8',

    'adj_zengo_eneket/103.xml;v2;1',
    'adj_zengo_eneket/103.xml;v2;2',
    'adj_zengo_eneket/103.xml;v2;4',
    'adj_zengo_eneket/103.xml;v2;5',
    'adj_zengo_eneket/103.xml;v2;6',

    'adj_zengo_eneket/108.xml;v2;4',

    'adj_zengo_eneket/109.xml;v2;2',

    'adj_zengo_eneket/113.xml;v2;2',

    'adj_zengo_eneket/114.xml;v2;4',

    'adj_zengo_eneket/115.xml;v2;1',
    'adj_zengo_eneket/115.xml;v2;2',
    'adj_zengo_eneket/115.xml;v3;3',
    'adj_zengo_eneket/115.xml;v4;1',
    'adj_zengo_eneket/115.xml;v4;3',

    'adj_zengo_eneket/118.xml;v2;1',

    'adj_zengo_eneket/119.xml;v3;6',

    'adj_zengo_eneket/128.xml;v2;1',
    'adj_zengo_eneket/128.xml;v2;4',

    'adj_zengo_eneket/129.xml;v2;1',
    'adj_zengo_eneket/129.xml;v2;3',
    'adj_zengo_eneket/129.xml;v2;4',

    'adj_zengo_eneket/137.xml;v2;2',
    'adj_zengo_eneket/137.xml;v2;3',
    'adj_zengo_eneket/137.xml;v2;4',
    'adj_zengo_eneket/137.xml;v2;5',
    'adj_zengo_eneket/137.xml;v2;6',
    'adj_zengo_eneket/137.xml;v3;1',
    'adj_zengo_eneket/137.xml;v3;2',
    'adj_zengo_eneket/137.xml;v3;3',
    'adj_zengo_eneket/137.xml;v3;5',

    'adj_zengo_eneket/139.xml;v2;1',

    'adj_zengo_eneket/141.xml;v2;3',
    'adj_zengo_eneket/141.xml;v2;4',

    'adj_zengo_eneket/144.xml;v2;1',
    'adj_zengo_eneket/144.xml;v2;2',
    'adj_zengo_eneket/144.xml;v2;3',
    'adj_zengo_eneket/144.xml;v2;4',

    'baptista_gyulekezeti_enekeskonyv/217.xml;v2;2',

    'dicserem_neved_1/183.xml;v2;4',

    'dicserem_neved_2/006.xml;v2;2',

    'dicserem_neved_2/009.xml;v2;1',
    'dicserem_neved_2/009.xml;v3;1',
    'dicserem_neved_2/009.xml;v3;2',

    'dicserem_neved_2/011.xml;v2;1',
    'dicserem_neved_2/011.xml;v2;3',
    'dicserem_neved_2/011.xml;v2;4',
    'dicserem_neved_2/011.xml;v3;1',
    'dicserem_neved_2/011.xml;v3;2',
    'dicserem_neved_2/011.xml;v3;3',
    'dicserem_neved_2/011.xml;v3;4',
    'dicserem_neved_2/011.xml;v3;5',

    'dicserem_neved_2/012.xml;v2;1',
    'dicserem_neved_2/012.xml;v2;3',
    'dicserem_neved_2/012.xml;v3;1',
    'dicserem_neved_2/012.xml;v3;3',
    'dicserem_neved_2/012.xml;v3;4',

    'dicserem_neved_2/013.xml;v2;1',
    'dicserem_neved_2/013.xml;v2;2',

    'dicserem_neved_3/002.xml;v2;4',

    'dicserem_neved_4/006.xml;v2;3',
    'dicserem_neved_4/006.xml;v2;6',

    'dicserem_neved_4/174.xml;v2;2',

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

    'erom_es_enekem_az_ur/023.xml;v2;2',
    'erom_es_enekem_az_ur/023.xml;v2;3',
    'erom_es_enekem_az_ur/023.xml;v2;6',

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
    'erom_es_enekem_az_ur/034.xml;v2;4',

    'erom_es_enekem_az_ur/038.xml;v2;2',
    'erom_es_enekem_az_ur/038.xml;v2;3',
    'erom_es_enekem_az_ur/038.xml;v2;4',
    'erom_es_enekem_az_ur/038.xml;v2;6',
    'erom_es_enekem_az_ur/038.xml;v2;8',

    'erom_es_enekem_az_ur/039.xml;v3;5',
    'erom_es_enekem_az_ur/039.xml;v3;6',

    'erom_es_enekem_az_ur/057.xml;v2;2',
    'erom_es_enekem_az_ur/057.xml;v2;4',
    'erom_es_enekem_az_ur/057.xml;v3;1',
    'erom_es_enekem_az_ur/057.xml;v3;2',
    'erom_es_enekem_az_ur/057.xml;v3;3',
    'erom_es_enekem_az_ur/057.xml;v3;4',
    'erom_es_enekem_az_ur/057.xml;v4;2',
    'erom_es_enekem_az_ur/057.xml;v4;4',
    'erom_es_enekem_az_ur/057.xml;v4;5',
    'erom_es_enekem_az_ur/057.xml;v4;6',
    'erom_es_enekem_az_ur/057.xml;v4;8',
    'erom_es_enekem_az_ur/057.xml;v5;1',
    'erom_es_enekem_az_ur/057.xml;v5;2',
    'erom_es_enekem_az_ur/057.xml;v5;3',
    'erom_es_enekem_az_ur/057.xml;v5;4',
    'erom_es_enekem_az_ur/057.xml;v5;5',
    'erom_es_enekem_az_ur/057.xml;v5;6',
    'erom_es_enekem_az_ur/057.xml;v5;8',

    'erom_es_enekem_az_ur/070.xml;v2;2',
    'erom_es_enekem_az_ur/070.xml;v2;4',
    'erom_es_enekem_az_ur/070.xml;v2;5',

    'erom_es_enekem_az_ur/072.xml;v4;1',
    'erom_es_enekem_az_ur/072.xml;v4;2',
    'erom_es_enekem_az_ur/072.xml;v4;3',
    'erom_es_enekem_az_ur/072.xml;v4;4',
    'erom_es_enekem_az_ur/072.xml;v5;2',
    'erom_es_enekem_az_ur/072.xml;v5;3',
    'erom_es_enekem_az_ur/072.xml;v5;4',
    'erom_es_enekem_az_ur/072.xml;v6;1',
    'erom_es_enekem_az_ur/072.xml;v6;2',
    'erom_es_enekem_az_ur/072.xml;v6;3',

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

    'hozsanna/016.xml;v2;4',

    'hozsanna/018.xml;v2;3',

    'hozsanna/021.xml;v2;1',
    'hozsanna/021.xml;v2;3',

    'hozsanna/023.xml;v2;2',

    'hozsanna/024.xml;v2;2',
    'hozsanna/024.xml;v2;3',
    'hozsanna/024.xml;v2;4',

    'hozsanna/027.xml;v2;1',
    'hozsanna/027.xml;v2;4',

    'hozsanna/035.xml;v2;2',
    'hozsanna/035.xml;v2;3',
    'hozsanna/035.xml;v2;6',

    'hozsanna/037.xml;v2;4',

    'hozsanna/040.xml;v2;2',
    'hozsanna/040.xml;v2;3',
    'hozsanna/040.xml;v2;4',

    'hozsanna/055.xml;v2;1',
    'hozsanna/055.xml;v2;2',
    'hozsanna/055.xml;v2;3',

    'hozsanna/058.xml;v3;1',
    'hozsanna/058.xml;v3;4',

    'hozsanna/059.xml;v2;1',
    'hozsanna/059.xml;v2;2',
    'hozsanna/059.xml;v2;3',
    'hozsanna/059.xml;v2;4',
    'hozsanna/059.xml;v2;5',
    'hozsanna/059.xml;v2;8',

    'hozsanna/060.xml;v2;2',
    'hozsanna/060.xml;v2;4',

    'hozsanna/061.xml;v2;1',
    'hozsanna/061.xml;v2;3',

    'hozsanna/062.xml;v2;5',

    'hozsanna/064.xml;v2;1',
    'hozsanna/064.xml;v2;2',
    'hozsanna/064.xml;v2;5',
    'hozsanna/064.xml;v2;7',
    'hozsanna/064.xml;v2;8',

    'hozsanna/069.xml;v3;5',
    'hozsanna/069.xml;v3;6',

    'hozsanna/073.xml;v2;2',
    'hozsanna/073.xml;v2;3',
    'hozsanna/073.xml;v2;4',

    'hozsanna/079.xml;v2;1',
    'hozsanna/079.xml;v2;4',
    'hozsanna/079.xml;v3;1',
    'hozsanna/079.xml;v3;3',
    'hozsanna/079.xml;v3;4',
    'hozsanna/079.xml;v4;1',
    'hozsanna/079.xml;v4;3',

    'hozsanna/094.xml;v2;2',
    'hozsanna/094.xml;v2;4',
    'hozsanna/094.xml;v3;1',
    'hozsanna/094.xml;v3;2',
    'hozsanna/094.xml;v3;3',
    'hozsanna/094.xml;v3;4',

    'hozsanna/097.xml;v2;7',

    'hozsanna/103.xml;v2;2',
    'hozsanna/103.xml;v2;3',
    'hozsanna/103.xml;v2;4',

    'hozsanna/106.xml;v2;1',
    'hozsanna/106.xml;v2;3',

    'hozsanna/111.xml;v2;3',

    'hozsanna/112.xml;v2;1',
    'hozsanna/112.xml;v2;3',
    'hozsanna/112.xml;v3;2',

    'hozsanna/115.xml;v2;3',
    'hozsanna/115.xml;v4;3',
    'hozsanna/115.xml;v5;1',
    'hozsanna/115.xml;v5;3',

    'hozsanna/117.xml;v2;1',
    'hozsanna/117.xml;v2;2',
    'hozsanna/117.xml;v2;5',

    'hozsanna/120.xml;v2;1',

    'hozsanna/124.xml;v2;1',
    'hozsanna/124.xml;v2;4',

    'hozsanna/125.xml;v2;1',
    'hozsanna/125.xml;v2;2',
    'hozsanna/125.xml;v2;3',
    'hozsanna/125.xml;v2;4',
    'hozsanna/125.xml;v3;3',

    'hozsanna/128.xml;v2;1',

    'hozsanna/129.xml;v2;2',

    'hozsanna/130.xml;v2;1',
    'hozsanna/130.xml;v2;2',
    'hozsanna/130.xml;v2;3',
    'hozsanna/130.xml;v3;1',
    'hozsanna/130.xml;v3;2',
    'hozsanna/130.xml;v3;3',
    'hozsanna/130.xml;v4;1',
    'hozsanna/130.xml;v4;2',
    'hozsanna/130.xml;v4;3',

    'hozsanna/133.xml;v2;1',
    'hozsanna/133.xml;v2;2',
    'hozsanna/133.xml;v2;6',
    'hozsanna/133.xml;v2;8',

    'hozsanna/134.xml;v2;1',
    'hozsanna/134.xml;v2;2',
    'hozsanna/134.xml;v2;4',

    'hozsanna/137.xml;v2;5',

    'hozsanna/138.xml;v2;3',
    'hozsanna/138.xml;v2;5',
    'hozsanna/138.xml;v4;3',
    'hozsanna/138.xml;v4;5',

    'hozsanna/148.xml;v2;4',

    'hozsanna/149.xml;v2;2',
    'hozsanna/149.xml;v2;3',
    'hozsanna/149.xml;v3;1',
    'hozsanna/149.xml;v3;3',
    'hozsanna/149.xml;v3;4',

    'hozsanna/150.xml;v2;2',
    'hozsanna/150.xml;v2;4',
    'hozsanna/150.xml;v3;1',
    'hozsanna/150.xml;v3;2',
    'hozsanna/150.xml;v3;4',

    'hozsanna/151.xml;v2;4',
    'hozsanna/151.xml;v3;4',

    'hozsanna/158.xml;v2;1',
    'hozsanna/158.xml;v2;2',
    'hozsanna/158.xml;v2;4',
    
    'hozsanna/160.xml;v2;3',
    'hozsanna/160.xml;v3;3',

    'hozsanna/164.xml;v2;1',
    'hozsanna/164.xml;v2;2',
    'hozsanna/164.xml;v2;3',
    'hozsanna/164.xml;v2;5',
    'hozsanna/164.xml;v2;8',

    'hozsanna/165.xml;v2;3',

    'hozsanna/171.xml;v2;1',

    'hozsanna/173.xml;v2;1',
    'hozsanna/173.xml;v2;2',
    'hozsanna/173.xml;v2;3',
    'hozsanna/173.xml;v2;4',
    'hozsanna/173.xml;v2;5',
    'hozsanna/173.xml;v2;6',
    'hozsanna/173.xml;v3;1',
    'hozsanna/173.xml;v3;2',
    'hozsanna/173.xml;v3;3',
    'hozsanna/173.xml;v3;4',
    'hozsanna/173.xml;v3;5',
    'hozsanna/173.xml;v3;6',
    'hozsanna/173.xml;v4;1',
    'hozsanna/173.xml;v4;2',
    'hozsanna/173.xml;v4;3',
    'hozsanna/173.xml;v4;4',
    'hozsanna/173.xml;v4;5',
    'hozsanna/173.xml;v4;6',
    'hozsanna/173.xml;v5;1',
    'hozsanna/173.xml;v5;2',
    'hozsanna/173.xml;v5;3',
    'hozsanna/173.xml;v5;4',
    'hozsanna/173.xml;v5;5',
    'hozsanna/173.xml;v5;6',

    'hozsanna/180.xml;v2;2',
    'hozsanna/180.xml;v2;3',
    'hozsanna/180.xml;v2;5',
    'hozsanna/180.xml;v2;6',
    'hozsanna/180.xml;v3;3',
    'hozsanna/180.xml;v3;5',
    'hozsanna/180.xml;v3;6',

    'hozsanna/182.xml;v2;2',

    'hozsanna/183.xml;v2;4',

    'hozsanna/184.xml;v2;1',
    'hozsanna/184.xml;v2;4',
    'hozsanna/184.xml;v2;5',
    'hozsanna/184.xml;v2;7',

    'hozsanna/187.xml;v2;1',
    'hozsanna/187.xml;v2;2',
    'hozsanna/187.xml;v2;3',
    'hozsanna/187.xml;v2;4',

    'hozsanna/190.xml;v3;3',

    'hozsanna/191.xml;v2;1',

    'hozsanna/194.xml;v2;3',

    'hozsanna/197.xml;v2;1',
    'hozsanna/197.xml;v2;2',
    'hozsanna/197.xml;v2;4',
    'hozsanna/197.xml;v2;6',

    'hozsanna/200.xml;v2;2',
    'hozsanna/200.xml;v2;4',
    'hozsanna/200.xml;v2;6',

    'hozsanna/203.xml;v2;1',
    'hozsanna/203.xml;v2;2',
    'hozsanna/203.xml;v2;3',
    'hozsanna/203.xml;v2;5',
    'hozsanna/203.xml;v2;6',

    'hozsanna/204.xml;v2;1',
    'hozsanna/204.xml;v2;3',
    'hozsanna/204.xml;v3;1',
    'hozsanna/204.xml;v3;2',

    'hozsanna/206.xml;v2;1',
    'hozsanna/206.xml;v2;2',
    'hozsanna/206.xml;v2;4',
    'hozsanna/206.xml;v3;3',

    'hozsanna/207.xml;v3;3',

    'hozsanna/212.xml;v2;2',
    'hozsanna/212.xml;v2;8',

    'hozsanna/213.xml;v2;1',
    'hozsanna/213.xml;v2;3',
    'hozsanna/213.xml;v3;1',

    'hozsanna/219.xml;v4;3',

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
  
  