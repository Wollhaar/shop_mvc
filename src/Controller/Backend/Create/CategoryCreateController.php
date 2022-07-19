<?php
declare(strict_types=1);

namespace Shop\Controller\Backend\Create;

use Shop\Core\View;
use Shop\Model\Dto\CategoryDataTransferObject;
use Shop\Model\Repository\CategoryRepository;
use Shop\Model\Repository\ProductRepository;
use Shop\Model\Repository\UserRepository;

class CategoryCreateController implements \Shop\Controller\BasicController
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

        $this->renderer->addTemplateParameter('Users', 'title');
        $this->renderer->addTemplateParameter(false, 'create');
        $this->renderer->addTemplateParameter($category->name, 'subtitle');
        $this->renderer->addTemplateParameter($category, 'category');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function build(): CategoryDataTransferObject
    {
        $category = $_REQUEST['category'] ?? [];
        return $this->catRepository->addCategory($category);
    }
}