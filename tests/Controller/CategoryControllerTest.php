<?php declare(strict_types=1);

namespace ShopTest\Controller;

use PHPUnit\Framework\TestCase;
use Shop\Controller\CategoryController;
use Shop\Core\View;

class CategoryControllerTest extends TestCase
{
    public function testView()
    {
        $_REQUEST['page'] = 'category';

        $view = new View();
        $controller = new CategoryController($view);
        $controller->view();

        self::assertSame([
            'title' => 'All',
            'activeCategory' => false,
            'build' => [
                1 => [
                    'id' => 1,
                    'name' => 'T-Shirt'
                ],
                2 => [
                    'id' => 2,
                    'name' => 'Pullover'
                ],
                3 => [
                    'id' => 3,
                    'name' => 'Hosen'
                ],
                4 => [
                    'id'=> 4,
                    'name' => 'Sportswear'
                ]
            ]
        ], $view->getParams());
    }

    public function testProductCategoryView()
    {
        $_REQUEST['page'] = 'category';
        $_REQUEST['id'] = 4;

        $view = new View();
        $controller = new CategoryController($view);
        $controller->view();

        self::assertSame([
            'title' => 'Sportswear',
            'activeCategory' => true,
            'build' => [
                2 => 'HSV - Home-Jersey'
            ]
        ], $view->getParams());
    }

    public function testProductCategoryView2nd()
    {
        $_REQUEST['page'] = 'category';
        $_REQUEST['id'] = 1;

        $view = new View();
        $controller = new CategoryController($view);
        $controller->view();

        self::assertSame([
            'title' => 'T-Shirt',
            'activeCategory' => true,
            'build' => [
                1 => 'shirt no.1',
                5 => 'Bandshirt - Outkast',
            ]
        ], $view->getParams());
    }
}