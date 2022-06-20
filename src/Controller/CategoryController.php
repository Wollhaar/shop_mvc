<?php declare(strict_types=1);

namespace Shop\Controller;

use Shop\Core\View;
use Shop\Model\{Category, Product};

class CategoryController implements BasicController
{
    private const TPL = 'CategoryView.tpl';

    private Category $activeCategory;

    private array $output = [];


    public function __construct()
    {
        $request = $_REQUEST;

        $activeId = (int) ($request['id'] ?? 0);
        $this->activeCategory = new Category($activeId);
    }

    public function view():void
    {
        $this->build();
        $activeCategory = false;

        if ($this->activeCategory->getId() !== 0) {
            $activeCategory = true;
        }
        $renderer = new View();
        $renderer->addTemplateParameter($this->activeCategory->getName(), 'title');
        $renderer->addTemplateParameterBoolean($activeCategory, 'activeCategory');
        $renderer->addTemplateParameterArray($this->output, 'output');
        $renderer->display(self::TPL);
    }

    private function build():void
    {
        if ($this->activeCategory->getId() !== 0) {
            $this->output = $this->getProductsByCategory();
        }
        else {
            foreach ($this->getCategories() as $category) {
                $this->output[$category['id']] = $category['name'];
            }
        }
    }

    private function getCategories(): array
    {
        return (new Category())->getAll();
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