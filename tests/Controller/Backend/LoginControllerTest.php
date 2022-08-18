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
use Shop\Service\SQLConnector;

class LoginControllerTest extends TestCase
{
    public function testView()
    {
        require __DIR__ . '/../../../bootstrap-doctrine.php';

        $_POST = ['username' => 'test', 'password' => 'test123'];
        $usrMapper = new UsersMapper();
        $usrRepository = new UserRepository($usrMapper, $entityManager);

        $view = new View();
        $session = new Session(true);

        $controller = new LoginController($view,
            $usrRepository,
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
        require __DIR__ . '/../../../bootstrap-doctrine.php';

        $_REQUEST = ['username' => 'test', 'password' => 'test1234'];
        $usrMapper = new UsersMapper();

        $usrRepository = new UserRepository($usrMapper, $entityManager);
        $view = new View();

        $controller = new LoginController($view,
            $usrRepository,
            new Authenticator(new Session(true), $usrRepository)
        );

        $controller->view();
        $results = $view->getParams();
        $object = $results['user'];

        self::assertSame(2, $object->id);
        self::assertSame('test', $object->username);
        self::assertSame('Chuck', $object->firstname);
        self::assertSame('Tester', $object->lastname);
        self::assertSame('2022-07-13 00:00:00', $object->created);
        self::assertSame('1997-11-05 00:00:00', $object->birthday);
        self::assertTrue($object->active);
    }
}