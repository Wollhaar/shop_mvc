<?php declare(strict_types=1);
include_once './config.php';


$request = $_REQUEST;
$page = $request['page'] ?? 'home';

$controller = class_search($page);
$controller = new $controller();

$controller->view();
$controller->display();
