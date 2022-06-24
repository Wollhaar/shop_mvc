<?php
declare(strict_types=1);

namespace Shop\Controller;

use Shop\Core\View;
use Shop\Model\Error;

class ErrorController implements BasicController
{
    private const TPL = 'NotFoundView.tpl';

    public static Error $error;

    private View $renderer;


    public function __construct(View $renderer)
    {
        $this->renderer = $renderer;
    }

    public function view(): void
    {
        $this->renderer->addTemplateParameter(self::$error->getNumber(), 'number');
        $this->renderer->addTemplateParameter(self::$error->getMessage(), 'message');
        $this->renderer->addTemplateParameter(self::$error->getIssue(), 'issue');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    public static function setError(Error $error): void
    {
        self::$error = $error;
    }
}