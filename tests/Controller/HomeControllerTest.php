<?php
declare(strict_types=1);

namespace ShopTest\Controller;

use PHPUnit\Framework\TestCase;
use Shop\Controller\HomeController;
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