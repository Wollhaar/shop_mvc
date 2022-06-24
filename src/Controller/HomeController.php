<?php declare(strict_types=1);

namespace Shop\Controller;

use Shop\Core\View;
use Shop\Model\Category;

class HomeController implements BasicController
{
    private const TPL = 'HomeView.tpl';

    private View $renderer;


    public function __construct(View $renderer)
    {
        $this->renderer = $renderer;
    }

    public function view():void
    {
        $categories = (new Category())->getAll();
        $this->renderer->addTemplateParameter('Shop', 'title');
        $this->renderer->addTemplateParameter($categories, 'categories');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }
}