<?php

namespace sdahun\songs\converter;

class Txt2Rtf {
    public static function convert($text)
    {
        defined('CRLF') || define('CRLF', "\r\n");

        $rtf = '{\rtf1\ansi\deff0\deftab254{\fonttbl{\f0\fnil\fcharset238 Arial;}}' .
               '{\colortbl\red0\green0\blue0;\red255\green0\blue0;\red0\green128\blue0;' .
               '\red0\green0\blue255;\red255\green255\blue0;\red255\green0\blue255;' .
               '\red128\green0\blue128;\red128\green0\blue0;\red0\green255\blue0;' .
               '\red0\green255\blue255;\red0\green128\blue128;\red0\green0\blue128;' .
               '\red255\green255\blue255;\red192\green192\blue192;\red128\green128\blue128;' .
               '\red255\green255\blue255;}\paperw12240\paperh15840' .
               '\margl1880\margr1880\margt1440\margb1440' .
               '{\*\pnseclvl1\pnucrm\pnstart1\pnhang\pnindent720{\pntxtb}{\pntxta{.}}}' . CRLF .
               '{\*\pnseclvl2\pnucltr\pnstart1\pnhang\pnindent720{\pntxtb}{\pntxta{.}}}' . CRLF .
               '{\*\pnseclvl3\pndec\pnstart1\pnhang\pnindent720{\pntxtb}{\pntxta{.}}}' . CRLF .
               '{\*\pnseclvl4\pnlcltr\pnstart1\pnhang\pnindent720{\pntxtb}{\pntxta{)}}}' . CRLF .
               '{\*\pnseclvl5\pndec\pnstart1\pnhang\pnindent720{\pntxtb{(}}{\pntxta{)}}}' . CRLF .
               '{\*\pnseclvl6\pnlcltr\pnstart1\pnhang\pnindent720{\pntxtb{(}}{\pntxta{)}}}' . CRLF .
               '{\*\pnseclvl7\pnlcrm\pnstart1\pnhang\pnindent720{\pntxtb{(}}{\pntxta{)}}}' . CRLF .
               '{\*\pnseclvl8\pnlcltr\pnstart1\pnhang\pnindent720{\pntxtb{(}}{\pntxta{)}}}' . CRLF .
               '{\*\pnseclvl9\pndec\pnstart1\pnhang\pnindent720{\pntxtb{(}}{\pntxta{)}}}' . CRLF;

        $ekezet_txt = array( 0xe1,    0xe9,   0xed,   0xf3,   0xf6,   0xf5,   0xfa,   0xfc,   0xfb,
                             0xc1,    0xc9,   0xcd,   0xd3,   0xd6,   0xd5,   0xda,   0xdc,   0xdb,
                             0x84,    0x94,   0x92,    '{',    '}',
                           );
        $ekezet_rtf = array("\'e1", "\'e9", "\'ed", "\'f3", "\'f6", "\'f5", "\'fa", "\'fc", "\'fb",
                            "\'c1", "\'c9", "\'cd", "\'d3", "\'d6", "\'d5", "\'da", "\'dc", "\'db",
                            "\'84", "\'94", "\'92",   "\{",   "\}",
                           );

        $lines = explode(CRLF, str_replace($ekezet_txt, $ekezet_rtf, $text));
        $res = '';
        foreach ($lines as $line) {
            $line = str_replace("\n", '\line ', $line);
            
            if ($res == '') {
                $res = '{\pard\ql\li0\fi0\ri0\sb0\sl\sa0 \plain\f0\fs20\fntnamaut ' . $line;
                continue;
            }
            
            $res .= '\par' . CRLF . '\ql\li0\fi0\ri0\sb0\sl\sa0 \plain\f0\fs20\fntnamaut ' . $line;
        }
        $rtf .= $res . '}' . CRLF . '}';

        return ($rtf);
    }
}

