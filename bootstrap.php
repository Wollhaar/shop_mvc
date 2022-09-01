<?php declare(strict_types=1);

$get = $_GET;
$path = explode('/', $_SERVER['PATH_INFO'] ?? '');

$page = $get['page'] ?? 'home';

$container = new \Shop\Service\Container();
$dependencyProvider = new \Shop\Service\DependencyProvider();
$dependencyProvider->provide($container);

$session = $container->get(\Shop\Service\Session::class);
if ($page === 'logout') {
    $session->logout();
    $page = 'home';
}

if (isset($path[1]) && $path[1] === 'backend') {
    $backend = array_pop($path);
}


$controllerName = class_search($page, $backend ?? '');
$controller = $container->get($controllerName);

$controller->view();