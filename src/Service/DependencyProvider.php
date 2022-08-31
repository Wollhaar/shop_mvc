<?php
declare(strict_types=1);

namespace Shop\Service;

use Doctrine\ORM\EntityManager;
use Shop\Controller\Backend\BackendController;
use Shop\Controller\Backend\Listing\{CategoryListController, ProductListController, UserListController};
use Shop\Controller\Backend\LoginController;
use Shop\Controller\Backend\Profile\{CategoryProfileController, ProductProfileController, UserProfileController};
use Shop\Controller\Backend\PasswordController;
use Shop\Controller\ErrorController;
use Shop\Controller\Frontend\{CategoryController, DetailController, HomeController};
use Shop\Core\Authenticator;
use Shop\Core\PasswordGenerator;
use Shop\Core\View;
use Shop\Model\EntityManager\{CategoryEntityManager, ProductEntityManager, UserEntityManager};
use Shop\Model\Mapper\{CategoriesMapper, EmailsMapper, ProductsMapper, UsersMapper};
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mailer\Transport\Transports;
use Symfony\Component\Mime\RawMessage;

class DependencyProvider
{
    public function provide(Container $container): void
    {
        $container->set(Session::class, new Session((bool)($_SERVER['PHP_TEST'] ?? 0)));
        $container->set(View::class, new View());
        $container->set(CategoriesMapper::class, new CategoriesMapper());
        $container->set(EmailsMapper::class, new EmailsMapper());
        $container->set(ProductsMapper::class, new ProductsMapper());
        $container->set(UsersMapper::class, new UsersMapper());
        $container->set(PasswordGenerator::class, new PasswordGenerator());
        $container->set(EsmtpTransport::class, new EsmtpTransport('localhost', 1025));
        $container->set(Transports::class, new Transports(['main' => $container->get(EsmtpTransport::class)]));
        $container->set(RawMessage::class, new RawMessage());
        $container->set(Mailer::class, new Mailer($container->get(Transports::class), $container->get(RawMessage::class)));
        $container->set(SymfonyMailerManager::class, new \Symfony\Component\Mailer\Mailer($container->get(Mailer::class)));
        $container->set(CategoryRepository::class, new CategoryRepository($container->get(CategoriesMapper::class), $container->get(EntityManager::class)));
        $container->set(ProductRepository::class, new ProductRepository($container->get(ProductsMapper::class), $container->get(EntityManager::class)));
        $container->set(UserRepository::class, new UserRepository($container->get(UsersMapper::class), $container->get(EntityManager::class)));
        $container->set(CategoryEntityManager::class, new CategoryEntityManager($container->get(EntityManager::class)));
        $container->set(ProductEntityManager::class, new ProductEntityManager($container->get(EntityManager::class)));
        $container->set(UserEntityManager::class, new UserEntityManager($container->get(EntityManager::class)));
        $container->set(Authenticator::class, new Authenticator($container->get(Session::class), $container->get(UserRepository::class)));
        $container->set(ErrorController::class, new ErrorController($container->get(View::class)));
        $container->set(HomeController::class, new HomeController($container->get(View::class), $container->get(CategoryRepository::class)));
        $container->set(CategoryController::class, new CategoryController($container->get(View::class), $container->get(CategoryRepository::class), $container->get(ProductRepository::class)));
        $container->set(DetailController::class, new DetailController($container->get(View::class), $container->get(ProductRepository::class)));
        $container->set(BackendController::class, new BackendController($container->get(View::class), $container->get(Authenticator::class)));
        $container->set(LoginController::class, new LoginController($container->get(View::class), $container->get(Authenticator::class)));
        $container->set(CategoryListController::class, new CategoryListController($container->get(View::class), $container->get(CategoryRepository::class), $container->get(CategoryEntityManager::class)));
        $container->set(ProductListController::class, new ProductListController($container->get(View::class), $container->get(ProductRepository::class), $container->get(ProductEntityManager::class)));
        $container->set(UserListController::class, new UserListController($container->get(View::class), $container->get(UserRepository::class), $container->get(UserEntityManager::class)));
        $container->set(CategoryProfileController::class, new CategoryProfileController($container->get(View::class), $container->get(CategoryRepository::class), $container->get(CategoryEntityManager::class), $container->get(CategoriesMapper::class)));
        $container->set(ProductProfileController::class, new ProductProfileController($container->get(View::class), $container->get(CategoryRepository::class), $container->get(ProductRepository::class), $container->get(ProductEntityManager::class), $container->get(ProductsMapper::class)));
        $container->set(UserProfileController::class, new UserProfileController($container->get(View::class), $container->get(UserRepository::class), $container->get(UserEntityManager::class), $container->get(UsersMapper::class), $container->get(PasswordGenerator::class)));
        $container->set(PasswordController::class, new PasswordController($container->get(View::class), $container->get(UserRepository::class), $container->get(UserEntityManager::class), $container->get(EmailsMapper::class), $container->get(PasswordGenerator::class), $container->get(Session::class), $container->get(SymfonyMailerManager::class)));
    }
}