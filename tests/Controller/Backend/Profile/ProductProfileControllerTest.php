<?php declare(strict_types=1);

namespace ShopTest\Controller\Backend\Profile;

use Shop\Controller\Backend\Profile\ProductProfileController;
use Shop\Core\View;
use Shop\Model\Mapper\{CategoriesMapper, ProductsMapper, UsersMapper};
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};
use Shop\Service\SQLConnector;

class ProductProfileControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testView()
    {
        $_REQUEST['id'] = 1;

        $view = new View();
        $catMapper = new CategoriesMapper();
        $prodMapper = new ProductsMapper();
        $connector = new SQLConnector();

        $controller = new ProductProfileController($view,
            new CategoryRepository($catMapper, $connector),
            new ProductRepository($prodMapper, $connector),
            new UserRepository(new UsersMapper(), $connector),
            $catMapper,
            $prodMapper
        );

        $controller->view();
        $results = $view->getParams();

        self::assertSame(1, $results['product']->id);
        self::assertSame('shirt no.1', $results['product']->name);
        self::assertSame('M,L,XL', $results['product']->size);
        self::assertSame('T-Shirt', $results['product']->category);
        self::assertSame(21.0, $results['product']->price);
        self::assertSame(220, $results['product']->amount);
        self::assertTrue($results['product']->active);
    }

    public function testCreationView()
    {
        $_REQUEST['create'] = 1;
        $_REQUEST['id'] = '';

        $view = new View();
        $catMapper = new CategoriesMapper();
        $prodMapper = new ProductsMapper();
        $connector = new SQLConnector();

        $controller = new ProductProfileController($view,
            new CategoryRepository($catMapper, $connector),
            new ProductRepository($prodMapper, $connector),
            new UserRepository(new UsersMapper(), $connector),
            $catMapper,
            $prodMapper
        );

        $controller->view();
        $results = $view->getParams();

        self::assertSame('Product', $results['title']);
        self::assertSame('Creation', $results['subtitle']);
        self::assertTrue($results['create']);
        self::assertSame(0, $results['product']->id);
        self::assertSame('none', $results['product']->name);
        self::assertSame('none', $results['product']->size);
        self::assertSame('none', $results['product']->category);
        self::assertSame(0.0, $results['product']->price);
        self::assertSame(0, $results['product']->amount);
        self::assertFalse($results['product']->active);
    }

    public function testCreateView()
    {
        $_REQUEST['product'] = [
            'name' => 'Testhose',
            'size' => 'W:30;L:34',
            'category' => 3,
            'price' => 34.55,
            'amount' => 130,
            'active' => true,
        ];

        $view = new View();
        $catMapper = new CategoriesMapper();
        $prodMapper = new ProductsMapper();
        $connector = new SQLConnector();

        $controller = new ProductProfileController($view,
            new CategoryRepository($catMapper, $connector),
            new ProductRepository($prodMapper, $connector),
            new UserRepository(new UsersMapper(), $connector),
            $catMapper,
            $prodMapper
        );

        $controller->view();
        $results = $view->getParams();

        self::assertSame('Product', $results['title']);
        self::assertSame('Testhose', $results['product']->name);
        self::assertSame('W:30;L:34', $results['product']->size);
        self::assertSame('Hosen', $results['product']->category);
        self::assertSame(34.55, $results['product']->price);
        self::assertSame(130, $results['product']->amount);
        self::assertTrue($results['product']->active);
    }

    public function testSaveView()
    {
        $_REQUEST['product'] = [
            'id' => 9,
            'name' => 'Testhose',
            'size' => 'W:30;L:34',
            'category' => 3,
            'price' => 34.55,
            'amount' => 130,
            'active' => true,
        ];


        $view = new View();
        $catMapper = new CategoriesMapper();
        $prodMapper = new ProductsMapper();
        $connector = new SQLConnector();

        $controller = new ProductProfileController($view,
            new CategoryRepository($catMapper, $connector),
            new ProductRepository($prodMapper, $connector),
            new UserRepository(new UsersMapper(), $connector),
            $catMapper,
            $prodMapper
        );

        $controller->view();
        $results = $view->getParams();

        self::assertSame('Product', $results['title']);
        self::assertSame(9, $results['product']->id);
        self::assertSame('Testhose', $results['product']->name);
        self::assertSame('W:30;L:34', $results['product']->size);
        self::assertSame('Hosen', $results['product']->category);
        self::assertSame(34.55, $results['product']->price);
        self::assertSame(130, $results['product']->amount);
        self::assertTrue($results['product']->active);
    }
}