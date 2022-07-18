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


        self::assertSame([
            'title' => 'Shop',
            'categories' => [
                1 => [1,'T-Shirt'],
                2 => [
                    2,
                    'Pullover'
                ],
                3 => [
                    3,
                    'Hosen'
                ],
                4 => [
                    4,
                    'Sportswear'
                ]
            ]
        ], [
            'title' => $results['title'],
            'activeCategory' => $results['activeCategory'],
            'build' => [
                1 => [
                    $results['build'][0]->id,
                    $results['build'][0]->name
                ],
                2 => [
                    $results['build'][1]->id,
                    $results['build'][1]->name
                ],
                3 => [
                    $results['build'][2]->id,
                    $results['build'][2]->name
                ],
                4 => [
                    $results['build'][3]->id,
                    $results['build'][3]->name
                ],
            ]
        ]
        );
    }
}