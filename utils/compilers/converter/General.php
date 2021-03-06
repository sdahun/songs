<?php

namespace sdahun\songs\converter;

class General {
      
    public static function get_article($str) {
        $str = trim($str, '"„” ');
        $str = mb_substr($str, 0, 1);
        $str = mb_convert_case($str, MB_CASE_UPPER);
      
        if (in_array($str, ['A', 'Á', 'E', 'É', 'I', 'Í', 'O', 'Ó', 'Ö', 'Ő', 'U', 'Ú', 'Ü', 'Ű']))
          return 'az ';
        return 'a ';
    }


    public static function getInnerXml($str) {
        $from = strpos($str, '>') + 1;
        $to = strrpos($str, '<');
        return substr($str, $from, $to-$from);
    }
}
