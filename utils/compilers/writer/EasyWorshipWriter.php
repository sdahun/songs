<?php

namespace sdahun\songs\writer;

use \SimpleXmlElement;
use \sdahun\songs\Preferences;
use \sdahun\songs\converter\General;
use \sdahun\songs\converter\Txt2Rtf;
use \sdahun\songs\converter\Xml2Txt;
use \sdahun\songs\converter\XmlConfigurator;

class EasyWorshipWriter extends AbstractWriter {

    private $ews;
    private $file_counter;

    public function __construct(Preferences $prefs) {
        parent::__construct($prefs);
        $this->file_extension = '.ews';
  
        $this->startNewOutput();
    }

    private function startNewOutput() {
        $this->file_counter = 0;
        $this->ews = [];
    }

    public function close() {
        $stream = 'EasyWorship Schedule File Version  1.6';
        $stream .= pack('v', 0x1a00);
        $stream .= pack('V', $this->file_counter);
        $stream .= pack('v', 0x350);                                    // Entry length

        $compressed_pos = 0x2e + $this->file_counter * 0x350;

        for($i = 0; $i < $this->file_counter; $i++) {
            $stream .= pack('a50x',  $this->ews[$i]['title']);          // Title
            $stream .= pack('a256',  '');                               // External file path
            $stream .= pack('a50x',  '');                               // Author
            $stream .= pack('a100x', '');                               // Copyright
            $stream .= pack('a50x',  '');                               // Administrator
            $stream .= "\x01\x01\x00";                                  // Linked; Default Background; BK Type
            $stream .= pack('a23',   '');                               // various BK settings
            $stream .= pack('a256',  '');                               // BK Bitmap Name
            $stream .= pack('a8',    '');                               // Last modified timestamp
            $stream .= pack('V', $compressed_pos);                      // Offset of binary data
            $compressed_pos += strlen($this->ews[$i]['content']) + 14;  // Next offset
            $stream .= pack('a16',   '');                               // Unknown
            $stream .= pack('V',     1);                                // Type: tSong
            $stream .= pack('a24',   '');                               // Unknown
        }

        for($i = 0; $i < $this->file_counter; $i++) {
            $stream .= pack('V', strlen($this->ews[$i]['content']) + 10);
            $stream .= $this->ews[$i]['content'];
            $stream .= "\x51\x4b\x03\x04";
            $stream .= pack('V', $this->ews[$i]['origsize']);
            $stream .= "\x08\x00";
        }

        $path = $this->prefs->get('dest_dir');
        $fname = $this->getNextFile();
        file_put_contents($path . '/' . $fname, $stream);

        echo(General::c("  Az EasyWorship formátumú énekek a következő fájlba kerültek:\n    /" . basename($path) . '/' . $fname) . "\n");
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
            $xml = new SimpleXmlElement ($content);
            $title = $xml->properties->titles[0]->title->__toString();

            $content = Txt2Rtf::convert (Xml2Txt::convert (XmlConfigurator::configure ($content, $this->prefs)));

            $this->ews[] = [
                'title' => iconv ('utf-8', 'windows-1250', $title),
                'origsize' => strlen ($content),
                'content' => gzcompress ($content, 9),
            ];
        }
    }
}
