<?php
declare(strict_types=1);

namespace ShopTest\Controller\Backend;

use PHPUnit\Framework\TestCase;
use Shop\Controller\Backend\LoginController;
use Shop\Core\Authenticator;
use Shop\Core\View;
use Shop\Model\Mapper\{CategoriesMapper, ProductsMapper, UsersMapper};
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};
use Shop\Service\Session;
use Shop\Service\SQLConnector;

class LoginControllerTest extends TestCase
{
    public function testView()
    {
        $_POST = ['username' => 'test', 'password' => 'test123'];
        $usrRepository = new UserRepository(new UsersMapper());

        $view = new View();
        $session = new Session(true);

        $controller = new LoginController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper()),
            $usrRepository,
            new Authenticator($session, $usrRepository)
        );

        $controller->view();
        $results = $view->getParams();
        $object = $results['user'];

        self::assertSame(2, $object->id);
        self::assertSame('test', $object->username);
        self::assertSame('Test', $object->firstname);
        self::assertSame('Tester', $object->lastname);
        self::assertSame(0, $object->created);
        self::assertSame(0, $object->updated);
        self::assertSame(0, $object->birthday);
        self::assertSame(0, $object->active);
    }

    public function testFailedLogin()
    {
        $_REQUEST = ['username' => 'test', 'password' => 'test1234'];
        $catMapper = new CategoriesMapper();
        $prodMapper = new ProductsMapper();
        $usrMapper = new UsersMapper();

        $connector = new SQLConnector();
        $usrRepository = new UserRepository($usrMapper, $connector);
        $view = new View();

        $controller = new LoginController($view,
            new CategoryRepository($catMapper, $connector),
            new ProductRepository($prodMapper, $connector),
            $usrRepository,
            $catMapper,
            $prodMapper,
            $usrMapper,
            new Authenticator(new Session(true), $usrRepository)
        );

        $controller->view();
        $results = $view->getParams();
        $object = $results['user'];

        self::assertSame(2, $object->id);
        self::assertSame('test', $object->username);
        self::assertSame('Chuck', $object->firstname);
        self::assertSame('Tester', $object->lastname);
        self::assertSame(1657664319, $object->created);
        self::assertSame(863301600, $object->birthday);
        self::assertTrue($object->active);
    }
}