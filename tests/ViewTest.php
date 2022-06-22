<?php
declare(strict_types=1);

namespace ShopTest;

use PHPUnit\Framework\TestCase;
use Shop\Core\View;

class ViewTest extends TestCase
{
    public function testGetParams()
    {
        $view = new View();
        self::assertSame([], $view->getParams());
    }
}