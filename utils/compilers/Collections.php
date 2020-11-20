<?php

namespace sdahun\songs;

use \Exception;

class Collections {

    static public function getQuickSearchName($name) {
        switch ($name) {
            case 'Adj zengő éneket!':                         return 'A';
            case 'Baptista gyülekezeti énekeskönyv':          return 'B';
            case 'Dicsérem Neved 1':                          return 'T';
            case 'Dicsérem Neved 2':                          return 'V';
            case 'Dicsérem Neved 3':                          return 'W';
            case 'Dicsérem Neved 4':                          return 'X';
            case 'Dicsérem Neved 5':                          return 'Y';
            case 'Erőm és énekem az Úr':                      return 'E';
            case 'Hitünk énekei':                             return 'H';
            case 'Hozsánna énekes':                           return 'O';
            case 'Szent az Úr':                               return 'S';
            case 'Üdv- és adventi énekek':                    return 'U';
            case 'Zuglói Adventista Gyülekezeti Énekeskönyv': return 'Z';
            default: throw new Exception('Please add "' . $name . '" to the quick search name list!');
        }
    }

}
