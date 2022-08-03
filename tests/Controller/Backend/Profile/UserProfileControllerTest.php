<?php
declare(strict_types=1);

namespace ShopTest\Controller\Backend\Profile;

use Shop\Controller\Backend\Profile\UserProfileController;
use Shop\Core\View;
use Shop\Model\Mapper\{CategoriesMapper, ProductsMapper, UsersMapper};
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};
use Shop\Service\SQLConnector;

class UserProfileControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testCreationView()
    {
        $_REQUEST['action'] = '';
        $_REQUEST['create'] = 1;
//        $_REQUEST['id'] = '';

        $view = new View();
        $catMapper = new CategoriesMapper();
        $prodMapper = new ProductsMapper();
        $usrMapper = new UsersMapper();
        $connector = new SQLConnector();

        $controller = new UserProfileController($view,
            new CategoryRepository($catMapper, $connector),
            new ProductRepository($prodMapper, $connector),
            new UserRepository($usrMapper, $connector),
            $catMapper,
            $prodMapper,
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
        $sql = 'SELECT COUNT(*) as counted FROM users WHERE `username` LIKE "test%"';
        $connector = new SQLConnector();
        $count = $connector->get($sql)[0]['counted'] + 1;
        $uniqueName = 'test' . $count;

        $_REQUEST['create'] = '';
        $_REQUEST['action'] = 'create';
        $_POST['user'] = [
            'username' => $uniqueName,
            'firstname' => 'testvorname1',
            'lastname' => 'testNachname1',
            'birthday' => '2000-01-01',
        ];

        $view = new View();
        $catMapper = new CategoriesMapper();
        $prodMapper = new ProductsMapper();
        $usrMapper = new UsersMapper();

        $controller = new UserProfileController($view,
            new CategoryRepository($catMapper, $connector),
            new ProductRepository($prodMapper, $connector),
            new UserRepository($usrMapper, $connector),
            $catMapper,
            $prodMapper,
            $usrMapper,
        );

        $controller->view();
        $results = $view->getParams();

        self::assertSame('User', $results['title']);
        self::assertFalse($results['create']);
        self::assertSame($uniqueName, $results['subtitle']);
        self::assertSame($uniqueName, $results['user']->username);
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
        $_REQUEST['create'] = '';
        $_REQUEST['action'] = '';
        $user = $_POST['user'];
        $_REQUEST['id'] = $user['id'];

        $view = new View();
        $catMapper = new CategoriesMapper();
        $prodMapper = new ProductsMapper();
        $usrMapper = new UsersMapper();
        $connector = new SQLConnector();

        $controller = new UserProfileController($view,
            new CategoryRepository($catMapper, $connector),
            new ProductRepository($prodMapper, $connector),
            new UserRepository($usrMapper, $connector),
            $catMapper,
            $prodMapper,
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
        $sql = 'SELECT count(*) as counter From users WHERE `username` LIKE "test%"';
        $connector = new SQLConnector();
        $uniqueName = 'testSave' . $connector->get($sql)[0]['counter'] + 1;

        $_REQUEST['action'] = 'save';
        $_POST['user'] = [
            'id' => 19,
            'username' => $uniqueName,
            'firstname' => 'testvorname1',
            'lastname' => 'testNachname1',
            'birthday' => '2001-02-01',
        ];

        $view = new View();
        $catMapper = new CategoriesMapper();
        $prodMapper = new ProductsMapper();
        $usrMapper = new UsersMapper();

        $controller = new UserProfileController($view,
            new CategoryRepository($catMapper, $connector),
            new ProductRepository($prodMapper, $connector),
            new UserRepository($usrMapper, $connector),
            $catMapper,
            $prodMapper,
            $usrMapper,
        );

        $controller->view();
        $results = $view->getParams();

        self::assertSame('User', $results['title']);
        self::assertFalse($results['create']);
        self::assertSame($uniqueName, $results['subtitle']);
        self::assertSame($uniqueName, $results['user']->username);
        self::assertSame('testvorname1', $results['user']->firstname);
        self::assertSame('testNachname1', $results['user']->lastname);
        self::assertSame('2022-08-02 14:38:18', $results['user']->created);
        self::assertSame(date('Y-m-d h:i:s'), $results['user']->updated);
        self::assertSame('2001-02-01 00:00:00', $results['user']->birthday);
        self::assertTrue($results['user']->active);
    }

    public function testSavePasswordView()
    {
        $sql = 'SELECT count(*) as counter From users WHERE `username` LIKE "test%"';
        $connector = new SQLConnector();
        $uniqueName = 'testSave' . $connector->get($sql)[0]['counter'] + 1;

        $_REQUEST['action'] = 'save';
        $_POST['user'] = [
            'id' => 19,
            'username' => $uniqueName,
            'password' => 'tesPasst123',
            'firstname' => 'testvorname1',
            'lastname' => 'testNachname1',
            'birthday' => '2001-02-01',
        ];

        $view = new View();
        $catMapper = new CategoriesMapper();
        $prodMapper = new ProductsMapper();
        $usrMapper = new UsersMapper();

        $controller = new UserProfileController($view,
            new CategoryRepository($catMapper, $connector),
            new ProductRepository($prodMapper, $connector),
            new UserRepository($usrMapper, $connector),
            $catMapper,
            $prodMapper,
            $usrMapper,
        );

        $controller->view();
        $results = $view->getParams();

        self::assertSame('User', $results['title']);
        self::assertFalse($results['create']);
        self::assertSame($uniqueName, $results['subtitle']);
        self::assertSame($uniqueName, $results['user']->username);
        self::assertSame('testvorname1', $results['user']->firstname);
        self::assertSame('testNachname1', $results['user']->lastname);
        self::assertSame('2022-08-02 14:38:18', $results['user']->created);
        self::assertSame(date('Y-m-d h:i:s'), $results['user']->updated);
        self::assertSame('2001-02-01 00:00:00', $results['user']->birthday);
        self::assertTrue($results['user']->active);
    }
}