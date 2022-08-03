<?php
declare(strict_types=1);

namespace ShopTest\Controller\Backend\Listing;

use Shop\Controller\Backend\Listing\UserListController;
use Shop\Core\View;
use Shop\Model\Mapper\{CategoriesMapper, ProductsMapper, UsersMapper};
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};
use Shop\Service\SQLConnector;

class UserListControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testView()
    {
        $view = new View();
        $catMapper = new CategoriesMapper();
        $prodMapper = new ProductsMapper();
        $usrMapper = new UsersMapper();
        $connector = new SQLConnector();

        $controller = new UserListController($view,
            new CategoryRepository($catMapper, $connector),
            new ProductRepository($prodMapper, $connector),
            new UserRepository($usrMapper, $connector)
        );

        $controller->view();
        $results = $view->getParams();

        self::assertSame('Users', $results['title']);
        self::assertSame(1, $results['users'][0]->id);
        self::assertSame('dave', $results['users'][0]->username);
        self::assertSame(2, $results['users'][1]->id);
        self::assertSame('test', $results['users'][1]->username);
        self::assertSame(3, $results['users'][2]->id);
        self::assertSame('maxi', $results['users'][2]->username);
    }

    public function testDeleteView()
    {
        $_REQUEST['action'] = 'delete';
        $_REQUEST['id'] = 4;

        $view = new View();
        $catMapper = new CategoriesMapper();
        $prodMapper = new ProductsMapper();
        $usrMapper = new UsersMapper();
        $connector = new SQLConnector();

        $controller = new UserListController($view,
            new CategoryRepository($catMapper, $connector),
            new ProductRepository($prodMapper, $connector),
            new UserRepository($usrMapper, $connector)
        );

        $controller->view();
        $results = $view->getParams();

        self::assertSame('Users', $results['title']);
        self::assertSame(1, $results['users'][0]->id);
        self::assertSame('dave', $results['users'][0]->username);
        self::assertSame(2, $results['users'][1]->id);
        self::assertSame('test', $results['users'][1]->username);
        self::assertSame(3, $results['users'][2]->id);
        self::assertSame('maxi', $results['users'][2]->username);
    }
}