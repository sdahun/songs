<?php

namespace sdahun\songs;

require (__DIR__ . '/../vendor/autoload.php');

use \sdahun\songs\Preferences;
use \sdahun\songs\WriterFactory;
use \sdahun\songs\converter\General;


class Compiler {

    private $ini_file;
    private $collections_dir;
    private $compilation_dir;

    private $prefs = null;

    public function __construct ($ini, $coll_dir, $comp_dir) {
        $this->ini_file = $ini;
        $this->collections_dir = $coll_dir;
        $this->compilation_dir = $comp_dir;
    }

    public function configure () {
        echo (str_repeat ('=', 60) . "\n");
        echo (str_repeat (' ', 20) . General::c("ÉNEKSZÖVEG ÁTALAKÍTÓ\n"));
        echo (str_repeat ('=', 60) . "\n");

        if (file_exists ($this->ini_file)) {

            $use_old_config = $this->choice(
                "Korábban már készítettél énekszöveg összeállítást.\n".
                'Szeretnéd annak a beállításait használni?', true);

            if ($use_old_config) return;
            else unlink($this->ini_file);
        }

        $this->prefs = new Preferences($this->ini_file);
        $this->prefs->set ('source_dir', $this->collections_dir);
        $this->prefs->set ('dest_dir', $this->compilation_dir);

        $question_nr = 0;

        $this->prefs->set('intro_slide',
            $this->choice(++$question_nr . '.) Legyen nyitó dia az ének címével?', true));
        
        if ($this->prefs->get('intro_slide')) {
            $this->prefs->set('intro_songbook',
                $this->choice(++$question_nr . '.) Szerepeljen a nyitó dián az énekeskönyv neve?', false));

            if ($this->prefs->get('intro_songbook'))
                $this->prefs->set('intro_songnumber',
                    $this->choice(++$question_nr . '.) Szerepeljen a nyitó dián az ének sorszáma?', false));
        }

        $this->prefs->set('song_linebreak',
            $this->choice(++$question_nr . '.) Az énekszöveg soronként legyen tördelve?', true));

        if ($this->prefs->get('song_linebreak')) {
            $this->prefs->set('song_ucfirst',
                $this->choice(++$question_nr . '.) A sorok első betűje legyen nagybetűs?', false));
        }
        else {
            $this->prefs->set('song_separator',
                $this->choice(++$question_nr . '.) A sorok legyenek perjellel (/) elválasztva?', false));
        }

        $this->prefs->set('song_repeat_verses',
            $this->choice(++$question_nr . '.) Az ismétlődő diák (refrén) ismétlődjenek?', false));

        $this->prefs->set('tag_slide',
            $this->choice(++$question_nr . '.) Legyen utolsó utáni üres dia?', false));

        if ($this->prefs->get('tag_slide'))
            $this->prefs->set('quick_search',
                $this->choice(++$question_nr . '.) Legyen az utolsó utáni üres dián gyorskereső hivatkozás?', false));

        $this->prefs->set('output_format',
            $this->get_number(++$question_nr .
                ".) Milyen formátumba kerüljenek az énekek?\n".
                "    1.) OpenLP\n".
                "    2.) Quelea\n".
                "    3.) FreeWorship\n".
                "    4.) EasyWorship\n".
                "    5.) PowerPoint\n".
                "    6.) Szovegfajl\n".
                "  Válasz?", 1, 6));
            
        if (in_array ($this->prefs->get('output_format'), ['6']))
            $this->prefs->set('batch_size',
                $this->get_number(++$question_nr . '.) Hány ének kerüljön egy fájlba? (0 = mind egybe)', 0, 1000));

        if ($this->get_number(++$question_nr .
            ".) Mely énekeket szeretnéd átalakítani?\n".
            "    1.) Az összes énekeskönyv összes énekét\n".
            "    2.) Csak a kiválasztott énekeskönyvekből kérek énekeket\n".
            "  Válasz?", 1, 2) == 1) {

            $this->prefs->set('selected_songs', ['all' => 'all']);
        }
        else {
            $selected_songs = [];

            $dirs = array_map (
                function($d) { return basename($d); },
                array_filter (
                    glob ($this->collections_dir.'/*'),
                    "is_dir"
                )
            );

            $question = '';
            for ($i = 0; $i < count($dirs); $i++)
                $question .= '    ' . ($i+1) . '.) ' . $dirs[$i] . "\n";

            $songbooks = $this->get_range (++$question_nr .
                ".) Sorold fel a kiválasztott énekeskönyvek sorszámát:\n".
                $question .
                '  Válasz? (pl.: 1-3,5): ');

            foreach (explode(',', $songbooks) as $range) {
                $elems = explode('-', $range);

                if (count($elems) == 1) $elems[] = $elems[0];
                if ($elems[0] > $elems[1]) continue;

                for ($i = $elems[0]; $i <= $elems[1]; $i++) {
                    if (!isset ($dirs [$i - 1])) continue;
                    $songbook = $dirs [$i - 1];

                    $songs = $this->get_range (++$question_nr .
                        ".) Sorold fel a kiválasztott énekek sorszámát\n" .
                        '    ' . General::get_article($songbook) . '"' . $songbook . "\" énekeskönyvből:\n" .
                        '  Válasz? (0 = mind) (pl.: 1-100,150): ');

                    $selected_songs[$songbook] = $songs;
                    $this->prefs->set('selected_songs', $selected_songs);
                }
            }
        }
        echo (General::c ("\nA beállításokat elmentettük.\n"));
    }

