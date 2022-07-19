<?php
declare(strict_types=1);

namespace Shop\Controller\Backend\Listing;

use Shop\Core\View;
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};

class CategoryListController implements \Shop\Controller\BasicController
{
    private const TPL = 'CategoryListView.tpl';
    private View $renderer;
    private CategoryRepository $catRepository;

    public function __construct(View $renderer, CategoryRepository $catRepository, ProductRepository $prodRepository, UserRepository $usrRepository)
    {
        $this->renderer = $renderer;
        $this->catRepository = $catRepository;
    }

    public function view(): void
    {
        $categories = $this->catRepository->getAll();

        $this->renderer->addTemplateParameter('Categories', 'title');
        $this->renderer->addTemplateParameter($categories, 'categories');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }
}