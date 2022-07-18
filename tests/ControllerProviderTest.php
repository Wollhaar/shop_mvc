<?php
declare(strict_types=1);

namespace ShopTest;

use PHPUnit\Framework\TestCase;
use Shop\Controller\{Backend\BackendController,
    Backend\CreateController,
    Backend\ListController,
    Backend\LoginController,
    Backend\ProfileController,
    Backend\SaveController,
    ErrorController,
    Frontend\CategoryController,
    Frontend\DetailController,
    Frontend\HomeController};
use Shop\Service\ControllerProvider;

class ControllerProviderTest extends TestCase
{
    public function testGetFrontendList()
    {
        $provider = new ControllerProvider();
        self::assertSame([
            CategoryController::class,
            DetailController::class,
            HomeController::class,
        ], $provider->getFrontendList());
    }
    public function testGetBackendList()
    {
        $provider = new ControllerProvider();
        self::assertSame([
            BackendController::class,
            CreateController::class,
            ListController::class,
            LoginController::class,
            ProfileController::class,
            SaveController::class,
        ], $provider->getBackendList());
    }
}