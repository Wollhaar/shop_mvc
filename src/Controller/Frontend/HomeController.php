<?php declare(strict_types=1);

namespace Shop\Controller\Frontend;

use Shop\Controller\BasicController;
use Shop\Core\View;
use Shop\Model\Repository\{CategoryRepository};

class HomeController implements BasicController
{
    private const TPL = 'HomeView.tpl';

    public function __construct(private View $renderer, private CategoryRepository $catRepository)
    {
    }

    public function view():void
    {
        $categories = $this->catRepository->getAll();

        $this->renderer->addTemplateParameter('Shop', 'title');
        $this->renderer->addTemplateParameter($categories, 'categories');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }
}