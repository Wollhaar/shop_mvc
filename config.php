<?php declare(strict_types=1);

//spl_autoload_register(function ($class_name) {
//    include '.\\src\\' . $class_name . '.php';
//});

define("ROOT_PATH", __DIR__);

require_once ROOT_PATH . '/src/Model/Shop/Category.php';
require_once ROOT_PATH . '/src/Model/Shop/Product.php';
require_once ROOT_PATH . '/src/View/FrontController.php';
require_once ROOT_PATH . '/src/View/Engine/Response.php';
require_once ROOT_PATH . '/src/View/Engine/Template.php';
require_once ROOT_PATH . '/src/Controller/HomeController.php';
require_once ROOT_PATH . '/src/Controller/Shop/CategoryController.php';
require_once ROOT_PATH . '/src/Controller/Shop/ProductController.php';
