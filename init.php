<?php defined('SYSPATH') OR die('No direct access allowed.');

spl_autoload_register(function ($class) {
    if (!substr($class, 0, 9) === 'Flysystem') {
        return;
    }

    $location = __DIR__.'/vendor/flysystem/src/'.str_replace('\\', '/', $class).'.php';

    if (is_file($location)) {
        require_once($location);
    }
});