    public function compile () {

        if (is_null ($this->prefs)) {

            if (!file_exists ($this->ini_file)) {
                echo (General::c ("\nA beállítások nem érhetők el! Így nem kezdhető meg az átalakítás! :(\n"));
                return;
            }
            $this->prefs = new Preferences ($this->ini_file);
        }

        if (!$this->choice ("Szeretnéd most elkezdeni az átalakítást?", true)) {
            echo (General::c ("\nRendben, szép napot!\n").str_repeat ('=', 60) . "\n");
            return;
        }

        echo (str_repeat ('=', 60) . "\n");
        echo (General::c("Kis türelmet, az átalakítás folyamatban...\n"));
        
        $writer = WriterFactory::getWriter ($this->prefs);
        
        $selected_songs = $this->prefs->get('selected_songs');
        $selected_collections = array_keys($selected_songs);

        foreach (glob ($this->prefs->get('source_dir') . '/*') as $collection_path) {
            if (!is_dir($collection_path)) continue;
            $collection = basename($collection_path);

            if (in_array('all', $selected_collections) || in_array($collection, $selected_collections)) {
                echo('  Énekek átalakítása ' . General::get_article($collection) . General::c('"'.$collection.'"')." énekesből...\n");

                if (in_array('all', $selected_collections))
                    $selected_numbers = '0';
                else
                    $selected_numbers = $selected_songs[$collection];

                //attention! hard coded upper limit for "all"! we assume there's no songbook with more than 1000 song!
                if ($selected_numbers == '0')
                    $selected_numbers = '1-1000';

                foreach (explode(',', $selected_numbers) as $range) {
                    $songs = explode('-', $range);

                    if (count($songs) == 1)
                        $songs[] = $songs[0];

                    if ($songs[0] > $songs[1])
                        continue;

                    for ($i = $songs[0]; $i <= $songs[1]; $i++) {
                        $writer->addSongFile ($collection_path . '/' . sprintf('%03d', $i) . '.xml');
                    }
                }
            }
        }
        
        $writer->close();

        echo(General::c("\nAz átalakítás befejeződött.\n"));

        echo(General::c("\nSzép napot!\n").str_repeat ('=', 60) . "\n");
    }


    private function choice($question, $default) {
        $answer = 'x';

        while ( ($answer != 'I') && ($answer != 'N') && ($answer != '') ) {
            echo ("\n" . General::c($question) . ' (' . ($default ? 'I/n' : 'i/N') . '): ');

            $answer = strtoupper(trim(fgets(STDIN)));
        }

        if ($answer == '') return $default;

        return ($answer == 'I');
    }


    private function get_number($question, $min, $max) {
        $answer = $min - 1;

        while ( ($answer < $min) || ($answer > $max) ) {
            echo ("\n" . General::c($question) . ' (' . $min . '-' . $max . '): ');

            $answer = intval(fgets(STDIN));
        }

        return $answer;
    }
    
    
    private function get_range($question) {
        $match = 0;

        while ( $match != 1) {
            echo ("\n" . General::c($question) . ' ');

            $match = preg_match("/^[0-9,\-]+$/", trim(fgets(STDIN)), $regs);
        }

        return $regs[0];
    }

}


function main() {
    $root_dir = realpath(__DIR__ . '/..');

    $collections_dir = $root_dir . '/collections';
    $compilation_dir = $root_dir . '/compilations';

    $preferences_file = $compilation_dir . '/compiler.preferences.ini';

    $compiler = new Compiler ($preferences_file, $collections_dir, $compilation_dir);

    $compiler->configure();
    $compiler->compile();
}


main();
