<?php declare(strict_types=1);

namespace Shop\Service;

use Shop\Controller\ErrorController;
use Shop\Controller\Backend\{BackendController, CreateController, ListController, LoginController, ProfileController, SaveController};
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
            CreateController::class,
            ListController::class,
            LoginController::class,
            ProfileController::class,
            SaveController::class,
        ];
    }
}