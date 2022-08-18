<?php
declare(strict_types=1);

namespace ShopTest\Controller\Backend\Listing;

use Shop\Controller\Backend\Listing\ProductListController;
use Shop\Core\View;
use Shop\Model\EntityManager\ProductEntityManager;
use Shop\Model\Mapper\ProductsMapper;
use Shop\Model\Repository\ProductRepository;
use Shop\Service\SQLConnector;

class ProductListControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testView()
    {
        require __DIR__ . '/../../../../bootstrap-doctrine.php';

        $_REQUEST['action'] = '';
        $_REQUEST['id'] = '';

        $view = new View();
        $controller = new ProductListController($view,
            new ProductRepository(new ProductsMapper(), $entityManager),
            new ProductEntityManager($entityManager),
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('Product', $results['title']);
        self::assertSame(4, $results['products'][3]->id);
        self::assertSame('shirt no.1', $results['products'][3]->name);
        self::assertSame(5, $results['products'][4]->id);
        self::assertSame('HSV - Home-Jersey', $results['products'][4]->name);
        self::assertSame(6, $results['products'][5]->id);
        self::assertSame('Hoodie - Kapuzenpulli', $results['products'][5]->name);
        self::assertSame(7, $results['products'][6]->id);
        self::assertSame('Denim', $results['products'][6]->name);
        self::assertSame(8, $results['products'][7]->id);
        self::assertSame('Bandshirt - Outkast', $results['products'][7]->name);
        self::assertSame(9, $results['products'][8]->id);
        self::assertSame('Jogger', $results['products'][8]->name);
        self::assertSame(10, $results['products'][9]->id);
        self::assertSame('plain white', $results['products'][9]->name);
        self::assertSame(11, $results['products'][10]->id);
        self::assertSame('Strickjacke', $results['products'][10]->name);
    }

    public function testDeleteView()
    {
        require __DIR__ . '/../../../../bootstrap-doctrine.php';

        $_REQUEST['action'] = 'delete';
        $_REQUEST['id'] = 16;

        $view = new View();
        $controller = new ProductListController($view,
            new ProductRepository(new ProductsMapper(), $entityManager),
            new ProductEntityManager($entityManager)
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('Product', $results['title']);
        self::assertSame(1, $results['products'][0]->id);
        self::assertSame('shirt no.1', $results['products'][0]->name);
        self::assertSame(2, $results['products'][1]->id);
        self::assertSame('HSV - Home-Jersey', $results['products'][1]->name);
        self::assertSame(3, $results['products'][2]->id);
        self::assertSame('Hoodie - Kapuzenpulli', $results['products'][2]->name);
        self::assertSame(4, $results['products'][3]->id);
        self::assertSame('Denim', $results['products'][3]->name);
        self::assertSame(5, $results['products'][4]->id);
        self::assertSame('Bandshirt - Outkast', $results['products'][4]->name);
        self::assertSame(6, $results['products'][5]->id);
        self::assertSame('Jogger', $results['products'][5]->name);
        self::assertSame(7, $results['products'][6]->id);
        self::assertSame('plain white', $results['products'][6]->name);
        self::assertSame(8, $results['products'][7]->id);
        self::assertSame('Strickjacke', $results['products'][7]->name);
    }
}