<?php declare(strict_types=1);

namespace ShopTest\Controller\Backend\Profile;

use Shop\Controller\Backend\Profile\ProductProfileController;
use Shop\Core\View;
use Shop\Model\Mapper\{CategoriesMapper, ProductsMapper};
use Shop\Model\Repository\{CategoryRepository, ProductRepository};
use Shop\Model\EntityManager\ProductEntityManager;

class ProductProfileControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testView()
    {
        require __DIR__ . '/../../../../bootstrap-doctrine.php';

        $_GET['id'] = 14;

        $view = new View();
        $catMapper = new CategoriesMapper();
        $prodMapper = new ProductsMapper();

        $controller = new ProductProfileController($view,
            new CategoryRepository($catMapper, $entityManager),
            new ProductRepository($prodMapper, $entityManager),
            new ProductEntityManager($entityManager),
            $prodMapper
        );

        $controller->view();
        $results = $view->getParams();

        self::assertSame(14, $results['product']->id);
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
        require __DIR__ . '/../../../../bootstrap-doctrine.php';

        $_GET['create'] = 1;

        $view = new View();
        $catMapper = new CategoriesMapper();
        $prodMapper = new ProductsMapper();

        $controller = new ProductProfileController($view,
            new CategoryRepository($catMapper, $entityManager),
            new ProductRepository($prodMapper, $entityManager),
            new ProductEntityManager($entityManager),
            $prodMapper
        );

        $controller->view();
        $results = $view->getParams();

        self::assertSame('Product', $results['title']);
        self::assertSame('Creation', $results['subtitle']);
        self::assertTrue($results['create']);
        self::assertNull($results['product']);
    }

    public function testCreateView()
    {
        require __DIR__ . '/../../../../bootstrap-doctrine.php';

        $_POST['product'] = [
            'name' => 'TesthoseCREATE',
            'size' => 'W:30;L:34',
            'color' => 'schwarz,braun',
            'category' => 'Hosen',
            'price' => 34.55,
            'amount' => 130,
            'active' => true,
        ];
        $_GET['action'] = 'create';

        $view = new View();
        $catMapper = new CategoriesMapper();
        $prodMapper = new ProductsMapper();

        $controller = new ProductProfileController($view,
            new CategoryRepository($catMapper, $entityManager),
            new ProductRepository($prodMapper, $entityManager),
            new ProductEntityManager($entityManager),
            $prodMapper
        );

        $controller->view();
        $results = $view->getParams();

        self::assertSame('Product', $results['title']);
        self::assertSame('TesthoseCREATE', $results['product']->name);
        self::assertSame('W:30;L:34', $results['product']->size);
        self::assertSame('schwarz,braun', $results['product']->color);
        self::assertSame('Hosen', $results['product']->category);
        self::assertSame(34.55, $results['product']->price);
        self::assertSame(130, $results['product']->amount);
        self::assertTrue($results['product']->active);
    }

    public function testSaveView()
    {
        require __DIR__ . '/../../../../bootstrap-doctrine.php';

        $_GET['action'] = 'save';
        $_POST['product'] = [
            'id' => 15,
            'name' => 'TesthoseSAVE',
            'size' => 'W:30;L:34',
            'color' => 'schwarz,grau,braun',
            'category' => 'Hosen',
            'price' => 34.55,
            'amount' => 130,
            'active' => true,
        ];

        $view = new View();
        $catMapper = new CategoriesMapper();
        $prodMapper = new ProductsMapper();

        $controller = new ProductProfileController($view,
            new CategoryRepository($catMapper, $entityManager),
            new ProductRepository($prodMapper, $entityManager),
            new ProductEntityManager($entityManager),
            $prodMapper
        );

        $controller->view();
        $results = $view->getParams();

        self::assertSame('Product', $results['title']);
        self::assertSame(15, $results['product']->id);
        self::assertSame('TesthoseSAVE', $results['product']->name);
        self::assertSame('W:30;L:34', $results['product']->size);
        self::assertSame('schwarz,grau,braun', $results['product']->color);
        self::assertSame('Hosen', $results['product']->category);
        self::assertSame(34.55, $results['product']->price);
        self::assertSame(130, $results['product']->amount);
        self::assertTrue($results['product']->active);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $_GET = [];
    }
}