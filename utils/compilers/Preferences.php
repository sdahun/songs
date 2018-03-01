<?php

namespace sdahun\songs;

class Preferences {

    private $ini_file;

    private $values = [];

    public function __construct ($file = '') {
        $this->ini_file = $file;

        if (file_exists ($this->ini_file))
            $this->values = parse_ini_file ($this->ini_file, false, INI_SCANNER_TYPED);
    }

    public function get($key) {
        if (isset ($this->values[$key]))
            return $this->values[$key];
        return null;
    }

    public function set($key, $value) {
        $this->values[$key] = $value;
        $this->savePreferences();

        return $this;
    }

    public function savePreferences() {
        $prefs = "[main]\n";
        foreach ($this->values as $key => $value)
            if (is_array($value)) {
                foreach($value as $ikey => $ivalue)
                    $prefs .= $key . '[' . $ikey . '] = ' . $ivalue . "\n";
            }
            else {
                $prefs .= $key . ' = ' . $value . "\n";
            }

        if (!file_exists (dirname ($this->ini_file)))
            mkdir (dirname ($this->ini_file), 0777, true);

        file_put_contents ($this->ini_file, $prefs);
    }
}