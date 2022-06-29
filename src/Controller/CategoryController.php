<?php declare(strict_types=1);

namespace Shop\Controller;

use Shop\Core\View;
use Shop\Model\Category;
use Shop\Model\Repository\{CategoryRepository, ProductRepository};

class CategoryController implements BasicController
{
    private const TPL = 'CategoryView.tpl';

    private Category $activeCategory;

    private CategoryRepository $catRepository;

    private ProductRepository $prodRepository;

    private View $renderer;


    public function __construct(View $renderer, CategoryRepository $catRepository, ProductRepository $prodRepository)
    {
        $request = $_REQUEST;

        $activeId = (int) ($request['id'] ?? 0);
        $this->activeCategory = new Category($activeId);
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
        $this->renderer->addTemplateParameter($build, 'build');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function build(): array
    {
        if ($this->activeCategory->getId()) {
            $foundCategory = $this->catRepository->findCategoryById($this->activeCategory->getId());

            if (!empty($foundCategory)) {
                $this->activeCategory->setName($foundCategory['name'] ?? 'none');
                $products = $this->prodRepository->findProductsByCategoryId($this->activeCategory->getId());
                foreach ($products as $key => $product) {
                    $products[$key] = $product['name'];
                }
                return $products;
            }
        }
        return $this->catRepository->getAll();
    }
}