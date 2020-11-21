<?php

namespace sdahun\songs\writer;

use \ZipArchive;
use \SimpleXmlElement;
use \sdahun\songs\Preferences;
use \sdahun\songs\converter\General;
use \sdahun\songs\converter\Xml2Sbk;
use \sdahun\songs\converter\XmlConfigurator;

class SongBookWriter extends AbstractWriter {

    private $toc;
    private $songbook;
    private $zip;
    private $file_counter;

    public function __construct(Preferences $prefs) {
        parent::__construct($prefs);
        $this->file_extension = '.zip';
  
        $this->startNewOutput();
    }

    public static function getWriterName() {
        return 'Énekeskönyv fájl';
    }

    private function startNewOutput() {
        $this->toc = pack('CCC', 0xEF, 0xBB, 0xBF) . "TARTALOMJEGYZÉK\r\n\r\n"; //utf8 header
        $this->songbook = '';
    }

    public function close() {
        $zip = new ZipArchive();

        $path = $this->prefs->get('dest_dir');
        $fname = $this->getNextFile();
        $zip->open($path . '/' . $fname, ZipArchive::CREATE);
        $zip->addFromString ('songbook.txt', $this->toc . "\f\r\n" . $this->songbook);
        $zip->close();

        echo("  Az énekeskönyv a következő fájlba került:\n    /" . basename($path) . '/' . $fname . "\n");
    }

    public function addSongFile($xml_path) {
        if (file_exists($xml_path)) {
            ++$this->file_counter;
            $batch_size = $this->prefs->get('batch_size');
            if ($batch_size > 0)
                if ($this->file_counter > $this->prefs->get('batch_size')) {
                    $this->close();
                    $this->startNewOutput();
                }

            $songxml = XmlConfigurator::configure (file_get_contents ($xml_path), $this->prefs);
            $xml = new SimpleXmlElement($songxml);
            $this->toc .= $xml->properties->titles->title[0]->__toString() . " \t ".$this->file_counter."\r\n";
            $this->songbook .= 
                intval(basename($xml_path, '.xml')).".\r\n".
                Xml2Sbk::convert ($songxml)."\r\n";
        }
    }
}
