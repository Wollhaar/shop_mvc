<?php declare(strict_types=1);

namespace Shop\Controller;

use Shop\Core\View;
use Shop\Model\Repository\{CategoryRepository, ProductRepository};
use Shop\Model\Dto\CategoryDataTransferObject;

class CategoryController implements BasicController
{
    private const TPL = 'CategoryView.tpl';

    private CategoryDataTransferObject $activeCategory;

    private CategoryRepository $catRepository;

    private ProductRepository $prodRepository;

    private View $renderer;


    public function __construct(View $renderer, CategoryRepository $catRepository, ProductRepository $prodRepository)
    {
        $this->renderer = $renderer;
        $this->catRepository = $catRepository;
        $this->prodRepository = $prodRepository;
    }

    public function view(): void
    {
        $build = $this->build();
        $activeCategory = false;

        if ($this->activeCategory->getId() !== 0) {
            $activeCategory = true;
        }
        $this->renderer->addTemplateParameter($this->activeCategory->getName(), 'title');
        $this->renderer->addTemplateParameter($activeCategory, 'activeCategory');

        if ($this->activeCategory->getId()) {
            $this->renderer->addTemplateParameter($build, 'build');
        }
        else {
        $this->renderer->addTemplateParameterObjectArray($build, 'build', ['id', 'name']);
        }
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function build(): array
    {
        $request = $_REQUEST;
        $activeId = (int) ($request['id'] ?? 0);
        $this->activeCategory = $this->catRepository->findCategoryById($activeId);

        if ($this->activeCategory->getId()) {
            $products = $this->prodRepository->findProductsByCategoryId($this->activeCategory->getId());
            foreach ($products as $key => $product) {
                $products[$key] = $product->getName();
            }
            return $products;
        }
        return $this->catRepository->getAll();
    }
}