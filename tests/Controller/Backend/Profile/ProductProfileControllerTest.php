<?php declare(strict_types=1);

namespace ShopTest\Controller\Backend\Profile;

use Shop\Controller\Backend\Profile\ProductProfileController;
use Shop\Core\View;
use Shop\Model\Mapper\{CategoriesMapper, ProductsMapper};
use Shop\Model\Repository\{CategoryRepository, ProductRepository};
use Shop\Service\SQLConnector;

class ProductProfileControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testView()
    {
        $_REQUEST['action'] = '';
        $_POST['product'] = '';
        $_REQUEST['id'] = 8;

        $view = new View();
        $catMapper = new CategoriesMapper();
        $prodMapper = new ProductsMapper();
        $connector = new SQLConnector();

        $controller = new ProductProfileController($view,
            new CategoryRepository($catMapper, $connector),
            new ProductRepository($prodMapper, $connector),
            $prodMapper
        );

        $controller->view();
        $results = $view->getParams();

        self::assertSame(8, $results['product']->id);
        self::assertSame('Strickjacke', $results['product']->name);
        self::assertSame('M,L,XL', $results['product']->size);
        self::assertSame('schwarz,braun,grau', $results['product']->color);
        self::assertSame('Jacken', $results['product']->category);
        self::assertSame(35.65, $results['product']->price);
        self::assertSame(50, $results['product']->amount);
        self::assertTrue($results['product']->active);
    }

    public function testCreationView()
    {
        $_REQUEST['create'] = 1;
        $_REQUEST['id'] = '';
        $_POST['product'] = '';

        $view = new View();
        $catMapper = new CategoriesMapper();
        $prodMapper = new ProductsMapper();
        $connector = new SQLConnector();

        $controller = new ProductProfileController($view,
            new CategoryRepository($catMapper, $connector),
            new ProductRepository($prodMapper, $connector),
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
        $sql = 'SELECT COUNT(*) as counted FROM products WHERE `name` LIKE "Testhose%"';
        $connector = new SQLConnector();
        $count = $connector->get($sql)[0]['counted'] + 1;
        $name = 'Testhose' . $count;

        $_POST['product'] = [
            'name' => $name,
            'size' => 'W:30;L:34',
            'color' => 'schwarz,braun',
            'category' => '3',
            'price' => 34.55,
            'amount' => 130,
            'active' => true,
        ];
        $_REQUEST['action'] = 'create';

        $view = new View();
        $catMapper = new CategoriesMapper();
        $prodMapper = new ProductsMapper();

        $controller = new ProductProfileController($view,
            new CategoryRepository($catMapper, $connector),
            new ProductRepository($prodMapper, $connector),
            $prodMapper
        );

        $controller->view();
        $results = $view->getParams();

        self::assertSame('Product', $results['title']);
        self::assertSame($name, $results['product']->name);
        self::assertSame('W:30;L:34', $results['product']->size);
        self::assertSame('schwarz,braun', $results['product']->color);
        self::assertSame('Hosen', $results['product']->category);
        self::assertSame(34.55, $results['product']->price);
        self::assertSame(130, $results['product']->amount);
        self::assertTrue($results['product']->active);
    }

    public function testSaveView()
    {
        $sql = 'SELECT COUNT(*) as counter FROM products WHERE `name` LIKE "Testhose%"';
        $connector = new SQLConnector();
        $name = 'TesthoseSAVE' . $connector->get($sql)[0]['counter'] + 1;

        $_REQUEST['action'] = 'save';
        $_POST['product'] = [
            'id' => 12,
            'name' => $name,
            'size' => 'W:30;L:34',
            'color' => 'schwarz,grau,braun',
            'category' => '3',
            'price' => 34.55,
            'amount' => 130,
            'active' => true,
        ];

        $view = new View();
        $catMapper = new CategoriesMapper();
        $prodMapper = new ProductsMapper();

        $controller = new ProductProfileController($view,
            new CategoryRepository($catMapper, $connector),
            new ProductRepository($prodMapper, $connector),
            $prodMapper
        );

        $controller->view();
        $results = $view->getParams();

        self::assertSame('Product', $results['title']);
        self::assertSame(12, $results['product']->id);
        self::assertSame($name, $results['product']->name);
        self::assertSame('W:30;L:34', $results['product']->size);
        self::assertSame('schwarz,grau,braun', $results['product']->color);
        self::assertSame('Hosen', $results['product']->category);
        self::assertSame(34.55, $results['product']->price);
        self::assertSame(130, $results['product']->amount);
        self::assertTrue($results['product']->active);
    }
}