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
        require __DIR__ . '/../../../bootstrap-doctrine.php';

        $_REQUEST['id'] = '';

        $view = new View();
        $catMapper = new CategoriesMapper();

        $controller = new CategoryController($view,
            new CategoryRepository($catMapper, $entityManager),
            new ProductRepository(new ProductsMapper(), $entityManager)
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('All', $results['title']);
        self::assertSame(4, $results['build'][0]->id);
        self::assertSame('T-Shirt', $results['build'][0]->name);
        self::assertSame(5, $results['build'][1]->id);
        self::assertSame('Pullover', $results['build'][1]->name);
        self::assertSame(6, $results['build'][2]->id);
        self::assertSame('Hosen', $results['build'][2]->name);
        self::assertSame(7, $results['build'][3]->id);
        self::assertSame('Sportswear', $results['build'][3]->name);
        self::assertSame(8, $results['build'][4]->id);
        self::assertSame('Jacken', $results['build'][4]->name);
   }

    public function testProductCategoryView()
    {
        require __DIR__ . '/../../../bootstrap-doctrine.php';

        $_REQUEST['id'] = 7;

        $view = new View();
        $catMapper = new CategoriesMapper();

        $controller = new CategoryController($view,
            new CategoryRepository($catMapper, $entityManager),
            new ProductRepository(new ProductsMapper(), $entityManager),
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('Sportswear', $results['title']);
        self::assertTrue($results['activeCategory']);
        self::assertSame('HSV - Home-Jersey', $results['build'][1]->name);
    }

    public function testProductCategoryView2nd()
    {
        require __DIR__ . '/../../../bootstrap-doctrine.php';

        $_REQUEST['id'] = 4;

        $view = new View();
        $catMapper = new CategoriesMapper();

        $controller = new CategoryController($view,
            new CategoryRepository($catMapper, $entityManager),
            new ProductRepository(new ProductsMapper(), $entityManager),
        );
        $controller->view();
        $results = $view->getParams();

        self::assertTrue($results['activeCategory']);
        self::assertSame('T-Shirt', $results['title']);
        self::assertSame('Shirt No.1', $results['build'][1]->name);
        self::assertSame('Bandshirt - Outkast', $results['build'][2]->name);
        self::assertSame('plain white', $results['build'][3]->name);
    }
}