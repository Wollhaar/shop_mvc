<?php
declare(strict_types=1);

namespace ShopTest\Controller\Backend\Save;

use PHPUnit\Framework\TestCase;
use Shop\Controller\Backend\Save\UserSaveController;
use Shop\Controller\Backend\SaveController;
use Shop\Core\View;
use Shop\Model\Mapper\{CategoriesMapper, ProductsMapper, UsersMapper};
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};

class UserSaveControllerTest extends TestCase
{
    public function testView()
    {
        $_REQUEST['user'] = [
            'id' => 3,
            'username' => 'maxi',
            'password' => '',
            'firstname' => 'Test',
            'lastname' => 'Tester',
            'created' => '2022-07-13',
            'birthday' => '1997-04-11',
            'active' => true,
        ];

        $view = new View();
        $controller = new UserSaveController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper()),
            new UserRepository(new UsersMapper()),
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('User', $results['title']);
        self::assertSame(3, $results['user']->id);
        self::assertSame('maxi', $results['user']->username);
        self::assertSame('Test', $results['user']->firstname);
        self::assertSame('Tester', $results['user']->lastname);
        self::assertSame(1657670400, $results['user']->created);
        self::assertSame(860716800, $results['user']->birthday);
        self::assertTrue($results['user']->active);
    }
}