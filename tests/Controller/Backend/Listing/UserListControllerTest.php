<?php
declare(strict_types=1);

namespace ShopTest\Controller\Backend\Listing;

use Shop\Controller\Backend\Listing\UserListController;
use Shop\Core\View;
use Shop\Model\EntityManager\UserEntityManager;
use Shop\Model\Mapper\UsersMapper;
use Shop\Model\Repository\UserRepository;

class UserListControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testView()
    {
        require __DIR__ . '/../../../../bootstrap-doctrine.php';
        unset($_GET['action']);

        $view = new View();
        $usrMapper = new UsersMapper();
        $controller = new UserListController($view,
            new UserRepository($usrMapper, $entityManager),
            new UserEntityManager($entityManager)
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
        require __DIR__ . '/../../../../bootstrap-doctrine.php';

        $_GET['action'] = 'delete';
        $_GET['id'] = 5;

        $view = new View();
        $usrMapper = new UsersMapper();

        $controller = new UserListController($view,
            new UserRepository($usrMapper, $entityManager),
            new UserEntityManager($entityManager)
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