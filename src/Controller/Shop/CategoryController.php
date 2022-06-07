<?php declare(strict_types=1);

namespace Controller\Shop;

use Model\Shop\Category;

class CategoryController
{
    private const categories = [
        1 => 'T-Shirt',
        2 => 'Pullover',
        3 => 'Hosen',
        4 => 'Sportswear',
    ];

    public $collection = [];


    public function __construct()
    {
        foreach (self::categories as $id => $name) {
            $this->collection[] = new Category($id, $name);
        }
    }

    public function getById(int $id): Category
    {
        foreach ($this->collection as $category) {
            if ($category->getId() === $id) {
                return $category;
            }
        }

        return new Category(0, 'none');
    }

    public function getByName($name): Category
    {
        foreach ($this->collection as $category) {
            if ($category->getName() === $name) {
                return $category;
            }

        }

        return new Category(0, 'none');
    }
}