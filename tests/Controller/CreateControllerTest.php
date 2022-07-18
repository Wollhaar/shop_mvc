<?php
declare(strict_types=1);

namespace ShopTest\Controller;

use Shop\Model\Mapper\{CategoriesMapper, ProductsMapper, UsersMapper};
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};
use Shop\Controller\Backend\SaveController;
use Shop\Core\View;

class CreateControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testCreateProductView()
    {
        $_REQUEST['page'] = 'product';
        $_REQUEST['product'] = [
            'name' => 'Testhose',
            'size' => 'W:30;L:34',
            'category' => 3,
            'price' => 34.55,
            'amount' => 130,
            'active' => true,
        ];

        $view = new View();
        $controller = new SaveController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper()),
            new UserRepository(new UsersMapper()),
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('Product', $results['title']);
        self::assertSame('product', $results['active']);
        self::assertSame('Testhose', $results['product']->name);
        self::assertSame('W:30;L:34', $results['product']->size);
        self::assertSame('Hosen', $results['product']->category);
        self::assertSame(34.55, $results['product']->price);
        self::assertSame(130, $results['product']->amount);
        self::assertTrue($results['product']->active);
    }

    public function testCreateUserView()
    {
        $_REQUEST['page'] = 'user';
        $_REQUEST['user'] = [
            'username' => 'test1',
            'firstname' => 'testvorname1',
            'lastname' => 'testNachname1',
            'created' => '2022-07-18',
            'birthday' => '2000-01-01',
            'active' => true,
        ];

        $view = new View();
        $controller = new SaveController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper()),
            new UserRepository(new UsersMapper()),
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('User', $results['title']);
        self::assertSame('user', $results['active']);
        self::assertSame('test1', $results['user']->username);
        self::assertSame('testvorname1', $results['user']->firstname);
        self::assertSame('testNachname1', $results['user']->lastname);
        self::assertSame(1658095200, $results['user']->created);
        self::assertSame(946681200, $results['user']->birthday);
        self::assertTrue($results['category']->active);
    }

    public function testCreateCategoryView()
    {
        $_REQUEST['page'] = 'category';
        $_REQUEST['category'] = [
            'name' => 'testKategorie1',
            'active' => true,
        ];

        $view = new View();
        $controller = new SaveController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper()),
            new UserRepository(new UsersMapper()),
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('Category', $results['title']);
        self::assertSame('testKategorie1', $results['category']->name);
        self::assertTrue($results['category']->active);
    }
}