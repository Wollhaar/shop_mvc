<?php declare(strict_types=1);

namespace Shop\Controller;

use Shop\Controller\Data\DataHandler;
use Shop\Core\View;
use Shop\Model\{Category, Product};

class CategoryController implements BasicController
{
    private const TPL = 'CategoryView.tpl';

    private Category $activeCategory;

    private DataHandler $dataHandler;

    private string $output = '<span style="color:cadetblue">Kategorie</span> ';

    private array $collection = [];


    public function __construct()
    {
        $this->dataHandler = DataHandler::getInstance();
        $request = $_REQUEST;

        foreach ($this->getCategories() as $id => $category) {
            $this->collection[$id] = $category;
        }
        $this->activeCategory = $this->collection[(int) ($request['id'] ?? 0)] ??
            new Category(0, 'none');

        $this->build();
    }

    public function view():void
    {
        $renderer = new View();
        $renderer->addTemplateParameter($this->output, 'output');
        $renderer->display(self::TPL);
    }

    private function build():void
    {
        if ($this->activeCategory->getId() !== 0) {
            $this->output .= $this->activeCategory->getName();

            $this->output .= '<p>';
            foreach ($this->getProductsByCategory() as $content) {
                $this->output .= '<a href="?page=detail&id=' . $content->getId() . '">' . $content->getName() . '</a><br/>';
            }
            $this->output .= '</p>';
        }
        else {
            $this->output .= '<p>';
            foreach ($this->collection as $content) {
                $this->output .= '<a href="?page=category&id=' . $content->getId() . '">' . $content->getName() . '</a><br/>';
            }
            $this->output .= '</p>';
        }
    }

    private function getCategories(): array
    {
        $categories = [];
        foreach ($this->dataHandler->get('categories') as $id => $category) {
            $categories[$id] = new Category($id, $category['name']);
        }

        return $categories;
    }

    private function getProductsByCategory(): array
    {
        $products = [];
        foreach ($this->dataHandler->get('products') as $id => $product) {
            if ($this->activeCategory->getName() === $product['category']) {
                $products[$id] = new Product($id, $product['name'], $product['size'], $product['category'], (float) $product['price']);
            }
        }

        return $products;
    }
}