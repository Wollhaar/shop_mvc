<?php
declare(strict_types=1);

namespace ShopTest\Controller;

use Shop\Controller\BackendController;
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
        self::assertSame(
            [
                'Dashboard',
                [2,'test', 'Test', 'Tester', 0, 0, 0],
            ],
            [
                $results['title'],
                [
                    $results['user']->id,
                    $results['user']->username,
                    $results['user']->firstname,
                    $results['user']->lastname,
                    $results['user']->created,
                    $results['user']->updated,
                    $results['user']->birthday,
                    $results['user']->active,
                ]
            ]
        );
    }
}