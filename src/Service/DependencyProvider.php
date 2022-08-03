<?php
declare(strict_types=1);

namespace Shop\Service;

use Shop\Controller\Backend\BackendController;
use Shop\Controller\Backend\Listing\CategoryListController;
use Shop\Controller\Backend\Listing\ProductListController;
use Shop\Controller\Backend\Listing\UserListController;
use Shop\Controller\Backend\LoginController;
use Shop\Controller\Backend\Profile\CategoryProfileController;
use Shop\Controller\Backend\Profile\ProductProfileController;
use Shop\Controller\Backend\Profile\UserProfileController;
use Shop\Controller\ErrorController;
use Shop\Controller\Frontend\CategoryController;
use Shop\Controller\Frontend\DetailController;
use Shop\Controller\Frontend\HomeController;
use Shop\Core\Authenticator;
use Shop\Core\View;
use Shop\Model\Mapper\CategoriesMapper;
use Shop\Model\Mapper\ProductsMapper;
use Shop\Model\Mapper\UsersMapper;
use Shop\Model\Repository\CategoryRepository;
use Shop\Model\Repository\ProductRepository;
use Shop\Model\Repository\UserRepository;

class DependencyProvider
{
    public function provide(Container $container): void
    {
        $container->set(SQLConnector::class, new SQLConnector());
        $container->set(Session::class, new Session());
        $container->set(View::class, new View());
        $container->set(CategoriesMapper::class, new CategoriesMapper());
        $container->set(ProductsMapper::class, new ProductsMapper());
        $container->set(UsersMapper::class, new UsersMapper());
        $container->set(CategoryRepository::class, new CategoryRepository($container->get(CategoriesMapper::class), $container->get(SQLConnector::class)));
        $container->set(ProductRepository::class, new ProductRepository($container->get(ProductsMapper::class), $container->get(SQLConnector::class)));
        $container->set(UserRepository::class, new UserRepository($container->get(UsersMapper::class), $container->get(SQLConnector::class)));
        $container->set(CategoryRepository::class, new CategoryRepository($container->get(CategoriesMapper::class), $container->get(SQLConnector::class)));
        $container->set(ProductRepository::class, new ProductRepository($container->get(ProductsMapper::class), $container->get(SQLConnector::class)));
        $container->set(UserRepository::class, new UserRepository($container->get(UsersMapper::class), $container->get(SQLConnector::class)));
        $container->set(Authenticator::class, new Authenticator($container->get(Session::class), $container->get(UserRepository::class)));
        $container->set(ErrorController::class, new ErrorController($container->get(View::class)));
        $container->set(HomeController::class, new HomeController($container->get(View::class), $container->get(CategoryRepository::class)));
        $container->set(CategoryController::class, new CategoryController($container->get(View::class), $container->get(CategoryRepository::class), $container->get(ProductRepository::class)));
        $container->set(DetailController::class, new DetailController($container->get(View::class), $container->get(ProductRepository::class)));
        $container->set(BackendController::class, new BackendController($container->get(View::class), $container->get(Authenticator::class)));
        $container->set(LoginController::class, new LoginController($container->get(View::class), $container->get(UserRepository::class), $container->get(Authenticator::class)));
        $container->set(CategoryListController::class, new CategoryListController($container->get(View::class), $container->get(CategoryRepository::class)));
        $container->set(ProductListController::class, new ProductListController($container->get(View::class), $container->get(ProductRepository::class)));
        $container->set(UserListController::class, new UserListController($container->get(View::class), $container->get(UserRepository::class)));
        $container->set(CategoryProfileController::class, new CategoryProfileController($container->get(View::class), $container->get(CategoryRepository::class), $container->get(CategoriesMapper::class)));
        $container->set(ProductProfileController::class, new ProductProfileController($container->get(View::class), $container->get(CategoryRepository::class), $container->get(ProductRepository::class), $container->get(ProductsMapper::class)));
        $container->set(UserProfileController::class, new UserProfileController($container->get(View::class), $container->get(UserRepository::class), $container->get(UsersMapper::class)));
    }
}