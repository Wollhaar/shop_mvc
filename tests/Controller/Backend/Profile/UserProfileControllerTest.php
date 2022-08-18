<?php
declare(strict_types=1);

namespace ShopTest\Controller\Backend\Profile;

use Shop\Controller\Backend\Profile\UserProfileController;
use Shop\Core\View;
use Shop\Model\EntityManager\UserEntityManager;
use Shop\Model\Mapper\UsersMapper;
use Shop\Model\Repository\UserRepository;
use Shop\Service\SQLConnector;

class UserProfileControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testCreationView()
    {
        require __DIR__ . '/../../../../bootstrap-doctrine.php';

        $_REQUEST['action'] = '';
        $_REQUEST['create'] = 1;

        $view = new View();
        $usrMapper = new UsersMapper();

        $controller = new UserProfileController($view,
            new UserRepository($usrMapper, $entityManager),
            new UserEntityManager($entityManager),
            $usrMapper,
        );

        $controller->view();
        $results = $view->getParams();

        self::assertSame('User', $results['title']);
        self::assertSame('Creation', $results['subtitle']);
        self::assertTrue($results['create']);
        self::assertSame(0, $results['user']->id);
        self::assertSame('', $results['user']->username);
        self::assertSame('none', $results['user']->firstname);
        self::assertSame('none', $results['user']->lastname);
        self::assertSame('', $results['user']->created);
        self::assertSame('', $results['user']->birthday);
        self::assertFalse($results['user']->active);
    }

    public function testCreateView()
    {
        require __DIR__ . '/../../../../bootstrap-doctrine.php';

        $_REQUEST['create'] = '';
        $_REQUEST['action'] = 'create';
        $_POST['user'] = [
            'username' => 'testCREATE',
            'firstname' => 'testvorname1',
            'lastname' => 'testNachname1',
            'birthday' => '2000-01-01',
        ];

        $view = new View();
        $usrMapper = new UsersMapper();

        $controller = new UserProfileController($view,
            new UserRepository($usrMapper, $entityManager),
            new UserEntityManager($entityManager),
            $usrMapper,
        );

        $controller->view();
        $results = $view->getParams();

        self::assertSame('User', $results['title']);
        self::assertFalse($results['create']);
        self::assertSame('testCREATE', $results['subtitle']);
        self::assertSame('testCREATE', $results['user']->username);
        self::assertSame('testvorname1', $results['user']->firstname);
        self::assertSame('testNachname1', $results['user']->lastname);
        self::assertSame(date('Y-m-d h:i:s'), $results['user']->created);
        self::assertSame('2000-01-01 00:00:00', $results['user']->birthday);
        self::assertTrue($results['user']->active);

        $_REQUEST['id'] = $results['user']->id;
        $_POST['user']['id'] = $results['user']->id;
        $_POST['user']['created'] = $results['user']->created;
    }

    public function testView()
    {
        require __DIR__ . '/../../../../bootstrap-doctrine.php';

        $_REQUEST['create'] = '';
        $_REQUEST['action'] = '';
        $user = $_POST['user'];

        $view = new View();
        $usrMapper = new UsersMapper();

        $controller = new UserProfileController($view,
            new UserRepository($usrMapper, $entityManager),
            new UserEntityManager($entityManager),
            $usrMapper,
        );

        $controller->view();
        $results = $view->getParams();

        self::assertSame('User', $results['title']);
        self::assertFalse($results['create']);
        self::assertSame($user['username'], $results['subtitle']);
        self::assertSame($user['id'], $results['user']->id);
        self::assertSame($user['username'], $results['user']->username);
        self::assertSame($user['firstname'], $results['user']->firstname);
        self::assertSame($user['lastname'], $results['user']->lastname);
        self::assertSame($user['created'], $results['user']->created);
        self::assertSame('', $results['user']->updated);
        self::assertSame($user['birthday'] . ' 00:00:00', $results['user']->birthday);
        self::assertTrue($results['user']->active);
    }

    public function testSaveView()
    {
        require __DIR__ . '/../../../../bootstrap-doctrine.php';

        $_REQUEST['action'] = 'save';
        $_POST['user'] = [
            'id' => 4,
            'username' => 'testSAVE',
            'firstname' => 'testvorname1',
            'lastname' => 'testNachname1',
            'birthday' => '2001-02-01',
        ];

        $view = new View();
        $usrMapper = new UsersMapper();

        $controller = new UserProfileController($view,
            new UserRepository($usrMapper, $entityManager),
            new UserEntityManager($entityManager),
            $usrMapper,
        );

        $controller->view();
        $results = $view->getParams();

        self::assertSame('User', $results['title']);
        self::assertFalse($results['create']);
        self::assertSame('testSAVE', $results['subtitle']);
        self::assertSame('testSAVE', $results['user']->username);
        self::assertSame('testvorname1', $results['user']->firstname);
        self::assertSame('testNachname1', $results['user']->lastname);
        self::assertSame('2022-08-02 14:38:18', $results['user']->created);
        self::assertSame(date('Y-m-d h:i:s'), $results['user']->updated);
        self::assertSame('2001-02-01 00:00:00', $results['user']->birthday);
        self::assertTrue($results['user']->active);
    }

    public function testSavePasswordView()
    {
        require __DIR__ . '/../../../../bootstrap-doctrine.php';

        $_REQUEST['action'] = 'save';
        $_POST['user'] = [
            'id' => 4,
            'username' => 'testSAVE',
            'password' => 'tesPasst123',
            'firstname' => 'testvorname1',
            'lastname' => 'testNachname1',
            'birthday' => '2001-02-01',
        ];

        $view = new View();
        $usrMapper = new UsersMapper();

        $controller = new UserProfileController($view,
            new UserRepository($usrMapper, $entityManager),
            new UserEntityManager($entityManager),
            $usrMapper,
        );

        $controller->view();
        $results = $view->getParams();

        self::assertSame('User', $results['title']);
        self::assertFalse($results['create']);
        self::assertSame('testSAVE', $results['subtitle']);
        self::assertSame('testSAVE', $results['user']->username);
        self::assertSame('testvorname1', $results['user']->firstname);
        self::assertSame('testNachname1', $results['user']->lastname);
        self::assertSame('2022-08-02 14:38:18', $results['user']->created);
        self::assertSame(date('Y-m-d h:i:s'), $results['user']->updated);
        self::assertSame('2001-02-01 00:00:00', $results['user']->birthday);
        self::assertTrue($results['user']->active);
    }
}