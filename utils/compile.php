<?php

$root_dir = realpath(__DIR__ . '/..');
$classes_dir = __DIR__ . '/compilers';
$collections_dir = $root_dir . '/collections';
$compilation_dir = $root_dir . '/compilations';

$preferences_file = $compilation_dir . '/compiler.preferences.ini';

require($classes_dir . '/Preferences.php');

use \sdahun\songs\Preferences;


function t($str) {
  //mac, linux: utf-8
  if (function_exists('posix_isatty') && posix_isatty(STDOUT)) return $str;
  //windows: cp852
  return iconv('utf-8', 'cp852', $str);
}


function get_nevelo($str) {
  $str = mb_convert_case(trim($str, '"„” ')[0], MB_CASE_UPPER);

  if (in_array($str, ['A', 'Á', 'E', 'É', 'I', 'Í', 'O', 'Ó', 'Ö', 'Ő', 'U', 'Ú', 'Ü', 'Ű']))
    return 'az ';
  return 'a ';
}


function choice($question, $default) {
  $answer = 'x';
  while ( ($answer != 'I') && ($answer != 'N') && ($answer != '') ) {
    echo ("\n" . t($question) . ' (' .
      ($default ? 'I' : 'i') . '/' .
      ($default ? 'n' : 'N') . '): ');

    $answer = strtoupper(trim(fgets(STDIN)));
  }
  if ($answer == '')
    return $default;

  return ($answer == 'I');
}


function get_number($question, $min, $max) {
  $answer = $min-1;
  while ( ($answer < $min) || ($answer > $max) ) {
    echo ("\n" . t($question) . ' (' . $min . '-' . $max . '): ');
    $answer = intval(fgets(STDIN));
  }
  return $answer;
}


function get_range($question) {
  $match = 0;
  while ( $match != 1) {
    echo ("\n" . t($question) . ' ');
    $match = preg_match("/^[0-9,\-]+$/", fgets(STDIN), $regs);
  }
  return $regs[0];
}


echo (str_repeat ('=', 60) . "\n");
echo (str_repeat (' ', 20) . t("ÉNEKSZÖVEG ÁTALAKÍTÓ\n"));
echo (str_repeat ('=', 60) . "\n");

if (file_exists ($preferences_file)) {
  if (!choice(
      "Korábban már készítettél énekszöveg összeállítást.\n".
      'Szeretnéd annak a beállításait használni?', true))
    unlink($preferences_file);
}

$prefs = new Preferences($preferences_file);

