<?php
declare(strict_types=1);

namespace ShopTest\Controller\Backend\Listing;

use Shop\Controller\Backend\Listing\ProductListController;
use Shop\Core\View;
use Shop\Model\EntityManager\ProductEntityManager;
use Shop\Model\Mapper\ProductsMapper;
use Shop\Model\Repository\ProductRepository;

class ProductListControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testView()
    {
        require __DIR__ . '/../../../../bootstrap-doctrine.php';

        $view = new View();
        $controller = new ProductListController($view,
            new ProductRepository(new ProductsMapper(), $entityManager),
            new ProductEntityManager($entityManager),
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('Product', $results['title']);
        self::assertSame(7, $results['products'][6]->id);
        self::assertSame('Shirt No.1', $results['products'][6]->name);
        self::assertSame(8, $results['products'][7]->id);
        self::assertSame('HSV - Home-Jersey', $results['products'][7]->name);
        self::assertSame(9, $results['products'][8]->id);
        self::assertSame('Hoodie - Kapuzenpulli', $results['products'][8]->name);
        self::assertSame(10, $results['products'][9]->id);
        self::assertSame('Denim', $results['products'][9]->name);
        self::assertSame(11, $results['products'][10]->id);
        self::assertSame('Bandshirt - Outkast', $results['products'][10]->name);
        self::assertSame(12, $results['products'][11]->id);
        self::assertSame('Jogger', $results['products'][11]->name);
        self::assertSame(13, $results['products'][12]->id);
        self::assertSame('plain white', $results['products'][12]->name);
        self::assertSame(14, $results['products'][13]->id);
        self::assertSame('Strickjacke', $results['products'][13]->name);
    }

    public function testDeleteView()
    {
        require __DIR__ . '/../../../../bootstrap-doctrine.php';

        $_GET['action'] = 'delete';
        $_GET['id'] = 4;

        $view = new View();
        $controller = new ProductListController($view,
            new ProductRepository(new ProductsMapper(), $entityManager),
            new ProductEntityManager($entityManager)
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('Product', $results['title']);
        self::assertSame(7, $results['products'][6]->id);
        self::assertSame('Shirt No.1', $results['products'][6]->name);
        self::assertSame(8, $results['products'][7]->id);
        self::assertSame('HSV - Home-Jersey', $results['products'][7]->name);
        self::assertSame(9, $results['products'][8]->id);
        self::assertSame('Hoodie - Kapuzenpulli', $results['products'][8]->name);
        self::assertSame(10, $results['products'][9]->id);
        self::assertSame('Denim', $results['products'][9]->name);
        self::assertSame(11, $results['products'][10]->id);
        self::assertSame('Bandshirt - Outkast', $results['products'][10]->name);
        self::assertSame(12, $results['products'][11]->id);
        self::assertSame('Jogger', $results['products'][11]->name);
        self::assertSame(13, $results['products'][12]->id);
        self::assertSame('plain white', $results['products'][12]->name);
        self::assertSame(14, $results['products'][13]->id);
        self::assertSame('Strickjacke', $results['products'][13]->name);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $_GET = [];
    }
}