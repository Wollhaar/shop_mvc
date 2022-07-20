<?php
declare(strict_types=1);

namespace ShopTest\Controller\Backend\Save;

use PHPUnit\Framework\TestCase;
use Shop\Controller\Backend\Save\ProductSaveController;
use Shop\Core\View;
use Shop\Model\Mapper\{CategoriesMapper, ProductsMapper, UsersMapper};
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};

class ProductSaveControllerTest extends TestCase
{
    public function testView()
    {
        $_REQUEST['product'] = [
            'id' => 12,
            'name' => 'Testhose',
            'size' => 'W:30;L:34',
            'category' => 3,
            'price' => 34.55,
            'amount' => 130,
            'active' => true,
        ];


        $view = new View();
        $controller = new ProductSaveController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper()),
            new UserRepository(new UsersMapper()),
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('Product', $results['title']);
        self::assertSame(12, $results['product']->id);
        self::assertSame('Testhose', $results['product']->name);
        self::assertSame('W:30;L:34', $results['product']->size);
        self::assertSame('Hosen', $results['product']->category);
        self::assertSame(34.55, $results['product']->price);
        self::assertSame(130, $results['product']->amount);
        self::assertTrue($results['product']->active);
    }
}