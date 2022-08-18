<?php
declare(strict_types=1);

namespace ShopTest\Service;

use Doctrine\ORM\EntityManager;
use Shop\Controller\Frontend\HomeController;
use Shop\Service\Container;
use Shop\Service\DependencyProvider;

class DependencyProviderTest extends \PHPUnit\Framework\TestCase
{
    public function testProvide()
    {
        require __DIR__ . '/../../bootstrap-doctrine.php';

        $_SERVER['PHP_TEST'] = 1;

        $container = new Container();
        $container->set(EntityManager::class, $entityManager);

        $provider = new DependencyProvider();
        $provider->provide($container);

        self::assertSame(HomeController::class, $container->get(HomeController::class)::class );
    }
}