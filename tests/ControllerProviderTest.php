<?php
declare(strict_types=1);

namespace ShopTest;

use PHPUnit\Framework\TestCase;
use Shop\Controller\{CategoryController, HomeController, ProductController};
use Shop\Service\ControllerProvider;

class ControllerProviderTest extends TestCase
{
    public function testGetList()
    {
        $provider = new ControllerProvider();
        self::assertSame([CategoryController::class, HomeController::class, ProductController::class], $provider->getList());
    }
}