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
        $_REQUEST['create'] = 1;
        $_REQUEST['id'] = '';

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
        self::assertSame(0, $results['user']->created);
        self::assertSame(0, $results['user']->birthday);
        self::assertFalse($results['user']->active);
    }

    public function testCreateView()
    {
        $uniqueName = 'test' . uniqid();

        $_REQUEST['action'] = 'create';
        $_REQUEST['user'] = [
            'username' => $uniqueName,
            'firstname' => 'testvorname1',
            'lastname' => 'testNachname1',
            'birthday' => '2000-01-01',
            'active' => true,
        ];

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
        self::assertSame($uniqueName, $results['subtitle']);
        self::assertSame($uniqueName, $results['user']->username);
        self::assertSame('testvorname1', $results['user']->firstname);
        self::assertSame('testNachname1', $results['user']->lastname);
        self::assertSame(date('Y-m-d'), $results['user']->created);
        self::assertSame('2000-01-01', $results['user']->birthday);
        self::assertTrue($results['user']->active);

        $_REQUEST['id'] = $results['user']->id;
    }

    public function testView()
    {
        $_REQUEST['create'] = '';

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
        self::assertSame('test', $results['subtitle']);
        self::assertSame(2, $results['user']->id);
        self::assertSame('test', $results['user']->username);
        self::assertSame('Chuck', $results['user']->firstname);
        self::assertSame('Tester', $results['user']->lastname);
        self::assertSame('2022-07-13', $results['user']->created);
        self::assertSame('2022-07-13', $results['user']->updated);
        self::assertSame('1997-11-05', $results['user']->birthday);
        self::assertTrue($results['user']->active);
    }

    public function testSaveView()
    {
        $uniqueName = $_REQUEST['user']['username'];

        $_REQUEST['action'] = 'create';
        $_REQUEST['user'] = [
            'username' => $uniqueName,
            'firstname' => 'testvorname1',
            'lastname' => 'testNachname1',
            'birthday' => '2001-02-01',
            'active' => true,
        ];

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
        self::assertSame($uniqueName, $results['subtitle']);
        self::assertSame($uniqueName, $results['user']->username);
        self::assertSame('testvorname1', $results['user']->firstname);
        self::assertSame('testNachname1', $results['user']->lastname);
        self::assertSame(date('Y-m-d'), $results['user']->created);
        self::assertSame(date('Y-m-d'), $results['user']->updated);
        self::assertSame('2001-02-01', $results['user']->birthday);
        self::assertTrue($results['user']->active);
    }
}