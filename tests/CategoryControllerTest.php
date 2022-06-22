<?php declare(strict_types=1);

namespace ShopTest;

use PHPUnit\Framework\TestCase;
use Shop\Controller\CategoryController;

class CategoryControllerTest extends TestCase
{
    public function testCheck()
    {
        $controller = new CategoryController();
        $controller->view();
        self::assertSame([
            'title' => 'All',
            'activeCategory' => false,
            'output' => [
                1 => 'T-Shirt',
                2 => 'Pullover',
                3 => 'Hosen',
                4 => 'Sportswear'
            ]
        ], $controller->check());
    }
}