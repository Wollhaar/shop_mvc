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
        $_GET['id'] = 4;

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
        $_GET['create'] = 1;

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
        self::assertNull($results['category']);
    }

    public function testCreateView()
    {
        $_GET['action'] = 'create';
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

    protected function setUp(): void
    {
        parent::setUp();
        require __DIR__ . '/../../../../bootstrap-doctrine.php';
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $_GET = [];
    }
}