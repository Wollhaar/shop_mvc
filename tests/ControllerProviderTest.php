<?php
declare(strict_types=1);

namespace ShopTest;

use PHPUnit\Framework\TestCase;
use Shop\Controller\{CategoryController, ErrorController, HomeController, DetailController};
use Shop\Service\ControllerProvider;

class ControllerProviderTest extends TestCase
{
    public function testGetList()
    {
        $provider = new ControllerProvider();
        self::assertSame([CategoryController::class, DetailController::class, ErrorController::class, HomeController::class], $provider->getList());
    }
}