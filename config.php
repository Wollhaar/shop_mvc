<?php declare(strict_types=1);

//spl_autoload_register(function ($class_name) {
//    include '.\\src\\' . $class_name . '.php';
//});

define("ROOT_PATH", __DIR__);

require_once ROOT_PATH . '/vars.php';
require_once ROOT_PATH . '/src/Model/Category.php';
require_once ROOT_PATH . '/src/Model/Product.php';
require_once ROOT_PATH . '/src/Controller/BasicController.php';
require_once ROOT_PATH . '/src/Controller/HomeController.php';
require_once ROOT_PATH . '/src/Controller/CategoryController.php';
require_once ROOT_PATH . '/src/Controller/ProductController.php';
