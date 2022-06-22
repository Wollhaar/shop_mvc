<?php
declare(strict_types=1);

namespace ShopTest;

use PHPUnit\Framework\TestCase;
use Shop\Controller\DetailController;

class DetailControllerTest extends TestCase
{
    public function testCheck()
    {
        $controller = new DetailController();
        $controller->view();

        self::assertSame([
            'id' => 0,
            'name' => 'none',
            'size' => 'none',
            'category' => 'none',
            'price' => 0.0,
            'amount' => 0
        ], $controller->check());
    }
}