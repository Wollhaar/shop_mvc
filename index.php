<?php declare(strict_types=1);
include_once './config.php';

use Controller\Shop\CategoryController as CategoryControl;
use Controller\Shop\ProductController;
use View\FrontController;
use Controller\HomeController;

$request = $_REQUEST;
$page = $request['page'];

$id = $request['id'] ?? 0;

switch ($page)
{
    case 'category':
        $control = new CategoryControl();


        $category = $control->getById((int) $id);
        $exist = (bool) $control->getById((int) $id)->getId();

        FrontController::build($category->summarize(), 'category', $exist);
        FrontController::setPage($control->view()->call());
        break;

    case 'detail':
        $control = new ProductController();

        $product = $control->getById((int) $id);
        $exist = (bool) $control->getById((int) $id)->getId();

        FrontController::build($control->getById((int) $id)->summmarize(), 'detail', $exist);
        FrontController::setPage($control->view()->call());
        break;

    default:
        $control = new HomeController();
}


include_once ROOT_PATH . '/src/View/Resources/Layout/' . FrontController::currentLayout() . '.php';

