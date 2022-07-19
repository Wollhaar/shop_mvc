<?php
declare(strict_types=1);

namespace Shop\Controller\Backend\Delete;

use Shop\Core\View;
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};

class CategoryDeleteController implements \Shop\Controller\BasicController
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
        $categories = $this->build();

        $this->renderer->addTemplateParameter('Category', 'title');
        $this->renderer->addTemplateParameter($categories, 'categories');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function build(): array
    {
        $id = (int) ($_REQUEST['id'] ?? 0);
        $this->catRepository->deleteCategoryById($id);
        return $this->catRepository->getAll();
    }
}