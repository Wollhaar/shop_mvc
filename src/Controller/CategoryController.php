<?php declare(strict_types=1);

namespace Shop\Controller;

use Shop\Core\View;
use Shop\Model\{Category, Product};

class CategoryController implements BasicController
{
    private const TPL = 'CategoryView.tpl';

    private Category $activeCategory;

    private array $output = [];

    private View $renderer;


    public function __construct(View $renderer)
    {
        $request = $_REQUEST;

        $activeId = (int) ($request['id'] ?? 0);
        $this->activeCategory = new Category($activeId);
        $this->renderer = $renderer;
    }

    public function view():void
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
        $id = $this->activeCategory->getId();
        $categories = (new Category())->getAll();

        if ($id !== 0 && $id <= count($categories)) {
            return $this->getProductsByCategory();
        }

        return $categories;
    }

    private function getProductsByCategory(): array
    {
        $products = new Product();

        $selection = [];
        foreach ($products->getAll() as $product) {
            if ($this->activeCategory->getName() === $product['category']) {
                $selection[$product['id']] = $product['name'];
            }
        }

        return $selection;
    }
}