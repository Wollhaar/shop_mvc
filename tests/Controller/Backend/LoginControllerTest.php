<?php
declare(strict_types=1);

namespace ShopTest\Controller\Backend;

use PHPUnit\Framework\TestCase;
use Shop\Controller\Backend\LoginController;
use Shop\Core\Authenticator;
use Shop\Core\View;
use Shop\Model\Mapper\UsersMapper;
use Shop\Model\Repository\UserRepository;
use Shop\Service\Session;

class LoginControllerTest extends TestCase
{
    public function testView()
    {
        $_POST = ['username' => 'test', 'password' => 'test123'];
        $usrMapper = new UsersMapper();
        $usrRepository = new UserRepository($usrMapper, $entityManager);

        $view = new View();
        $session = new Session(true);

        $controller = new LoginController($view,
            new Authenticator($session, $usrRepository),
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
        $_POST = ['username' => 'test', 'password' => 'test1234'];
        $usrMapper = new UsersMapper();

        $usrRepository = new UserRepository($usrMapper, $entityManager);
        $view = new View();

        $controller = new LoginController($view,
            new Authenticator(new Session(true), $usrRepository)
        );

        $controller->view();
        $results = $view->getParams();

        self::assertTrue($results['authentication']);
        self::assertFalse($results['wrongUsername']);
        self::assertTrue($results['wrongPassword']);
    }

    protected function setUp(): void
    {
        parent::setUp();
        require __DIR__ . '/../../../bootstrap-doctrine.php';
    }
}