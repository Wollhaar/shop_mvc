<?php
declare(strict_types=1);

namespace ShopTest\Controller\Backend;

use Shop\Controller\Backend\PasswordController;
use Shop\Core\PasswordGenerator;
use Shop\Core\View;
use Shop\Model\EntityManager\UserEntityManager;
use Shop\Model\Mapper\EmailsMapper;
use Shop\Model\Mapper\UsersMapper;
use Shop\Model\Repository\UserRepository;
use Shop\Service\Container;
use Shop\Service\Mailer;
use Shop\Service\Session;
use Shop\Service\SymfonyMailerManager;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mailer\Transport\Transports;
use Symfony\Component\Mime\RawMessage;

class PasswordControllerTest extends \PHPUnit\Framework\TestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();
        $_GET = [];
    }

    public function testIndex()
    {
        $view = new View();
        $usrMapper = new UsersMapper();

        $controller = new PasswordController($view,
            new UserRepository($usrMapper, Container::$entityManager), // TODO: resolve undefined EntityManager
            new UserEntityManager(Container::$entityManager),
            new EmailsMapper(),
            new PasswordGenerator(),
            new Session(true),
            new SymfonyMailerManager(new Mailer(
                new Transports([
                    'main' => new EsmtpTransport('localhost', 1025)
                ]),
                new RawMessage()
            ))
        );

        $controller->view();
        $results = $view->getParams();

        self::assertNull($results['phase']);
        self::assertNull($results['result']);
    }

    public function testForgotten()
    {
        $_GET['action'] = 'forgotten';

        $view = new View();
        $usrMapper = new UsersMapper();

        $controller = new PasswordController($view,
            new UserRepository($usrMapper, Container::$entityManager),
            new UserEntityManager(Container::$entityManager),
            new EmailsMapper(),
            new PasswordGenerator(),
            new Session(true),
            new SymfonyMailerManager(
                new Mailer(new Transports(['main' => new EsmtpTransport('localhost', 1025)]), new RawMessage())
            )
        );

        $controller->view();
        $results = $view->getParams();

        self::assertSame('forgotten', $results['phase']);
        self::assertNull($results['result']);
    }

    public function testVerifyUser()
    {
        $_GET['action'] = 'verify';
        $_POST['email'] = 'test.mail@local.com';

        $view = new View();
        $usrMapper = new UsersMapper();

        $controller = new PasswordController($view,
            new UserRepository($usrMapper, Container::$entityManager),
            new UserEntityManager(Container::$entityManager),
            new EmailsMapper(),
            new PasswordGenerator(),
            new Session(true),
            new SymfonyMailerManager(
                new Mailer(new Transports(['main' => new EsmtpTransport('localhost', 1025)]), new RawMessage())
            )
        );

        $controller->view();
        $results = $view->getParams();

        self::assertSame('verifyUser', $results['phase']);
        self::assertTrue($results['result']);
    }

    public function testNewPassword()
    {
        $_GET['action'] = 'newPassword';

        $view = new View();
        $usrMapper = new UsersMapper();

        $controller = new PasswordController($view,
            new UserRepository($usrMapper, Container::$entityManager),
            new UserEntityManager(Container::$entityManager),
            new EmailsMapper(),
            new PasswordGenerator(),
            new Session(true),
            new SymfonyMailerManager(
                new Mailer(new Transports(['main' => new EsmtpTransport('localhost', 1025)]), new RawMessage())
            )
        );

        $controller->view();
        $results = $view->getParams();

        self::assertSame('newPassword', $results['phase']);
        self::assertNull($results['result']);
    }

    public function testPasswordSet()
    {
        $_GET['action'] = 'passwordSet';
        $_POST['password'] = 'maxi123';

        $view = new View();
        $usrMapper = new UsersMapper();

        $controller = new PasswordController($view,
            new UserRepository($usrMapper, Container::$entityManager),
            new UserEntityManager(Container::$entityManager),
            new EmailsMapper(),
            new PasswordGenerator(),
            new Session(true),
            new SymfonyMailerManager(
                new Mailer(new Transports(['main' => new EsmtpTransport('localhost', 1025)]), new RawMessage())
            )
        );

        $controller->view();
        $results = $view->getParams();

        self::assertSame('passwordSet', $results['phase']);
        self::assertTrue($results['result']);
    }
}