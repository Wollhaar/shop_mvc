<?php
declare(strict_types=1);

namespace ShopTest\Controller;

use PHPUnit\Framework\TestCase;
use Shop\Controller\ProfileController;
use Shop\Core\View;
use Shop\Model\Mapper\{CategoriesMapper, ProductsMapper, UsersMapper};
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};

class SaveControllerTest extends TestCase
{
    public function testSaveProductView()
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

        self::assertSame([
            'product' => [1, 'shirt no.1', 'M,L', 'T-Shirt', 21, 220, true]
        ],
            [
                'product' => [
                    $results['product']->id,
                    $results['product']->name,
                    $results['product']->size,
                    $results['product']->category,
                    $results['product']->price,
                    $results['product']->amount,
                    $results['product']->active,
                ]
            ]);
    }

    public function testSaveUserView()
    {
        $_REQUEST['page'] = 'user';
        $_REQUEST['id'] = 3;

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
            'user' => [2, 'maxi', 'Chuck', 'Tester', 1657664319, 1657711119, 863301600, true]
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