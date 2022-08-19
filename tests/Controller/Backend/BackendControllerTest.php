<?php
declare(strict_types=1);

namespace ShopTest\Controller\Backend;

use Shop\Controller\Backend\BackendController;
use Shop\Core\Authenticator;
use Shop\Core\View;
use Shop\Model\Mapper\UsersMapper;
use Shop\Model\Repository\UserRepository;
use Shop\Service\Session;

class BackendControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testView()
    {
        require __DIR__ . '/../../../bootstrap-doctrine.php';

        $usrMapper = new UsersMapper();
        $usrRepository = new UserRepository($usrMapper, $entityManager);

        $session = new Session(true);
        $session->set(['auth' => true, $usrRepository->findUserById(2)], 'user');

        $view = new View();

        $controller = new BackendController($view,
            new Authenticator(new Session(true), $usrRepository)
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('Dashboard', $results['title']);
        self::assertSame(2, $results['user']->id);
        self::assertSame('test', $results['user']->username);
        self::assertSame('Chuck', $results['user']->firstname);
        self::assertSame('Tester', $results['user']->lastname);
        self::assertSame('2022-07-13', $results['user']->created);
        self::assertSame('1997-11-05', $results['user']->birhtday);
        self::assertTrue($results['user']->active);
    }
}