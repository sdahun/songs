<?php

namespace sdahun\songs\writer;

use \sdahun\songs\Preferences;

class AbstractWriter {

    protected $prefs;

    protected $file_extension = '';

    private $momentum;

    private $part = 0;


    function __construct(Preferences $prefs) {
        $this->prefs = $prefs;
        $this->momentum = time();
    }

    function getNextFile() {
        $result = 'sdahun_songs-' . date ('Y.m.d_H.i.s', $this->momentum);

        if ($this->prefs->get('batch_size') > 0)
            $result .= '-part_' . sprintf('%03d', ++$this->part);
        
        $result .= $this->file_extension;

        return $result;
    }
}