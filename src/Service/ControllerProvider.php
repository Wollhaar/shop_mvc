<?php declare(strict_types=1);

namespace Shop\Service;

use Shop\Controller\ErrorController;
use Shop\Controller\Backend\{BackendController, LoginController, PasswordController};
use Shop\Controller\Backend\Listing\{CategoryListController, ProductListController, UserListController};
use Shop\Controller\Backend\Profile\{CategoryProfileController, ProductProfileController, UserProfileController};
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
            CategoryListController::class,
            ProductListController::class,
            UserListController::class,
            LoginController::class,
            CategoryProfileController::class,
            ProductProfileController::class,
            UserProfileController::class,
            PasswordController::class,
        ];
    }
}