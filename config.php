<?php declare(strict_types=1);

define("ROOT_PATH", __DIR__);

require __DIR__ . '/vendor/autoload.php';

function class_search(string $name, bool $backend): string
{
    $provider = new \Shop\Service\ControllerProvider();
    $controllerList = $provider->getFrontendList();
    if ($backend) {
        $controllerList = $provider->getBackendList();
    }
    $controller = '';

    foreach ($controllerList as $controllerName) {
        if (str_contains($controllerName, ucfirst(strtolower($name)))) {
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