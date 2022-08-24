<?php
declare(strict_types=1);

namespace Shop\Controller\Backend\Listing;

use Shop\Core\View;
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};
use Shop\Model\EntityManager\CategoryEntityManager;

class CategoryListController implements \Shop\Controller\BasicController
{
    private const TPL = 'CategoryListView.tpl';

    public function __construct(private View $renderer, private CategoryRepository $catRepository, private CategoryEntityManager $catEntManager)
    {
    }

    public function view(): void
    {
        $action = $_GET['action'] ?? '';
        if ($action === 'delete') {
            $this->delete();
        }
        $categories = $this->catRepository->getAll();

        $this->renderer->addTemplateParameter('Categories', 'title');
        $this->renderer->addTemplateParameter($categories, 'categories');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function delete(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $this->catEntManager->deleteCategoryById($id);
    }
}