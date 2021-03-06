<?php declare(strict_types=1);

namespace ShopTest\Controller\Frontend;

use PHPUnit\Framework\TestCase;
use Shop\Controller\Frontend\CategoryController;
use Shop\Core\View;
use Shop\Model\Mapper\CategoriesMapper;
use Shop\Model\Mapper\ProductsMapper;
use Shop\Model\Repository\CategoryRepository;
use Shop\Model\Repository\ProductRepository;

class CategoryControllerTest extends TestCase
{
    public function testView()
    {
        $view = new View();
        $controller = new CategoryController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper())
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('All', $results['title']);
        self::assertSame(1, $results['build'][1]->id);
        self::assertSame('T-Shirt', $results['build'][1]->name);
        self::assertSame(2, $results['build'][2]->id);
        self::assertSame('Pullover', $results['build'][2]->name);
        self::assertSame(3, $results['build'][3]->id);
        self::assertSame('Hosen', $results['build'][3]->name);
        self::assertSame(4, $results['build'][4]->id);
        self::assertSame('Sportswear', $results['build'][4]->name);
        self::assertSame(5, $results['build'][5]->id);
        self::assertSame('Jacken', $results['build'][5]->name);
    }

    public function testProductCategoryView()
    {
        $_REQUEST['id'] = 4;

        $view = new View();
        $controller = new CategoryController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper())
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('Sportswear', $results['title']);
        self::assertTrue($results['activeCategory']);
        self::assertSame('HSV - Home-Jersey', $results['build'][2]->name);
    }

    public function testProductCategoryView2nd()
    {
        $_REQUEST['id'] = 1;

        $view = new View();
        $controller = new CategoryController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper())
        );
        $controller->view();
        $results = $view->getParams();

        self::assertTrue($results['activeCategory']);
        self::assertSame('T-Shirt', $results['title']);
        self::assertSame('shirt no.1', $results['build'][1]->name);
        self::assertSame('Bandshirt - Outkast', $results['build'][5]->name);
        self::assertSame('plain white', $results['build'][7]->name);
    }
}