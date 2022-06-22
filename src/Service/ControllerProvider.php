<?php declare(strict_types=1);

namespace Shop\Service;

use Shop\Controller\{CategoryController, ErrorController, DetailController, HomeController};

class ControllerProvider
{
    public const ERROR = 2;
    public const HOME = 3;

    public function getList(): array
    {
        return [
            CategoryController::class,
            DetailController::class,
            ErrorController::class,
            HomeController::class,
        ];
    }
}