if (!file_exists($preferences_file)) {
  $question_nr = 0;
  $prefs->set('intro_slide', choice(++$question_nr . '.) Legyen nyitó dia az ének címével?', true));
  if ($prefs->get('intro_slide')) {
    $prefs->set('intro_songbook', choice(++$question_nr . '.) Szerepeljen a nyitó dián az énekeskönyv neve?', false));
    if ($prefs->get('intro_songbook'))
      $prefs->set('intro_songnumber', choice(++$question_nr . '.) Szerepeljen a nyitó dián az ének sorszáma?', false));
  }

  $prefs->set('song_linebreak', choice(++$question_nr . '.) Az énekszöveg soronként legyen tördelve?', true));
  if ($prefs->get('song_linebreak')) {
    $prefs->set('song_ucfirst', choice(++$question_nr . '.) A sorok első betűje legyen nagybetűs?', false));
  }
  else {
    $prefs->set('song_separator', choice(++$question_nr . '.) A sorok legyenek perjellel (/) elválasztva?', false));
  }

  $prefs->set('song_repeat_verses', choice(++$question_nr . '.) Az ismétlődő diák csak egyszer szerepeljenek?', true));
  $prefs->set('tag_slide', choice(++$question_nr . '.) Legyen utolsó utáni üres dia?', false));
  if ($prefs->get('tag_slide'))
    $prefs->set('quick_search', choice(++$question_nr . '.) Legyen az utolsó utáni üres dián gyorskereső hivatkozás?', false));

  $prefs->set('output_format', get_number(++$question_nr .
    ".) Milyen formátumba kerüljenek az énekek?\n".
    "    1.) OpenLP\n".
    "    2.) Quelea\n".
    "    3.) FreeWorship\n".
    "    4.) EasyWorship\n".
    "    5.) PowerPoint\n".
    "    6.) Szovegfajl\n".
    "  Válasz?", 1, 6));

  //TODO: this question has to be asked only if it's relevant according to the previous question
  $prefs->set('batch_size', get_number(++$question_nr . '.) Hány ének kerüljön egy fájlba? (0 = mind egybe)', 0, 1000));

  if (get_number(++$question_nr . 
      ".) Mely énekeket szeretnéd átalakítani?\n".
      "    1.) Az összes énekeskönyv összes énekét\n".
      "    2.) Csak a kiválasztott énekeskönyvekből kérek énekeket\n".
      "  Válasz?", 1, 2) == 1) {

    $prefs->set('selected_songs', ['0']);
  }

  else {
    $selected_songs = [];

    $dirs = array_map (
      function($d) { return basename($d); },
      array_filter (
        glob ($collections_dir.'/*'),
        "is_dir"
      )
    );
    $question = '';
    for ($i = 0; $i < count($dirs); $i++)
      $question .= '    ' . ($i+1) . '.) ' . $dirs[$i] . "\n";

    $songbooks = get_range (++$question_nr .
      ".) Sorold fel a kiválasztott énekeskönyvek sorszámát:\n".
      $question .
      '  Válasz? (pl.: 1-3,5): ');

    foreach (explode(',', $songbooks) as $range) {
      $elems = explode('-', $range);

      if (count($elems) == 1) {
        if (!isset ($dirs [$elems[0] - 1])) continue;
        $songbook = $dirs [$elems[0] - 1];
        $songs = get_range (++$question_nr .
          ".) Sorold fel a kiválasztott énekek sorszámát\n" .
          '    ' . get_nevelo($songbook) . '„' . $songbook . "” énekeskönyvből:\n" .
          '  Válasz? (0 = mind) (pl.: 1-100,150): ');
        $selected_songs[] = $songbook . ';' . $songs;
        $prefs->set('selected_songs', $selected_songs);
      }
      else {
        if ($elems[0] > $elems[1]) continue;
        for ($i = $elems[0]; $i <= $elems[1]; $i++) {
          if (!isset ($dirs [$i - 1])) continue;
          $songbook = $dirs [$i - 1];
          $songs = get_range (++$question_nr .
            ".) Sorold fel a kiválasztott énekek sorszámát\n" .
            '    ' . get_nevelo($songbook) . '„' . $songbook . "” énekeskönyvből:\n" .
            '  Válasz? (0 = mind) (pl.: 1-100,150): ');
          $selected_songs[] = $songbook . ';' . $songs;
          $prefs->set('selected_songs', $selected_songs);
        }
      }
    }
  }
  
  echo(t("\nA beállításokat elmentettük.\n"));
}

if (choice ("Szeretnéd most elkezdeni az átalakítást?", true)) {
  echo (str_repeat ('=', 60) . "\n");
  echo (t("Kis türelmet, az átalakítás folyamatban...\n"));

  switch ($prefs->get('output_format')) {
    case 1:
        echo(t("Az OpenLP formátum még nincs implementálva!\n"));
        break;

    case 2:
        echo(t("A Quelea formátum még nincs implementálva!\n"));
        break;

    case 3:
        echo(t("A FreeWorship formátum még nincs implementálva!\n"));
        break;

    case 4:
        echo(t("Az EasyWorship formátum még nincs implementálva!\n"));
        break;

    case 5:
        echo(t("A PowerPoint formátum még nincs implementálva!\n"));
        break;

    case 6:
        echo(t("A szövegfájl formátum még nincs implementálva!\n"));
        break;
  }

  echo(t("\nAz átalakítás befejeződött.\nAz eredmény a /compilations mappába került.\n"));
}

echo(t("\nSzép napot!\n").str_repeat ('=', 60) . "\n");
