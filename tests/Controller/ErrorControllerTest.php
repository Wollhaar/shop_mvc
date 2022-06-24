<?php
declare(strict_types=1);

namespace ShopTest\Controller;

use PHPUnit\Framework\TestCase;
use Shop\Controller\ErrorController;
use Shop\Core\View;
use Shop\Model\Error;

class ErrorControllerTest extends TestCase
{
    public function testCheck()
    {
        $error = new Error(404);
        $error->setIssue('Test');
        ErrorController::setError($error);

        $view = new View();
        $controller = new ErrorController($view);
        $controller->view();

        self::assertSame([
            'number' => 404,
            'message' => 'Page not found',
            'issue' => 'Test'
        ], $view->getParams());
    }
}