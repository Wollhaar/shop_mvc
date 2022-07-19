<?php
declare(strict_types=1);

namespace ShopTest\Controller;

use Shop\Controller\Backend\ProfileController;
use Shop\Core\View;
use Shop\Model\Mapper\{CategoriesMapper, ProductsMapper, UsersMapper};
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};

class ProfileControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testProductView()
    {
        $_REQUEST['page'] = 'product';
        $_REQUEST['id'] = 1;

        $view = new View();
        $controller = new ProfileController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper()),
            new UserRepository(new UsersMapper()),
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame(1, $results['product']->id);
        self::assertSame('shirt no.1', $results['product']->name);
        self::assertSame('M,L', $results['product']->size);
        self::assertSame('T-Shirt', $results['product']->category);
        self::assertSame(21.0, $results['product']->price);
        self::assertSame(220, $results['product']->amount);
        self::assertTrue($results['product']->active);
    }

    public function testUserView()
    {
        $_REQUEST['page'] = 'user';
        $_REQUEST['id'] = 2;

        $view = new View();
        $controller = new ProfileController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper()),
            new UserRepository(new UsersMapper()),
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame([
            'title' => 'User',
            'user' => [2, 'test', 'Chuck', 'Tester', 1657664319, 1657711119, 863301600, true]
        ],
            [
                'title' => $results['title'],
                'user' => [
                    $results['user']->id,
                    $results['user']->username,
                    $results['user']->firstname,
                    $results['user']->lastname,
                    $results['user']->created,
                    $results['user']->updated,
                    $results['user']->birthday,
                    $results['user']->active,
                ]
            ]);
    }
}