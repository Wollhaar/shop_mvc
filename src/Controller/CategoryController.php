<?php declare(strict_types=1);

namespace Controller;

use Model\{Category, Product};

class CategoryController implements BasicController
{
    private const PAGE = 'category';

    private Category $activeCategory;

    private string $output = '<span style="color:cadetblue">Kategorie</span> ';

    private array $collection = [];


    public function __construct()
    {
        $request = $_REQUEST;

        foreach ($this->getCategories() as $id => $category) {
            $this->collection[$id] = $category;
        }
        $this->activeCategory = $this->collection[(int) ($request['id'] ?? 0)] ??
            new Category(0, 'none');

        $this->build();
    }

    public function __destruct()
    {
        inputHTML('###' . self::PAGE . '###', ROOT_PATH . '/src/View/category.html', $this->output);
    }

    public function view():void
    {
        inputHTML($this->output, ROOT_PATH . '/src/View/category.html', '###' . self::PAGE . '###');
        include ROOT_PATH . '/src/View/category.html';
    }

    private function getCategories(): array
    {
        global $categoryCollection;
        $categories = [];

        foreach ($categoryCollection as $id => $category) {
            $categories[$id] = new Category($id, $category);
        }

        return $categories;
    }

    private function getProductsByCategory(): array
    {
        global $productCollection;
        $products = [];

        foreach ($productCollection as $id => $product) {
            if ($this->activeCategory->getName() === $product['category']) {
                $products[$id] = new Product($id, $product['name'], $product['size'], $product['category'], (float) $product['price']);
            }
        }

        return $products;
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
}