<?php declare(strict_types=1);

namespace ShopTest\Controller;

use PHPUnit\Framework\TestCase;
use Shop\Controller\CategoryController;
use Shop\Core\View;
use Shop\Model\Dto\CategoryDataTransferObject;
use Shop\Model\Mapper\CategoriesMapper;
use Shop\Model\Mapper\ProductsMapper;
use Shop\Model\Repository\CategoryRepository;
use Shop\Model\Repository\ProductRepository;

class CategoryControllerTest extends TestCase
{
    public function testView()
    {
        $_REQUEST['page'] = 'category';

        $view = new View();
        $controller = new CategoryController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper())
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame([
            'title' => 'All',
            'activeCategory' => false,
            'build' => [
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
        ]);
    }

    public function testProductCategoryView()
    {
        $_REQUEST['page'] = 'category';
        $_REQUEST['id'] = 4;

        $view = new View();
        $controller = new CategoryController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper())
        );
        $controller->view();

        self::assertSame([
            'title' => 'Sportswear',
            'activeCategory' => true,
            'build' => [
                2 => 'HSV - Home-Jersey'
            ]
        ], $view->getParams());
    }

    public function testProductCategoryView2nd()
    {
        $_REQUEST['page'] = 'category';
        $_REQUEST['id'] = 1;

        $view = new View();
        $controller = new CategoryController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper())
        );
        $controller->view();

        self::assertSame([
            'title' => 'T-Shirt',
            'activeCategory' => true,
            'build' => [
                1 => 'shirt no.1',
                5 => 'Bandshirt - Outkast',
                7 => 'plain white',
            ]
        ], $view->getParams());
    }
}