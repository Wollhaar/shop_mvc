<?php declare(strict_types=1);
include_once './config.php';


$request = $_REQUEST;
$page = $request['page'] ?? 'home';

$path = $_SERVER['PATH_INFO'] ?? '';
$controller = class_search([explode('/', $path)[1], $page]);

$controller = new $controller();
$controller->view();
