<?php
declare(strict_types=1);

namespace ShopTest\Controller\Backend\Delete;

use Shop\Controller\Backend\Delete\UserDeleteController;
use Shop\Core\View;
use Shop\Model\Mapper\CategoriesMapper;
use Shop\Model\Mapper\ProductsMapper;
use Shop\Model\Mapper\UsersMapper;
use Shop\Model\Repository\CategoryRepository;
use Shop\Model\Repository\ProductRepository;
use Shop\Model\Repository\UserRepository;

class UserDeleteControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testView()
    {
        $_REQUEST['id'] = 5;

        $view = new View();
        $controller = new UserDeleteController($view,
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