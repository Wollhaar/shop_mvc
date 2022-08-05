<?php declare(strict_types=1);

define("ROOT_PATH", __DIR__);
require __DIR__ . '/vendor/autoload.php';


function class_search(string $name, string $backend): string
{
    $name = ucfirst(strtolower($name));
    $provider = new \Shop\Service\ControllerProvider();
    $controllerList = $provider->getFrontendList();
    if ($backend !== '') {
        $controllerList = $provider->getBackendList();
        if ($name === 'Home') {
            $name = '';
        }
        $name .= ucfirst(strtolower($backend));
    }
    $controller = '';

    foreach ($controllerList as $controllerName) {
        if (str_contains($controllerName, $name)) {
            $controller = $controllerName;
            break;
        }
    }

    if (!class_exists($controller)) {
        $controller = $provider::ERROR;
        try {
            throw new \Shop\Model\Error(404);
        }
        catch (\Shop\Model\Error $e) {
            $e->setIssue($name);
            \Shop\Controller\ErrorController::setError($e);
        }
    }
    return $controller;
}