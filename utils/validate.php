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

$all_files = [];

if (isset($argv[1]) && $argv[1] == 'diff') {
    $result = shell_exec('git status --porcelain 2>&1');
    preg_match_all('/^...collections\/(.*)\/(.*)$/m', $result, $regs);
    for ($i = 0; $i < count($regs[0]); $i++) {
        $key = COLLECTIONS_PATH . '/' . $regs[1][$i];
        if (!isset($all_files[$key]))
            $all_files[$key] = [$key . '/' . $regs[2][$i]];
        else
            $all_files[$key][] = $key . '/' . $regs[2][$i];
    }
}
else {
    foreach (glob (COLLECTIONS_PATH . '/*') as $collection) {
        if (!is_dir($collection)) continue;

        $all_files[$collection] = [];
        foreach( glob ($collection.'/*.xml') as $file)
            $all_files[$collection][] = $file;    
    }  
}


$no_error = true;

echo(str_repeat('=', 50)."\n");

foreach (glob (dirname(__FILE__).'/validators/*_validator.php') as $validator) {
    try {
        require($validator);
    }
    catch (Exception $e) {
        echo($e->getMessage()."\n");
        echo("Validation suspended at this stage!\n");
        $no_error = false;
        break;
    }
    echo(str_repeat('-', 50)."\n");
}

if ($no_error) {
    require(__DIR__ . '/contents_generator.php');
    echo(str_repeat('=', 50)."\n");
}    
