<?php
declare(strict_types=1);

namespace ShopTest\Controller\Frontend;

use PHPUnit\Framework\TestCase;
use Shop\Controller\Frontend\DetailController;
use Shop\Core\View;
use Shop\Model\Mapper\ProductsMapper;
use Shop\Model\Repository\ProductRepository;

class DetailControllerTest extends TestCase
{
    public function testPositive()
    {
        require __DIR__ . '/../../../bootstrap-doctrine.php';

        $_GET['page'] = 'detail';
        $_GET['id'] = 8;

        $view = new View();
        $controller = new DetailController($view,
            new ProductRepository(new ProductsMapper(), $entityManager),
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame(8, $results['product']->id);
        self::assertSame('HSV - Home-Jersey', $results['product']->name);
        self::assertSame('M,L', $results['product']->size);
        self::assertSame('Sportswear', $results['product']->category);
        self::assertSame(80.9, $results['product']->price);
        self::assertSame(200, $results['product']->amount);
        self::assertTrue($results['product']->active);
    }

    public function testNegative()
    {
        require __DIR__ . '/../../../bootstrap-doctrine.php';

        $view = new View();
        $controller = new DetailController($view,
            new ProductRepository(new ProductsMapper(), $entityManager)
        );
        $controller->view();
        $results = $view->getParams();

        self::assertNull($results['product']);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $_GET = [];
    }
}