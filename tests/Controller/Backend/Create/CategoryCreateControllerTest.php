<?php
declare(strict_types=1);

namespace ShopTest\Controller\Backend\Create;

use Shop\Controller\Backend\Create\CategoryCreateController;
use Shop\Core\View;
use Shop\Model\Mapper\{CategoriesMapper, ProductsMapper, UsersMapper};
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};

class CategoryCreateControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testView()
    {
        $_REQUEST['category'] = [
            'name' => 'testKategorie1'
        ];

        $view = new View();
        $controller = new CategoryCreateController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper()),
            new UserRepository(new UsersMapper()),
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('Category', $results['title']);
        self::assertSame('testKategorie1', $results['category']->name);
    }
}