<?php
declare(strict_types=1);

namespace ShopTest\Controller\Backend\Profile;

use Shop\Controller\Backend\Profile\CategoryProfileController;
use Shop\Core\View;
use Shop\Model\Mapper\{CategoriesMapper, ProductsMapper, UsersMapper};
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};
use Shop\Service\SQLConnector;

class CategoryProfileControllerTest extends \PHPUnit\Framework\TestCase
{

    public function testView()
    {
        $_REQUEST['id'] = 1;

        $view = new View();
        $catMapper = new CategoriesMapper();
        $connector = new SQLConnector();

        $controller = new CategoryProfileController($view,
            new CategoryRepository($catMapper, $connector),
            new ProductRepository(new ProductsMapper(), $connector),
            new UserRepository(new UsersMapper(), $connector),
            $catMapper
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame(1, $results['category']->id);
        self::assertSame('T-Shirt', $results['category']->name);
        self::assertTrue($results['category']->active);
    }

    public function testCreationView()
    {
        $_REQUEST['create'] = 1;
        $_REQUEST['id'] = '';

        $view = new View();
        $catMapper = new CategoriesMapper();
        $connector = new SQLConnector();

        $controller = new CategoryProfileController($view,
            new CategoryRepository($catMapper, $connector),
            new ProductRepository(new ProductsMapper(), $connector),
            new UserRepository(new UsersMapper(), $connector),
            $catMapper
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('Category', $results['title']);
        self::assertSame('Creation', $results['subtitle']);
        self::assertTrue($results['create']);
        self::assertSame(0, $results['category']->id);
        self::assertSame('All', $results['category']->name);
        self::assertFalse($results['category']->active);
    }

    public function testCreateView()
    {
        $_REQUEST['action'] = 'create';
        $_REQUEST['category'] = ['name'=>'testKategorie1'];

        $view = new View();
        $catMapper = new CategoriesMapper();
        $connector = new SQLConnector();

        $controller = new CategoryProfileController($view,
            new CategoryRepository($catMapper, $connector),
            new ProductRepository(new ProductsMapper(), $connector),
            new UserRepository(new UsersMapper(), $connector),
        $catMapper
        );
        $controller->view();
        $results = $view->getParams();


        self::assertSame('Category', $results['title']);
        self::assertSame('testKategorie1', $results['category']->name);
        self::assertTrue($results['category']->active);
    }
}