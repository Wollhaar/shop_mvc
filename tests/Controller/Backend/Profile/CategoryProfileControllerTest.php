<?php
declare(strict_types=1);

namespace ShopTest\Controller\Backend\Profile;

use Shop\Controller\Backend\Profile\CategoryProfileController;
use Shop\Core\View;
use Shop\Model\EntityManager\CategoryEntityManager;
use Shop\Model\Mapper\CategoriesMapper;
use Shop\Model\Repository\CategoryRepository;

class CategoryProfileControllerTest extends \PHPUnit\Framework\TestCase
{

    public function testView()
    {
        require __DIR__ . '/../../../../bootstrap-doctrine.php';

        $_REQUEST['id'] = 4;

        $view = new View();
        $catMapper = new CategoriesMapper();

        $controller = new CategoryProfileController($view,
            new CategoryRepository($catMapper, $entityManager),
            new CategoryEntityManager($entityManager),
            $catMapper
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame(4, $results['category']->id);
        self::assertSame('T-Shirt', $results['category']->name);
        self::assertTrue($results['category']->active);
    }

    public function testCreationView()
    {
        require __DIR__ . '/../../../../bootstrap-doctrine.php';

        $_REQUEST['create'] = 1;
        $_REQUEST['id'] = '';

        $view = new View();
        $catMapper = new CategoriesMapper();

        $controller = new CategoryProfileController($view,
            new CategoryRepository($catMapper, $entityManager),
            new CategoryEntityManager($entityManager),
            $catMapper
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('Category', $results['title']);
        self::assertSame('Creation', $results['subtitle']);
        self::assertTrue($results['create']);
        self::assertSame(0, $results['category']->id);
        self::assertSame('All', $results['category']->name);
        self::assertFalse($results['category']->active);
    }

    public function testCreateView()
    {
        require __DIR__ . '/../../../../bootstrap-doctrine.php';

        $_REQUEST['action'] = 'create';
        $_POST['category'] = ['name' => 'testKategorieCREATE'];

        $view = new View();
        $catMapper = new CategoriesMapper();

        $controller = new CategoryProfileController($view,
            new CategoryRepository($catMapper, $entityManager),
            new CategoryEntityManager($entityManager),
            $catMapper
        );
        $controller->view();
        $results = $view->getParams();


        self::assertSame('Category', $results['title']);
        self::assertSame('testKategorieCREATE', $results['category']->name);
        self::assertTrue($results['category']->active);
    }
}