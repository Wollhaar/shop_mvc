<?php
declare(strict_types=1);

namespace ShopTest\Service;

use Shop\Controller\Frontend\HomeController;
use Shop\Service\Container;
use Shop\Service\DependencyProvider;

class DependencyProviderTest extends \PHPUnit\Framework\TestCase
{
    public function testProvide()
    {
        $container = new Container();
        $provider = new DependencyProvider();
        $provider->provide($container);

        self::assertSame(HomeController::class, $container->get(HomeController::class)::class );
    }
}