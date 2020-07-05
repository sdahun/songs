<?php

$datas = [
    'adj_zengo_eneket' => [
        'name'     => 'Adj zengő éneket!',
        'download' => 'http://www.kalvinkiado.hu/index.php?page=shop.product_details&flypage=flypage.tpl&product_id=988&category_id=43&option=com_virtuemart&Itemid=3&lang=hu',
        'count'    => 150,
    ],
    'baptista_gyulekezeti_enekeskonyv' => [
        'name'     => 'Baptista gyülekezeti énekeskönyv',
        'download' => 'http://www.konyvesbolt.baptist.hu',
        'count'    => 560,
    ],
    'dicserem_neved_1' => [
        'name'     => 'Dicsérem Neved 1.',
        'download' => 'http://dicseremneved.hu',
        'count'    => 224,
    ],
    'dicserem_neved_2' => [
        'name'     => 'Dicsérem Neved 2.',
        'download' => 'http://dicseremneved.hu',
        'count'    => 230,
    ],
    'dicserem_neved_3' => [
        'name'     => 'Dicsérem Neved 3.',
        'download' => 'http://dicseremneved.hu',
        'count'    => 200,
    ],
    'dicserem_neved_4' => [
        'name'     => 'Dicsérem Neved 4.',
        'download' => 'http://dicseremneved.hu',
        'count'    => 222,
    ],
    'dicserem_neved_5' => [
        'name'     => 'Dicsérem Neved 5.',
        'download' => 'http://dicseremneved.hu',
        'count'    => 225,
    ],
    'erom_es_enekem_az_ur' => [
        'name'     => 'Erőm és énekem az Úr',
        'download' => 'http://www.harmat.hu/uzlet/erom-es-enekem-az-ur',
        'count'    => 143,
    ],
    'hitunk_enekei' => [
        'name'     => 'Hitünk énekei',
        'download' => 'http://adventkiado.hu',
        'count'    => 477,
    ],
    'hozsanna' => [
        'name'     => 'Hozsánna énekes',
        'download' => 'http://adventista.hu',
        'count'    => 219,
    ],
    'szent_az_ur' => [
        'name'     => 'Szent az Úr',
        'download' => 'http://adventista.hu',
        'count'    => 40,
    ],
    'udv_es_adventi_enekek' => [
        'name'     => 'Üdv- és Adventi Énekek',
        'download' => 'https://www.antikvarium.hu/konyv/udv-es-adventi-enekek-473997',
        'count'    => 512,
    ],
];

$sumSongCount = 0;

$result =
  "# Énekeskönyvek\n\n".
  "A gyűjteményben szereplő énekeskönyvek feldolgozottsága és beszerzési lehetőségeinek linkjei:\n\n".
  "| Énekeskönyv | Feldolgozottság |\n".
  "| ----------- | --------------- |\n";

foreach (glob (COLLECTIONS_PATH . '/*') as $collection) {
    if (!is_dir($collection)) continue;

    $colname = basename($collection);
    if (!isset($datas[$colname])) continue;

    $songcount = count (glob ($collection . '/*.xml'));
    $sumSongCount += $songcount;
    $result .=
        '| [' . $datas[$colname]['name'] . '](' . $datas[$colname]['download'].') | '.
        '![Feldolgozottság](https://progress-bar.dev/' . round ($songcount / $datas[$colname]['count'] * 100) .
        ') (' . $songcount . '/' . $datas[$colname]['count'] . ') |' . "\n";
}

$result .= "\nA gyűjteményben jelenleg ".$sumSongCount." darab ének található.\n";

$readme = ROOT_PATH . '/README.md';
$content = file_get_contents($readme);

$result = substr ($content, 0, strpos ($content, '# Énekeskönyvek')) .
          $result .
          substr ($content, strpos ($content, '# Támogatott szoftverek')-1);

file_put_contents ($readme,  $result);

echo("Processes (re)generated successfully!\n");
