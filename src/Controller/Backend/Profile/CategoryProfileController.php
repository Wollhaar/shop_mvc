<?php
declare(strict_types=1);

namespace Shop\Controller\Backend\Profile;

use Shop\Core\View;
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};
use Shop\Model\Dto\CategoryDataTransferObject;
use Shop\Model\EntityManager\CategoryEntityManager;
use Shop\Model\Mapper\CategoriesMapper;

class CategoryProfileController implements \Shop\Controller\BasicController
{
    private const TPL = 'CategoryProfileView.tpl';

    public function __construct(
        private View $renderer,
        private CategoryRepository $catRepository,
        private CategoryEntityManager $catEntManager,
        private CategoriesMapper $catMapper
    )
    {}

    public function view(): void
    {
        $action = $_GET['action'] ?? 'index';
        $category = $this->$action();

        if (is_object($category)) {
            $name = $category->name;
        }
        if ((int)($_REQUEST['create'] ?? 0) === 1) {
            $create = true;
            $name = 'Creation';
        }
        $this->renderer->addTemplateParameter('Category', 'title');
        $this->renderer->addTemplateParameter($name ?? null, 'subtitle');
        $this->renderer->addTemplateParameter($create ?? false, 'create');
        $this->renderer->addTemplateParameter($category, 'category');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function create(): CategoryDataTransferObject
    {
        $category = $_POST['category'] ?? [];
        $category = $this->catMapper->mapToDto($category);
        $categoryId = $this->catEntManager->addCategory($category);
        return $this->catRepository->findCategoryById($categoryId);
    }

    private function index(): CategoryDataTransferObject|null
    {
        $id = $_REQUEST['id'] ?? '';
        return $this->catRepository->findCategoryById((int)$id);
    }
}