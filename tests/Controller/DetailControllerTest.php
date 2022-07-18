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
        $results = $view->getParams();

        self::assertSame([
            'product' => [2, 'HSV - Home-Jersey', 'M', 'Sportswear', 80.9, 200, true]
        ], [
            'product' => [
                $results['product']->id,
                $results['product']->name,
                $results['product']->size,
                $results['product']->category,
                $results['product']->price,
                $results['product']->amount,
                $results['product']->active,
            ]
        ]);
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
        $results = $view->getParams();

        self::assertSame([
            'product' => [0, 'none', 'none', 'none', 0.0, 0, false]
        ],
            [
            'product' => [
                $results['product']->id,
                $results['product']->name,
                $results['product']->size,
                $results['product']->category,
                $results['product']->price,
                $results['product']->amount,
                $results['product']->active,
            ]
        ]);
    }
}