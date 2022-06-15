<?php declare(strict_types=1);

define("ROOT_PATH", __DIR__);

require __DIR__ . '/vendor/autoload.php';

//spl_autoload_register(function ($class_name) {
//    include ROOT_PATH . '/src/' . str_replace('\\', '/', $class_name) . '.php';
//});


require_once ROOT_PATH . '/vars.php';
require_once ROOT_PATH . '/helper.php';