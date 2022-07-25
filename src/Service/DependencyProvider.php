<?php
declare(strict_types=1);

namespace Shop\Service;

class DependencyProvider
{
    public function provide(Container $container): void
    {
//        $container->set(UserRepository::class, new \Shop\Model\Repository\UserRepository(new \Shop\Model\Mapper\UsersMapper()));
//        $authenticator = new \Shop\Core\Authenticator($session, $userRepository);


//        $controllerName = class_search($page, $backend ?? '');
//        $controller = new $controllerName(
//            new \Shop\Core\View(),
//            new \Shop\Model\Repository\CategoryRepository(
//                new \Shop\Model\Mapper\CategoriesMapper()
//            ),
//            new \Shop\Model\Repository\ProductRepository(
//                new \Shop\Model\Mapper\ProductsMapper()
//            ),
//            $userRepository,
//            $authenticator
//        );
    }
}