<?php
declare(strict_types=1);

namespace ShopTest;

use PHPUnit\Framework\TestCase;
use Shop\Controller\Frontend\{CategoryController, DetailController, HomeController};
use Shop\Controller\Backend\{BackendController, LoginController};
use Shop\Controller\Backend\Listing\{CategoryListController, ProductListController, UserListController};
use Shop\Controller\Backend\Profile\{CategoryProfileController, ProductProfileController, UserProfileController};
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
            CategoryListController::class,
            ProductListController::class,
            UserListController::class,
            LoginController::class,
            CategoryProfileController::class,
            ProductProfileController::class,
            UserProfileController::class,
        ], $provider->getBackendList());
    }
}