<?php
declare(strict_types=1);

namespace ShopTest\Controller;

use PHPUnit\Framework\TestCase;
use Shop\Controller\LoginController;
use Shop\Core\Authenticator;
use Shop\Core\View;
use Shop\Model\Mapper\{CategoriesMapper, ProductsMapper, UsersMapper};
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};
use Shop\Service\Session;

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

        self::assertSame(
            [
                'user' => [
                    2, 'test', 'Test', 'Tester', 0, 0, 0, false
                ]
            ],
            [
                'user' => [$object->id, $object->username, $object->firstname, $object->lastname, $object->created, $object->updated, $object->birthday, $object->active]
            ]
        );
    }

    public function testFailedLogin()
    {
        $_REQUEST = ['username' => 'test', 'password' => 'test1234'];
        $usrRepository = new UserRepository(new UsersMapper());
        $view = new View();

        $controller = new LoginController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper()),
            $usrRepository,
            new Authenticator(new Session(true), $usrRepository)
        );

        $controller->view();
        $results = $view->getParams();
        $object = $results['user'];

        self::assertSame(
            [
                'authenticated' => ['username' => true, 'password' => false],
                'user' => [2, 'test', 'Test', 'Tester', 0, 0, 0, false]
            ],
            [
                'authenticated' => $results['authenticated'],
                'user' => [$object->id, $object->username, $object->firstname, $object->lastname, $object->created, $object->updated, $object->birthday, $object->active]
            ]
        );
    }
}