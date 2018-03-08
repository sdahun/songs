<?php

define ('COLLECTIONS_PATH', realpath (dirname(__FILE__) . '/../collections'));
define ('COMPILATIONS_PATH', realpath (dirname(__FILE__) . '/../compilations'));

setlocale(LC_ALL, 'hu_HU.utf8');
date_default_timezone_set('Europe/Budapest');

$lasterror = '';
set_error_handler(
    function($errno, $errstr) {
        global $lasterror;
        $lasterror=$errstr;
    }
);

$no_error = true;

foreach (glob (dirname(__FILE__).'/validators/*_validator.php') as $validator) {
    echo(str_repeat('-', 50)."\n");
    try {
        require($validator);
    }
    catch (Exception $e) {
        echo($e->getMessage()."\n");
        echo("Validation suspended at this stage!\n");
        $no_error = false;
        break;
    }
}
echo(str_repeat('-', 50)."\n");

if ($no_error)
    require(__DIR__ . '/contents_generator.php');
