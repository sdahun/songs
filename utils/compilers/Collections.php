<?php

namespace sdahun\songs;

class Collections {

    static public function getQuickSearchName($name) {
        switch ($name) {
            case 'Dicsérem Neved 1':     return 'DN1-';
            case 'Dicsérem Neved 2':     return 'DN2-';
            case 'Dicsérem Neved 3':     return 'DN3-';
            case 'Dicsérem Neved 4':     return 'DN4-';
            case 'Dicsérem Neved 5':     return 'DN5-';
            case 'Erőm és Énekem az Úr': return 'EEU';
            case 'Hitünk énekei':        return 'HE';
            case 'Hozsánna énekes':      return 'HO';
            case 'Szent az Úr':          return 'SZU';
            default: throw new Exception('Please add „' . $name . '” to the quick search name list!');
        }
    }

}