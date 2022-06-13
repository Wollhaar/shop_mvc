<?php declare(strict_types=1);
include_once './config.php';

use Controller\{HomeController, CategoryController, ProductController};

$request = $_REQUEST;
$page = $request['page'];

switch ($page)
{
    case 'category':
        $controller = new CategoryController();
        break;

    case 'detail':
        $controller = new ProductController();
        break;

    default:
        $controller = new HomeController();
}


$controller->view();
flush();

unset ($controller);