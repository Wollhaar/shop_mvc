<?php declare(strict_types=1);
include_once './config.php';

use Controller\Shop\CategoryController as CategoryControl;
use Controller\Shop\ProductController;
use View\FrontController;
use View\Page\HomeController;

$request = $_REQUEST;
$page = $request['page'];

$id = $request['id'] ?? 0;

switch ($page)
{
    case 'category':
        $control = new CategoryControl();

        FrontController::build($control->getById(intval($id))->summarize(), 'category');
        FrontController::setPage($control->view()->call());
        break;

    case 'detail':
        $control = new ProductController();

        FrontController::build($control->getById(intval($id))->summmarize(), 'detail');
        FrontController::setPage($control->view()->call());
        break;

    default:
        $control = new HomeController();
}


include_once ROOT_PATH . '/src/View/Resources/Layout/' . FrontController::currentLayout() . '.php';

