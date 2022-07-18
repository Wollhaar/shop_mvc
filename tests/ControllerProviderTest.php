<?php
declare(strict_types=1);

namespace ShopTest;

use PHPUnit\Framework\TestCase;
use Shop\Controller\{BackendController,
    CategoryController,
    CreateController,
    ErrorController,
    HomeController,
    DetailController,
    ListController,
    LoginController,
    ProfileController,
    SaveController};
use Shop\Service\ControllerProvider;

class ControllerProviderTest extends TestCase
{
    public function testGetFrontendList()
    {
        $provider = new ControllerProvider();
        self::assertSame([
            ErrorController::class,
            CategoryController::class,
            DetailController::class,
            HomeController::class,
        ], $provider->getFrontendList());
    }
    public function testGetBackendList()
    {
        $provider = new ControllerProvider();
        self::assertSame([
            ErrorController::class,
            BackendController::class,
            CreateController::class,
            ListController::class,
            LoginController::class,
            ProfileController::class,
            SaveController::class,
        ], $provider->getBackendList());
    }
}