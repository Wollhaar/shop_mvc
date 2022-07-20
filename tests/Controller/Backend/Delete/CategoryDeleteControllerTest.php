<?php
declare(strict_types=1);

namespace ShopTest\Controller\Backend\Delete;

use Shop\Controller\Backend\Delete\CategoryDeleteController;
use Shop\Core\View;
use Shop\Model\Mapper\{CategoriesMapper, ProductsMapper, UsersMapper};
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};

class CategoryDeleteControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testView()
    {
        $_REQUEST['id'] = 6;

        $view = new View();
        $controller = new CategoryDeleteController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper()),
            new UserRepository(new UsersMapper()),
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('Categories', $results['title']);
        self::assertSame(1, $results['categories'][1]->id);
        self::assertSame('T-Shirt', $results['categories'][1]->name);
        self::assertSame(2, $results['categories'][2]->id);
        self::assertSame('Pullover', $results['categories'][2]->name);
        self::assertSame(3, $results['categories'][3]->id);
        self::assertSame('Hosen', $results['categories'][3]->name);
        self::assertSame(4, $results['categories'][4]->id);
        self::assertSame('Sportswear', $results['categories'][4]->name);
        self::assertSame(5, $results['categories'][5]->id);
        self::assertSame('Jacken', $results['categories'][5]->name);
    }
}