<?php
declare(strict_types=1);

namespace Shop\Controller\Backend\Profile;

use Shop\Core\View;
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};
use Shop\Model\Dto\CategoryDataTransferObject;

class CategoryProfileController implements \Shop\Controller\BasicController
{
    private const TPL = 'CategoryProfileView.tpl';
    private View $renderer;
    private CategoryRepository $catRepository;

    public function __construct(View $renderer, CategoryRepository $catRepository, ProductRepository $prodRepository, UserRepository $usrRepository)
    {
        $this->renderer = $renderer;
        $this->catRepository = $catRepository;
    }

    public function view(): void
    {
        $category = $this->build();
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

    private function build(): CategoryDataTransferObject
    {
        $id = $_REQUEST['id'] ?? '';
        return $this->catRepository->findCategoryById((int)$id);
    }
}