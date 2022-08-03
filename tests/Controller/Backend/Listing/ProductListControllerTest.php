<?php
declare(strict_types=1);

namespace ShopTest\Controller\Backend\Listing;

use Shop\Controller\Backend\Listing\ProductListController;
use Shop\Core\View;
use Shop\Model\Mapper\{CategoriesMapper, ProductsMapper, UsersMapper};
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};
use Shop\Service\SQLConnector;

class ProductListControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testView()
    {
        $_REQUEST['action'] = '';
        $_REQUEST['id'] = '';

        $view = new View();
        $catMapper = new CategoriesMapper();
        $connector = new SQLConnector();

        $controller = new ProductListController($view,
            new CategoryRepository($catMapper, $connector),
            new ProductRepository(new ProductsMapper(), $connector),
            new UserRepository(new UsersMapper(), $connector),
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('Product', $results['title']);
        self::assertSame(1, $results['products'][0]->id);
        self::assertSame('shirt no.1', $results['products'][0]->name);
        self::assertSame(2, $results['products'][1]->id);
        self::assertSame('HSV - Home-Jersey', $results['products'][1]->name);
        self::assertSame(3, $results['products'][2]->id);
        self::assertSame('Hoodie - Kapuzenpulli', $results['products'][2]->name);
        self::assertSame(4, $results['products'][3]->id);
        self::assertSame('Denim', $results['products'][3]->name);
        self::assertSame(5, $results['products'][4]->id);
        self::assertSame('Bandshirt - Outkast', $results['products'][4]->name);
        self::assertSame(6, $results['products'][5]->id);
        self::assertSame('Jogger', $results['products'][5]->name);
        self::assertSame(7, $results['products'][6]->id);
        self::assertSame('plain white', $results['products'][6]->name);
        self::assertSame(8, $results['products'][7]->id);
        self::assertSame('Strickjacke', $results['products'][7]->name);
    }

    public function testDeleteView()
    {
        $_REQUEST['action'] = 'delete';
        $_REQUEST['id'] = 9;

        $view = new View();
        $catMapper = new CategoriesMapper();
        $connector = new SQLConnector();

        $controller = new ProductListController($view,
            new CategoryRepository($catMapper, $connector),
            new ProductRepository(new ProductsMapper(), $connector),
            new UserRepository(new UsersMapper(), $connector),
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('Product', $results['title']);
        self::assertSame(1, $results['products'][0]->id);
        self::assertSame('shirt no.1', $results['products'][0]->name);
        self::assertSame(2, $results['products'][1]->id);
        self::assertSame('HSV - Home-Jersey', $results['products'][1]->name);
        self::assertSame(3, $results['products'][2]->id);
        self::assertSame('Hoodie - Kapuzenpulli', $results['products'][2]->name);
        self::assertSame(4, $results['products'][3]->id);
        self::assertSame('Denim', $results['products'][3]->name);
        self::assertSame(5, $results['products'][4]->id);
        self::assertSame('Bandshirt - Outkast', $results['products'][4]->name);
        self::assertSame(6, $results['products'][5]->id);
        self::assertSame('Jogger', $results['products'][5]->name);
        self::assertSame(7, $results['products'][6]->id);
        self::assertSame('plain white', $results['products'][6]->name);
        self::assertSame(8, $results['products'][7]->id);
        self::assertSame('Strickjacke', $results['products'][7]->name);
    }
}