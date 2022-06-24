<?php
declare(strict_types=1);

namespace ShopTest;

use PHPUnit\Framework\TestCase;
use Shop\Controller\ErrorController;
use Shop\Model\Error;
use Shop\Service\MainService;

class MainServiceTest extends TestCase
{
    public function testHomeView()
    {
        $service = new MainService();
        $service->action();

        self::assertSame([
            'title' => 'Shop',
            'output' => [
                1 => 'T-Shirt',
                2 => 'Pullover',
                3 => 'Hosen',
                4 => 'Sportswear'
            ]
        ], $service->getView()->getParams());
    }

    public function testCategoryView()
    {
        $_REQUEST['page'] = 'category';
        $service = new MainService();
        $service->action();

        self::assertSame([
            'title' => 'All',
            'activeCategory' => false,
            'output' => [
                1 => 'T-Shirt',
                2 => 'Pullover',
                3 => 'Hosen',
                4 => 'Sportswear'
            ]
        ], $service->getView()->getParams());
    }

    public function testProductCategoryView()
    {
        $_REQUEST['page'] = 'category';
        $_REQUEST['id'] = 4;
        $service = new MainService();
        $service->action();

        self::assertSame([
            'title' => 'Sportswear',
            'activeCategory' => true,
            'output' => [
                2 => 'HSV - Home-Jersey',
            ]
        ], $service->getView()->getParams());
    }

    public function testDetailView()
    {
        $_REQUEST['page'] = 'detail';
        $_REQUEST['id'] = 2;

        $service = new MainService();
        $service->action();

        self::assertSame([
            'id' => 2,
            'name' => 'HSV - Home-Jersey',
            'size' => 'M',
            'category' => 'Sportswear',
            'price' => 80.9,
            'amount' => 200
        ], $service->getView()->getParams());
    }

    public function testErrorView()
    {
//        $error = new Error(404);
//        $error->setIssue('Test');
//        ErrorController::setError($error);
        $_REQUEST['page'] = 'Test';

        $service = new MainService();
        $service->action();

        self::assertSame([
            'number' => 404,
            'message' => 'Page not found',
            'issue' => 'Test'
        ], $service->getView()->getParams());
    }
}