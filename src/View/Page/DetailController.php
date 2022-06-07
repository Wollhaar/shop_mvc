<?php declare(strict_types=1);

namespace View\Page;

use View\Engine\Response;

class DetailController
{
    private const page = 'detail';

    public function view():Response
    {
        return new Response(self::page);
    }
}