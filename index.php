<?php declare(strict_types=1);
include_once './config.php';


$service = new \Shop\Service\MainService();
$service->action();

$controller = $service->getController();
$controller->display();
