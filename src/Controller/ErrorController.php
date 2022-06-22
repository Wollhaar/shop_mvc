<?php
declare(strict_types=1);

namespace Shop\Controller;

use Shop\Core\View;
use Shop\Model\Error;

class ErrorController implements BasicController
{
    private const TPL = 'NotFoundView.tpl';

    public static Error $error;


    public function view(): void
    {
        $renderer = new View();


        $renderer->addTemplateParameterInteger(self::$error->getNumber(), 'number');
        $renderer->addTemplateParameter(self::$error->getMessage(), 'message');
        $renderer->addTemplateParameter(self::$error->getIssue(), 'issue');
        $renderer->display(self::TPL);
    }

    public static function setError(Error $error): void
    {
        self::$error = $error;
    }
}