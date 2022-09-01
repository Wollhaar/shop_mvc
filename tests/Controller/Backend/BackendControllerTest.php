<?php
declare(strict_types=1);

namespace ShopTest\Controller\Backend;

use Shop\Controller\Backend\BackendController;
use Shop\Core\Authenticator;
use Shop\Core\View;
use Shop\Model\Mapper\UsersMapper;
use Shop\Model\Repository\UserRepository;
use Shop\Service\Container;
use Shop\Service\Session;

class BackendControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testView()
    {
        $usrMapper = new UsersMapper();
        $usrRepository = new UserRepository($usrMapper, Container::$entityManager);

        $session = new Session(true);
        $session->set(true, 'auth');
        $session->set($usrRepository->findUserById(3), 'user');

        $view = new View();
        $controller = new BackendController($view,
            new Authenticator($session, $usrRepository)
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('Dashboard', $results['title']);
        self::assertSame('Welcome maxi', $results['subtitle']);
        self::assertSame(3, $results['user']->id);
        self::assertSame('maxi', $results['user']->username);
        self::assertTrue($results['user']->active);
        self::assertSame('standard', $results['user']->role);
    }

    public function testAdminView()
    {
        $usrMapper = new UsersMapper();
        $usrRepository = new UserRepository($usrMapper, Container::$entityManager);

        $session = new Session(true);
        $session->set(true, 'auth');
        $session->set($usrRepository->findUserById(2), 'user');

        $view = new View();
        $controller = new BackendController($view,
            new Authenticator($session, $usrRepository)
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('Dashboard', $results['title']);
        self::assertSame('Welcome test', $results['subtitle']);
        self::assertSame(2, $results['user']->id);
        self::assertSame('test', $results['user']->username);
        self::assertTrue($results['user']->active);
        self::assertSame('admin', $results['user']->role);
    }

    public function testRootView()
    {
        $usrMapper = new UsersMapper();
        $usrRepository = new UserRepository($usrMapper, Container::$entityManager);

        $session = new Session(true);
        $session->set(true, 'auth');
        $session->set($usrRepository->findUserById(4), 'user');

        $view = new View();
        $controller = new BackendController($view,
            new Authenticator($session, $usrRepository)
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('Dashboard', $results['title']);
        self::assertSame('Welcome root', $results['subtitle']);
        self::assertSame(4, $results['user']->id);
        self::assertSame('root', $results['user']->username);
        self::assertTrue($results['user']->active);
        self::assertSame('root', $results['user']->role);
    }
}