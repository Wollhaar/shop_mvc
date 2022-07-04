<?php
declare(strict_types=1);

namespace ShopTest\Controller;

use PHPUnit\Framework\TestCase;
use Shop\Controller\DetailController;
use Shop\Core\View;
use Shop\Model\Mapper\CategoriesMapper;
use Shop\Model\Mapper\ProductsMapper;
use Shop\Model\Repository\CategoryRepository;
use Shop\Model\Repository\ProductRepository;

class DetailControllerTest extends TestCase
{
    public function testPositive()
    {
        $_REQUEST['page'] = 'detail';
        $_REQUEST['id'] = 2;

        $view = new View();
        $controller = new DetailController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper())
        );
        $controller->view();

        self::assertSame([
            'id' => 2,
            'name' => 'HSV - Home-Jersey',
            'size' => 'M',
            'category' => 'Sportswear',
            'price' => 80.9,
            'amount' => 200
        ], $view->getParams());
    }

    public function testNegative()
    {
        $_REQUEST['page'] = 'detail';
        $_REQUEST['id'] = 0;

        $view = new View();
        $controller = new DetailController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper())
        );
        $controller->view();

        self::assertSame([
            'id' => 0,
            'name' => 'none',
            'size' => 'none',
            'category' => 'none',
            'price' => 0.0,
            'amount' => 0
        ], $view->getParams());
    }
}