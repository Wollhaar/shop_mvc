<?php declare(strict_types=1);
include_once './config.php';

use Shop\Controller\HomeController;
use Shop\Service\ControllerProvider;

$request = $_REQUEST;

$page = $request['page'] ?? 'home';
$page = requestClass_translation[$page] ?? '';

$controller = new HomeController();
$provider = new ControllerProvider();
$controllerList = $provider->getList();

foreach ($controllerList as $controllerName) {
    if (str_contains($controllerName, $page) && class_exists($controllerName)) {
        $controller = new $controllerName();
        break;
    }
}
$controller->view();
