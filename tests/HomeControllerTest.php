<?php
declare(strict_types=1);

namespace ShopTest;

use PHPUnit\Framework\TestCase;
use Shop\Controller\HomeController;

class HomeControllerTest extends TestCase
{
    public function testView()
    {
        $home = new HomeController();
        self::assertNull($home->view());
    }
}