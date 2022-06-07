<?php declare(strict_types=1);

namespace View\Page;

use View\Engine\Response;

class CategoryController
{
    private const page = 'category';

    public function view():Response
    {
        return new Response(self::page);
    }
}