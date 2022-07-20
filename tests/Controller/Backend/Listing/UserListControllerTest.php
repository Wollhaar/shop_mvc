<?php
declare(strict_types=1);

namespace ShopTest\Controller\Backend\Listing;

use Shop\Controller\Backend\Listing\UserListController;
use Shop\Core\View;
use Shop\Model\Mapper\{CategoriesMapper, ProductsMapper, UsersMapper};
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};

class UserListControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testView()
    {
        $view = new View();
        $controller = new UserListController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper()),
            new UserRepository(new UsersMapper()),
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('Users', $results['title']);
        self::assertSame(1, $results['users'][1]->id);
        self::assertSame('dave', $results['users'][1]->username);
        self::assertSame(2, $results['users'][2]->id);
        self::assertSame('test', $results['users'][2]->username);
        self::assertSame(3, $results['users'][3]->id);
        self::assertSame('maxi', $results['users'][3]->username);
    }
}