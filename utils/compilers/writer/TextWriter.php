<?php

namespace sdahun\songs\writer;

use \ZipArchive;
use \sdahun\songs\Preferences;
use \sdahun\songs\converter\General;
use \sdahun\songs\converter\Xml2Txt;
use \sdahun\songs\converter\XmlConfigurator;

class TextWriter extends AbstractWriter {

    private $zip;
    private $file_counter;

    public function __construct(Preferences $prefs) {
        parent::__construct($prefs);
        $this->file_extension = '.zip';
  
        $this->startNewOutput();
    }

    private function startNewOutput() {
        $this->file_counter = 0;
        $this->zip = new ZipArchive();

        $path = $this->prefs->get('dest_dir');
        $fname = $this->getNextFile();
        $this->zip->open($path . '/' . $fname, ZipArchive::CREATE);

        echo(General::c("  A szövegfájlok a következő fájlba kerülnek:\n    /" . basename($path) . '/' . $fname) . "\n");
    }

    public function close() {
        $this->zip->close();
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

            $this->zip->addFromString (
                basename (dirname ($xml_path)) . '/' . basename ($xml_path, '.xml') . '.txt',
                Xml2Txt::convert (XmlConfigurator::configure (file_get_contents ($xml_path), $this->prefs))
            );
        }
    }
}
