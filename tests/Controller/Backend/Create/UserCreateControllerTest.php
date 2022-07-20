<?php
declare(strict_types=1);

namespace ShopTest\Controller\Backend\Create;

use Shop\Controller\Backend\Create\UserCreateController;
use Shop\Core\View;
use Shop\Model\Mapper\CategoriesMapper;
use Shop\Model\Mapper\ProductsMapper;
use Shop\Model\Mapper\UsersMapper;
use Shop\Model\Repository\CategoryRepository;
use Shop\Model\Repository\ProductRepository;
use Shop\Model\Repository\UserRepository;

class UserCreateControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testView()
    {
        $_REQUEST['page'] = 'user';
        $_REQUEST['user'] = [
            'username' => 'test1',
            'firstname' => 'testvorname1',
            'lastname' => 'testNachname1',
            'birthday' => '2000-01-01',
            'active' => true,
        ];

        $view = new View();
        $controller = new UserCreateController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper()),
            new UserRepository(new UsersMapper()),
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('User', $results['title']);
        self::assertSame('test1', $results['user']->username);
        self::assertSame('testvorname1', $results['user']->firstname);
        self::assertSame('testNachname1', $results['user']->lastname);
        self::assertSame(946684800, $results['user']->birthday);
        self::assertTrue($results['user']->active);
    }
}