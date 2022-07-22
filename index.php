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


$userRepository = new \Shop\Model\Repository\UserRepository(new \Shop\Model\Mapper\UsersMapper(), new \Shop\Service\SQLConnector());
$authenticator = new \Shop\Core\Authenticator($session, $userRepository);


$controllerName = class_search($page, $backend ?? '');
$controller = new $controllerName(
    new \Shop\Core\View(),
    new \Shop\Model\Repository\CategoryRepository(
        new \Shop\Model\Mapper\CategoriesMapper(),
        new \Shop\Service\SQLConnector()
    ),
    new \Shop\Model\Repository\ProductRepository(
        new \Shop\Model\Mapper\ProductsMapper(),
        new \Shop\Service\SQLConnector()
    ),
    $userRepository,
    $authenticator
);

$controller->view();
$controller->display();
