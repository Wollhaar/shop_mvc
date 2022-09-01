<?php
declare(strict_types=1);

namespace ShopTest\Controller\Backend\Listing;

use PHPUnit\Framework\TestCase;
use Shop\Controller\Backend\Listing\CategoryListController;
use Shop\Core\View;
use Shop\Model\EntityManager\CategoryEntityManager;
use Shop\Model\Mapper\CategoriesMapper;
use Shop\Model\Repository\CategoryRepository;
use Shop\Service\Container;

class CategoryListControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();
        $_GET = [];
    }

    public function testView()
    {
        $view = new View();
        $catMapper = new CategoriesMapper();

        $controller = new CategoryListController($view,
            new CategoryRepository($catMapper, Container::$entityManager),
            new CategoryEntityManager(Container::$entityManager),
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('Categories', $results['title']);
        self::assertSame(4, $results['categories'][0]->id);
        self::assertSame('T-Shirt', $results['categories'][0]->name);
        self::assertSame(5, $results['categories'][1]->id);
        self::assertSame('Pullover', $results['categories'][1]->name);
        self::assertSame(6, $results['categories'][2]->id);
        self::assertSame('Hosen', $results['categories'][2]->name);
        self::assertSame(7, $results['categories'][3]->id);
        self::assertSame('Sportswear', $results['categories'][3]->name);
        self::assertSame(8, $results['categories'][4]->id);
        self::assertSame('Jacken', $results['categories'][4]->name);
    }

    public function testDeleteView()
    {
        $_GET['action'] = 'delete';
        $_GET['id'] = '34';

        $view = new View();
        $catMapper = new CategoriesMapper();

        $controller = new CategoryListController($view,
            new CategoryRepository($catMapper, Container::$entityManager),
            new CategoryEntityManager(Container::$entityManager)
        );

        $controller->view();
        $results = $view->getParams();

        self::assertSame('Categories', $results['title']);
        self::assertSame(4, $results['categories'][0]->id);
        self::assertSame('T-Shirt', $results['categories'][0]->name);
        self::assertSame(5, $results['categories'][1]->id);
        self::assertSame('Pullover', $results['categories'][1]->name);
        self::assertSame(6, $results['categories'][2]->id);
        self::assertSame('Hosen', $results['categories'][2]->name);
        self::assertSame(7, $results['categories'][3]->id);
        self::assertSame('Sportswear', $results['categories'][3]->name);
        self::assertSame(8, $results['categories'][4]->id);
        self::assertSame('Jacken', $results['categories'][4]->name);
    }
}