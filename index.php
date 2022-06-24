<?php declare(strict_types=1);
include_once './config.php';


$request = $_REQUEST;
$page = $request['page'] ?? 'home';

$controllerName = class_search($page);
$controller = new $controllerName(new \Shop\Core\View());
$controller->view();
$controller->display();
