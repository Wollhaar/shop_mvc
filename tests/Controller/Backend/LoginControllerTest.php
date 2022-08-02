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
        $connector = new SQLConnector();
        $catMapper = new CategoriesMapper();
        $prodMapper = new ProductsMapper();
        $usrMapper = new UsersMapper();
        $usrRepository = new UserRepository($usrMapper, $connector);

        $view = new View();
        $session = new Session(true);

        $controller = new LoginController($view,
            new CategoryRepository($catMapper, $connector),
            new ProductRepository($prodMapper, $connector),
            $usrRepository,
            $catMapper,
            $prodMapper,
            $usrMapper,
            new Authenticator($session, $usrRepository)
        );

        $controller->view();
        $results = $view->getParams();
        $object = $results['user'];

        self::assertSame(2, $object->id);
        self::assertSame('test', $object->username);
        self::assertSame('Chuck', $object->firstname);
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
        self::assertSame('2022-07-13', $object->created);
        self::assertSame('1997-11-05', $object->birthday);
        self::assertTrue($object->active);
    }
}