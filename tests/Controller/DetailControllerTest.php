<?php
declare(strict_types=1);

namespace ShopTest;

use PHPUnit\Framework\TestCase;
use Shop\Controller\DetailController;
use Shop\Core\View;

class DetailControllerTest extends TestCase
{
    public function testCheck()
    {
        $_REQUEST['page'] = 'detail';
        $_REQUEST['id'] = 2;

        $view = new View();
        $controller = new DetailController($view);
        $controller->view();

        self::assertSame([
            'id' => 2,
            'name' => 'HSV - Home-Jersey',
            'size' => 'M',
            'category' => 'Sportswear',
            'price' => 80.9,
            'amount' => 200
        ], $view->getParams());
    }
}