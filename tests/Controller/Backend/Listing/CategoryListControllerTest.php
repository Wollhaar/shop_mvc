<?php
declare(strict_types=1);

namespace ShopTest\Controller\Backend\Listing;

use PHPUnit\Framework\TestCase;
use Shop\Controller\Backend\Listing\CategoryListController;
use Shop\Core\View;
use Shop\Model\Mapper\CategoriesMapper;
use Shop\Model\Repository\CategoryRepository;
use Shop\Service\SQLConnector;

class CategoryListControllerTest extends TestCase
{
    public function testView()
    {
        $_REQUEST['page'] = 'categories';

        $view = new View();
        $catMapper = new CategoriesMapper();
        $connector = new SQLConnector();

        $controller = new CategoryListController($view, new CategoryRepository($catMapper, $connector));
        $controller->view();
        $results = $view->getParams();

        self::assertSame('Categories', $results['title']);
        self::assertSame(1, $results['categories'][0]->id);
        self::assertSame('T-Shirt', $results['categories'][0]->name);
        self::assertSame(2, $results['categories'][1]->id);
        self::assertSame('Pullover', $results['categories'][1]->name);
        self::assertSame(3, $results['categories'][2]->id);
        self::assertSame('Hosen', $results['categories'][2]->name);
        self::assertSame(4, $results['categories'][3]->id);
        self::assertSame('Sportswear', $results['categories'][3]->name);
        self::assertSame(5, $results['categories'][4]->id);
        self::assertSame('Jacken', $results['categories'][4]->name);
    }

    public function testDeleteView()
    {
        $_REQUEST['action'] = 'delete';
        $_REQUEST['id'] = '';

        $view = new View();
        $catMapper = new CategoriesMapper();
        $connector = new SQLConnector();

        $controller = new CategoryListController($view,
            new CategoryRepository($catMapper, $connector)
        );

        $controller->view();
        $results = $view->getParams();

        self::assertSame('Categories', $results['title']);
        self::assertSame(1, $results['categories'][0]->id);
        self::assertSame('T-Shirt', $results['categories'][0]->name);
        self::assertSame(2, $results['categories'][1]->id);
        self::assertSame('Pullover', $results['categories'][1]->name);
        self::assertSame(3, $results['categories'][2]->id);
        self::assertSame('Hosen', $results['categories'][2]->name);
        self::assertSame(4, $results['categories'][3]->id);
        self::assertSame('Sportswear', $results['categories'][3]->name);
        self::assertSame(5, $results['categories'][4]->id);
        self::assertSame('Jacken', $results['categories'][4]->name);
    }
}