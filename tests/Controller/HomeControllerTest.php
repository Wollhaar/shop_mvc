<?php
declare(strict_types=1);

namespace ShopTest\Controller;

use PHPUnit\Framework\TestCase;
use Shop\Controller\HomeController;
use Shop\Core\View;
use Shop\Model\Repository\CategoryRepository;
use Shop\Model\Repository\ProductRepository;

class HomeControllerTest extends TestCase
{
    public function testView()
    {
        $view = new View();
        $controller = new HomeController($view, new CategoryRepository());
        $injections = [];
        foreach ($controller->getDependencies() as $dependency) {
            $injections[$dependency] = new $dependency();
        }
        $controller->injection($injections);
        $controller->view();

        self::assertSame([
            'title' => 'Shop',
            'categories' => [
                1 => [
                    'id' => 1,
                    'name' => 'T-Shirt'
                ],
                2 => [
                    'id' => 2,
                    'name' => 'Pullover'
                ],
                3 => [
                    'id' => 3,
                    'name' => 'Hosen'
                ],
                4 => [
                    'id'=> 4,
                    'name' => 'Sportswear'
                ]
            ]
        ], $view->getParams());
    }
}