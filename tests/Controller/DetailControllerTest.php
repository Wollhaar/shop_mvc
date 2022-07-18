<?php
declare(strict_types=1);

namespace ShopTest\Controller;

use PHPUnit\Framework\TestCase;
use Shop\Controller\Frontend\DetailController;
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

        self::assertSame(2, $results['product']->id);
        self::assertSame('HSV - Home-Jersey', $results['product']->name);
        self::assertSame('M,L', $results['product']->size);
        self::assertSame('Sportswear', $results['product']->category);
        self::assertSame(80.9, $results['product']->price);
        self::assertSame(200, $results['product']->amount);
        self::assertTrue($results['product']->active);
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

        self::assertSame(0, $results['product']->id);
        self::assertSame('none', $results['product']->name);
        self::assertSame('none', $results['product']->size);
        self::assertSame('none', $results['product']->category);
        self::assertSame(0.0, $results['product']->price);
        self::assertSame(0, $results['product']->amount);
        self::assertTrue($results['product']->active);
    }
}