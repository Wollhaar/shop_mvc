<?php
declare(strict_types=1);

namespace ShopTest\Controller\Backend;

use Shop\Controller\Backend\BackendController;
use Shop\Core\Authenticator;
use Shop\Core\View;
use Shop\Model\Mapper\CategoriesMapper;
use Shop\Model\Mapper\ProductsMapper;
use Shop\Model\Mapper\UsersMapper;
use Shop\Model\Repository\CategoryRepository;
use Shop\Model\Repository\ProductRepository;
use Shop\Model\Repository\UserRepository;
use Shop\Service\Session;

class BackendControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testView()
    {
        $usrRepository = new UserRepository(new UsersMapper());
        $session = new Session(true);
        $session->set(['auth' => true, $usrRepository->findUserById(2)], 'user');

        $view = new View();

        $controller = new BackendController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper()),
            $usrRepository,
            new Authenticator($session, $usrRepository)
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('Dashboard', $results['title']);
        self::assertSame(2, $results['user']->id);
        self::assertSame('test', $results['user']->username);
        self::assertSame('Chuck', $results['user']->firstname);
        self::assertSame('Tester', $results['user']->lastname);
        self::assertSame(1657664319, $results['user']->created);
        self::assertSame(863301600, $results['user']->birthday);
        self::assertTrue($results['user']->active);
    }
}