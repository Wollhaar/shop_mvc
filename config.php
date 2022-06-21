<?php declare(strict_types=1);

define("ROOT_PATH", __DIR__);

require __DIR__ . '/vendor/autoload.php';


const requestClass_translation = [
    'category' => 'CategoryController',
    'home' => 'HomeController',
    'detail' => 'ProductController',
];


// class functions
function class_search(array $check): string
{
    $provider = new \Shop\Service\ControllerProvider();
    $controllerList = $provider->getList();
    $controller = $controllerList[$provider::HOME];

    foreach ($check as $name) {
        $controller = requestClass_translation[$name];
    }

    foreach ($controllerList as $controllerName) {
        if (str_contains($controllerName, $controller)) {
            $controller = $controllerName;
            break;
        }
    }

    if (!class_exists($controller)) {
//        throw Error;
        echo 'class not found';
        $controller = $controllerList[$provider::HOME];
    }
    return $controller;
}

//elseif (array_key_exists($page, $request)) {
//    $class = class_search($page);
//    if (!in_array($class, $controllerList, true)) {
//        die('Sorry, something went wrong');
//    }
//    $controller = new $controllerList[$page]();
//}
//else {
//    $controller = new HomeController();
//}