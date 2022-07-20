<?php
declare(strict_types=1);

namespace ShopTest\Controller\Backend\Profile;

use Shop\Controller\Backend\Profile\UserProfileController;
use Shop\Core\View;
use Shop\Model\Mapper\{CategoriesMapper, ProductsMapper, UsersMapper};
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};

class UserProfileControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testView()
    {
        $_REQUEST['create'] = '';
        $_REQUEST['id'] = 2;

        $view = new View();
        $controller = new UserProfileController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper()),
            new UserRepository(new UsersMapper()),
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
        self::assertSame(1657664319, $results['user']->created);
        self::assertSame(1657711119, $results['user']->updated);
        self::assertSame(863301600, $results['user']->birthday);
        self::assertTrue($results['user']->active);
    }

    public function testCreationView()
    {
        $_REQUEST['create'] = 1;
        $_REQUEST['id'] = '';

        $view = new View();
        $controller = new UserProfileController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper()),
            new UserRepository(new UsersMapper()),
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
}