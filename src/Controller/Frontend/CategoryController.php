<?php declare(strict_types=1);

namespace Shop\Controller\Frontend;

use Shop\Controller\BasicController;
use Shop\Core\View;
use Shop\Model\Dto\CategoryDataTransferObject;
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};
use Shop\Model\Mapper\CategoriesMapper;

class CategoryController implements BasicController
{
    private const TPL = 'CategoryView.tpl';

    private CategoryDataTransferObject $activeCategory;

    private CategoryRepository $catRepository;

    private ProductRepository $prodRepository;

    private View $renderer;


    public function __construct(View $renderer, CategoryRepository $catRepository, ProductRepository $prodRepository, UserRepository $usrRepository, CategoriesMapper $catMapper)
    {
        $this->renderer = $renderer;
        $this->catRepository = $catRepository;
        $this->prodRepository = $prodRepository;
        $this->activeCategory = $catMapper->mapToDto([]);
    }

    public function view(): void
    {
        $build = $this->build();
        $activeCategory = false;

        if ($this->activeCategory->id !== 0) {
            $activeCategory = true;
        }

        $this->renderer->addTemplateParameter($this->activeCategory->name, 'title');
        $this->renderer->addTemplateParameter($activeCategory, 'activeCategory');
        $this->renderer->addTemplateParameter($build, 'build');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function build(): array
    {
        $request = $_REQUEST;
        $activeId = (int) ($request['id'] ?? 0);

        if ($activeId) {
            $this->activeCategory = $this->catRepository->findCategoryById($activeId);
            return $this->prodRepository->findProductsByCategoryId($this->activeCategory->id);
        }

        return $this->catRepository->getAll();
    }
}