<?php declare(strict_types=1);

namespace Shop\Service;

use Shop\Controller\ErrorController;
use Shop\Controller\Backend\{BackendController, LoginController};
use Shop\Controller\Backend\Create\{CategoryCreateController, ProductCreateController, UserCreateController};
use Shop\Controller\Backend\Delete\{CategoryDeleteController, ProductDeleteController, UserDeleteController};
use Shop\Controller\Backend\Listing\{CategoryListController, ProductListController, UserListController};
use Shop\Controller\Backend\Profile\{CategoryProfileController, ProductProfileController, UserProfileController};
use Shop\Controller\Backend\Save\{ProductSaveController, UserSaveController};
use Shop\Controller\Frontend\{CategoryController, DetailController, HomeController};

class ControllerProvider
{
    public const ERROR = ErrorController::class;

    public function getFrontendList(): array
    {
        return [
            CategoryController::class,
            DetailController::class,
            HomeController::class,
        ];
    }

    public function getBackendList(): array
    {
        return [
            BackendController::class,
            CategoryCreateController::class,
            ProductCreateController::class,
            UserCreateController::class,
            CategoryDeleteController::class,
            ProductDeleteController::class,
            UserDeleteController::class,
            CategoryListController::class,
            ProductListController::class,
            UserListController::class,
            LoginController::class,
            CategoryProfileController::class,
            ProductProfileController::class,
            UserProfileController::class,
            ProductSaveController::class,
            UserSaveController::class,
        ];
    }
}