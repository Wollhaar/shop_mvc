<?php declare(strict_types=1);
include_once './config.php';

use View\Page\CategoryController;
use View\Page\DetailController;
use View\Page\HomeController;

$request = $_REQUEST;
$page = $request['page'];

switch ($page)
{
    case 'category':
        $control = new CategoryController();
        break;

    case 'detail':
        $control = new DetailController();
        break;

    default:
        $control = new HomeController();
}

$page = $control->view();

