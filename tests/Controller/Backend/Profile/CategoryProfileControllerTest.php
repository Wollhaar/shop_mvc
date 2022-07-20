<?php
declare(strict_types=1);

namespace ShopTest\Controller\Backend\Profile;

use Shop\Controller\Backend\Profile\CategoryProfileController;
use Shop\Core\View;
use Shop\Model\Mapper\{CategoriesMapper, ProductsMapper, UsersMapper};
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};

class CategoryProfileControllerTest extends \PHPUnit\Framework\TestCase
{

    public function testView()
    {
        $_REQUEST['id'] = 1;

        $view = new View();
        $controller = new CategoryProfileController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper()),
            new UserRepository(new UsersMapper()),
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame(1, $results['category']->id);
        self::assertSame('T-Shirt', $results['category']->name);
        self::assertTrue($results['category']->active);
    }

    public function testCreationView()
    {
        $_REQUEST['create'] = 1;
        $_REQUEST['id'] = '';

        $view = new View();
        $controller = new CategoryProfileController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper()),
            new UserRepository(new UsersMapper()),
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('Category', $results['title']);
        self::assertSame('Creation', $results['subtitle']);
        self::assertTrue($results['create']);
        self::assertSame(0, $results['category']->id);
        self::assertSame('All', $results['category']->name);
        self::assertFalse($results['category']->active);
    }
}