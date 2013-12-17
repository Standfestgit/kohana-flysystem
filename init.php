<?php defined('SYSPATH') OR die('No direct access allowed.');

// Flysystem autoloading
spl_autoload_register(function ($class) {
    if (!substr($class, 0, 9) === 'Flysystem') {
        return;
    }

    $location = __DIR__.'/vendor/flysystem/src/'.str_replace('\\', '/', $class).'.php';

    if (is_file($location)) {
        require_once($location);
    }
});


// Seclib autoloading
// Set up include path accordingly. This is especially required because some
// class files of phpseclib require() other dependencies.
set_include_path(implode(PATH_SEPARATOR, array(
    __DIR__.'/vendor/phpseclib/phpseclib',
    __DIR__.'/',
    get_include_path(),
)));

function phpseclib_is_includable($suffix) {
    foreach (explode(PATH_SEPARATOR, get_include_path()) as $prefix) {
        $ds   = substr($prefix, -1) == DIRECTORY_SEPARATOR ? '' : DIRECTORY_SEPARATOR;
        $file = $prefix.$ds.$suffix;

        if (file_exists($file)) {
            return true;
        }
    }

    return false;
}

function phpseclib_autoload($class) {
    $file = str_replace('_', '/', $class).'.php';

    if (phpseclib_is_includable($file)) {
        require $file;
    }
}

spl_autoload_register('phpseclib_autoload');


