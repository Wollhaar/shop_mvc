<?php
declare(strict_types=1);

namespace ShopTest\Controller\Frontend;

use PHPUnit\Framework\TestCase;
use Shop\Controller\Frontend\HomeController;
use Shop\Core\View;
use Shop\Model\Mapper\CategoriesMapper;
use Shop\Model\Repository\CategoryRepository;
use Shop\Service\SQLConnector;

class HomeControllerTest extends TestCase
{
    public function testView()
    {
        $view = new View();
        $controller = new HomeController($view,
            new CategoryRepository(new CategoriesMapper(), new SQLConnector())
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('Shop', $results['title']);
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