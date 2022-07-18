<?php
declare(strict_types=1);

namespace ShopTest\Controller;

use PHPUnit\Framework\TestCase;
use Shop\Controller\Backend\SaveController;
use Shop\Core\View;
use Shop\Model\Mapper\{CategoriesMapper, ProductsMapper, UsersMapper};
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};

class SaveControllerTest extends TestCase
{
    public function testSaveProductView()
    {
        $_REQUEST['page'] = 'product';
        $_REQUEST['product'] = [
            'id' => 1,
            'name' => 'shirt no.1',
            'size' => 'M,L,XL',
            'category' => 1,
            'price' => 21,
            'amount' => 220,
            'active' => true,
        ];;

        $view = new View();
        $controller = new SaveController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper()),
            new UserRepository(new UsersMapper()),
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('Product', $results['title']);
        self::assertSame(1, $results['product']->id);
        self::assertSame('shirt no.1', $results['product']->name);
        self::assertSame('M,L,XL', $results['product']->size);
        self::assertSame('T-Shirt', $results['product']->category);
        self::assertSame(21.0, $results['product']->price);
        self::assertSame(220, $results['product']->amount);
        self::assertTrue($results['product']->active);
    }

    public function testSaveUserView()
    {
        $_REQUEST['page'] = 'user';
        $_REQUEST['user'] = [
            'id' => 3,
            'username' => 'maxi',
            'firstname' => 'Test',
            'lastname' => 'Tester',
            'created' => '2022-07-13',
            'birthday' => '1997-04-11',
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
        self::assertSame(3, $results['user']->id);
        self::assertSame('maxi', $results['user']->username);
        self::assertSame('Test', $results['user']->firstname);
        self::assertSame('Tester', $results['user']->lastname);
        self::assertSame(1657664319, $results['user']->created);
        self::assertSame(1657711119, $results['user']->updated);
        self::assertSame(860709600, $results['user']->birthday);
        self::assertTrue($results['user']->active);
    }
}