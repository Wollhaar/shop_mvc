<?php
declare(strict_types=1);

namespace Shop\Controller\Backend\Profile;

use Shop\Core\View;
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};
use Shop\Model\Dto\CategoryDataTransferObject;
use Shop\Model\Mapper\CategoriesMapper;

class CategoryProfileController implements \Shop\Controller\BasicController
{
    private const TPL = 'CategoryProfileView.tpl';
    private View $renderer;
    private CategoryRepository $catRepository;
    private CategoriesMapper $catMapper;

    public function __construct(View $renderer, CategoryRepository $catRepository, CategoriesMapper $catMapper)
    {
        $this->renderer = $renderer;
        $this->catRepository = $catRepository;
        $this->catMapper = $catMapper;
    }

    public function view(): void
    {
        $category = $this->action();
        $name = $category->name;

        if ((int)($_REQUEST['create'] ?? 0) === 1) {
            $create = true;
            $name = 'Creation';
        }
        $this->renderer->addTemplateParameter('Category', 'title');
        $this->renderer->addTemplateParameter($name, 'subtitle');
        $this->renderer->addTemplateParameter($create ?? false, 'create');
        $this->renderer->addTemplateParameter($category, 'category');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function action(): CategoryDataTransferObject
    {
        $do = $_REQUEST['action'] ?? '';
        switch ($do) {
            case 'create':
                $category = $_POST['category'] ?? [];
                $category = $this->catMapper->mapToDto($category);
                return $this->catRepository->addCategory($category);

            default:
                $id = $_REQUEST['id'] ?? '';
                return $this->catRepository->findCategoryById((int)$id);
        }
    }
}