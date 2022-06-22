<?php declare(strict_types=1);

namespace Shop\Core;

use Smarty;

class View
{
    private Smarty $renderer;

    private array $params = [];


    public function __construct()
    {
        $this->renderer = new Smarty();
    }

    public function addTemplateParameter(mixed $param, string $name):void
    {
        $this->params[$name] = $param;
    }

    public function display(string $template): void
    {
        $this->renderer->assign($this->params);
        $this->renderer->display($template);
    }

    public function getParams(): array
    {
        return $this->params;
    }
}