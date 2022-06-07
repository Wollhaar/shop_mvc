<?php declare(strict_types=1);

namespace View\Page;

use View\Engine\Response;

class HomeController
{
    private const page = 'home';

    public function view():Response
    {
        return new Response(self::page);
    }
}