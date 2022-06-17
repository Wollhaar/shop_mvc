<?php declare(strict_types=1);

namespace Shop\Core;

use Smarty;

class View
{
    public Smarty $renderer;

    public function __construct()
    {
        $this->renderer = new Smarty();
    }

    public function addTemplateParameter(string $param, string $name):void
    {
        $this->renderer->assign($name, $param);
    }

    public function display(string $template, string $value = ''):void
    {
        $this->renderer->display($template, $value);
    }
}