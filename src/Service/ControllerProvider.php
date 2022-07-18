<?php declare(strict_types=1);

namespace Shop\Service;

use Shop\Controller\{BackendController,
    CategoryController,
    CreateController,
    ErrorController,
    DetailController,
    HomeController,
    ListController,
    LoginController,
    ProfileController,
    SaveController};

class ControllerProvider
{
    public const ERROR = 0;

    public function getFrontendList(): array
    {
        return [
            ErrorController::class,
            CategoryController::class,
            DetailController::class,
            HomeController::class,
        ];
    }

    public function getBackendList(): array
    {
        return [
            ErrorController::class,
            BackendController::class,
            CreateController::class,
            ListController::class,
            LoginController::class,
            ProfileController::class,
            SaveController::class,
        ];
    }
}