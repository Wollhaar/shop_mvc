<?php
declare(strict_types=1);

namespace ShopTest;

use PHPUnit\Framework\TestCase;
use Shop\Controller\HomeController;

class HomeControllerTest extends TestCase
{
    public function testCheck()
    {
        $home = new HomeController();
        $home->view();

        self::assertSame([
            'title' => 'Shop',
            'output' => [
                1 => 'T-Shirt',
                2 => 'Pullover',
                3 => 'Hosen',
                4 => 'Sportswear'
            ]
        ], $home->check());
    }
}