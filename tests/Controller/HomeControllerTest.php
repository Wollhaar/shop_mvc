<?php
declare(strict_types=1);

namespace ShopTest\Controller;

use PHPUnit\Framework\TestCase;
use Shop\Controller\Frontend\HomeController;
use Shop\Core\View;
use Shop\Model\Mapper\CategoriesMapper;
use Shop\Model\Repository\CategoryRepository;

class HomeControllerTest extends TestCase
{
    public function testView()
    {
        $view = new View();
        $controller = new HomeController($view,
            new CategoryRepository(new CategoriesMapper())
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('All', $results['title']);
        self::assertFalse(false, $results['activeCategory']);
        self::assertSame(1, $results['build'][0]->id);
        self::assertSame('T-Shirt', $results['build'][0]->name);
        self::assertSame(2, $results['build'][1]->id);
        self::assertSame('Pullover', $results['build'][1]->name);
        self::assertSame(3, $results['build'][2]->id);
        self::assertSame('Hosen', $results['build'][2]->name);
        self::assertSame(4, $results['build'][3]->id);
        self::assertSame('Sportswear', $results['build'][3]->name);
        self::assertSame(5, $results['build'][4]->id);
        self::assertSame('Jacken', $results['build'][4]->name);
    }
}