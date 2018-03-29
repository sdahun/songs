<?php

namespace sdahun\songs\writer;

use \ZipArchive;
use \SimpleXmlElement;
use \sdahun\songs\Preferences;
use \sdahun\songs\Collections;
use \sdahun\songs\converter\General;
use \sdahun\songs\converter\Xml2Apk;
use \sdahun\songs\converter\XmlConfigurator;

class ApkWriter extends AbstractWriter {

    private $zip;
    private $file_counter;
    private $orderNumber;

    public function __construct(Preferences $prefs) {
        parent::__construct($prefs);
        $this->file_extension = '.zip';
        $this->orderNumber = 0;
  
        $this->startNewOutput();
    }

    public static function getWriterName() {
        return 'Szövegfájl androidra (hu.nicetry.android.readerapp.apk)';
    }

    private function startNewOutput() {
        $this->file_counter = 0;
        $this->zip = new ZipArchive();

        $path = $this->prefs->get('dest_dir');
        $fname = $this->getNextFile();
        $this->zip->open($path . '/' . $fname, ZipArchive::CREATE);

        echo("  A szövegfájlok a következő fájlba kerülnek:\n    /" . basename($path) . '/' . $fname . "\n");
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

            $content = file_get_contents ($xml_path);
            $xml = new SimpleXmlElement($content);
            $songbook = $xml->properties->songbooks->songbook[0]['name']->__toString();
    
            $this->prefs->set('tag_slide', true);
            $this->prefs->set('quick_search', true);

            $this->zip->addFromString (
                'assets/books/'.
                basename (dirname ($xml_path)) . '/' .
                Collections::getQuickSearchName ($songbook).
                basename ($xml_path, '.xml') .
                '.txt',
                Xml2Apk::convert (XmlConfigurator::configure ($content, $this->prefs))
            );
        }
    }

    public function writeCollectionHeader($collection_path) {
        $title = 'Ismeretlen énekeskönyv';
        //determine collection title from the first file in collection
        $files = glob($collection_path . '/*.xml');
        if (count ($files) > 0) {
            $xml = new SimpleXmlElement(file_get_contents($files[0]));
            $title = $xml->properties->songbooks->songbook[0]['name']->__toString();
        }

        $this->zip->addFromString (
            'assets/books/'.
            basename ($collection_path). '/' .
            '!desc.txt',
            'title:'.$title."\r\n".
            "language:hun\r\n".
            "languageText:magyar\r\n".
            'orderNumber:'.(++$this->orderNumber)
        );
    }
}
