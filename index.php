<?php declare(strict_types=1);
include_once './config.php';


$request = $_REQUEST;
$path = explode('/', $_SERVER['PATH_INFO'] ?? '');

$page = $request['page'] ?? 'home';

$session = new \Shop\Service\Session();
if ($page === 'logout') {
    $session->logout();
    $page = 'home';
}

if ($path[1] === 'backend') {
    $backend = array_pop($path);
}


$catMapper = new \Shop\Model\Mapper\CategoriesMapper();
$prodMapper = new \Shop\Model\Mapper\ProductsMapper();
$usrMapper = new \Shop\Model\Mapper\UsersMapper();


$userRepository = new \Shop\Model\Repository\UserRepository($usrMapper, new \Shop\Service\SQLConnector());
$authenticator = new \Shop\Core\Authenticator($session, $userRepository);


$controllerName = class_search($page, $backend ?? '');
$controller = new $controllerName(
    new \Shop\Core\View(),
    new \Shop\Model\Repository\CategoryRepository(
        $catMapper,
        new \Shop\Service\SQLConnector()
    ),
    new \Shop\Model\Repository\ProductRepository(
        $prodMapper,
        new \Shop\Service\SQLConnector()
    ),
    $userRepository,
    $catMapper,
    $prodMapper,
    $usrMapper,
    $authenticator
);

$controller->view();
$controller->display();
