<?php declare(strict_types=1);

namespace Shop\Controller;

use Shop\Core\View;
use Shop\Model\Repository\{CategoryRepository, ProductRepository};

class HomeController implements BasicController
{
    private const TPL = 'HomeView.tpl';

    private View $renderer;

    private CategoryRepository $catRepository;


    public function __construct(View $renderer, CategoryRepository $catRepository)
    {
        $this->renderer = $renderer;
        $this->catRepository = $catRepository;
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