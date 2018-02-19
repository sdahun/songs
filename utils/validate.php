<?php

define ('COLLECTIONS_PATH', realpath (dirname(__FILE__) . '/../collections'));

$lasterror = '';
set_error_handler(
    function($errno, $errstr) {
        global $lasterror;
        $lasterror=$errstr;
    }
);

foreach (glob (dirname(__FILE__).'/validators/*_validator.php') as $validator) {
    echo(str_repeat('-', 50)."\n");
    try {
        require($validator);
    }
    catch (Exception $e) {
        echo($e->getMessage()."\n");
        echo("Validation suspended at this stage!\n");
        break;
    }
}
echo(str_repeat('-', 50)."\n");
