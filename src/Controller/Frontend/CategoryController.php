<?php declare(strict_types=1);

namespace Shop\Controller\Frontend;

use Shop\Controller\BasicController;
use Shop\Core\View;
use Shop\Model\Dto\CategoryDataTransferObject;
use Shop\Model\Repository\{CategoryRepository, ProductRepository};

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
        $this->activeCategory = $this->catRepository->findCategoryById($activeId);

        if ($this->activeCategory->id) {
            $products = $this->prodRepository->findProductsByCategoryId($this->activeCategory->id);
            foreach ($products as $key => $product) {
                $products[$key] = $product->name;
            }
            return $products;
        }

        return $this->catRepository->getAll();
    }
}