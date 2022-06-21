<?php declare(strict_types=1);

namespace Shop\Service;

use Shop\Controller\{CategoryController, HomeController, ProductController};

class ControllerProvider
{
    public const HOME = 1;

    public function getList(): array
    {
        return [
            CategoryController::class,
            HomeController::class,
            ProductController::class,
        ];
    }
}