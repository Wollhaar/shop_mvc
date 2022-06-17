<?php
declare(strict_types=1);

namespace Shop\Controller\Data;

use Shop\Model\{Category, Data, Product};

class DataHandler
{
    private static DataHandler $instance;

    public static function getInstance():DataHandler
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getIntegerData(string $select, int $id, string $attribute): int
    {
        switch ($select) {
            case 'categories':
                global $categoryCollection;
                $value = $categoryCollection[$id][$attribute];
                break;

            case 'products':
                global $productCollection;
                $value = $productCollection[$id][$attribute];
                break;

            default:
                $value = null;
        }

        return is_int($value) ? $value : 0;
    }

    public function getData(string $select, int $id): Data
    {
        switch ($select) {
            case 'categories':
                global $categoryCollection;
                $category = $categoryCollection[$id];
                return new Category($id, $category['name']);

            case 'products':
                global $productCollection;
                $product = $productCollection[$id];
                return new Product($id, $product['name'], $product['size'], $product['category'], $product['price']);

            default:
                return new Category(0, 'none'); // TODO:???
        }
    }

    public function get(string $select): array
    {
        switch ($select) {
            case 'categories':
                global $categoryCollection;
                $return = $categoryCollection;
                break;

            case 'products':
                global $productCollection;
                $return = $productCollection;
                break;
        }
        return empty($return) ? [] : $return;
    }
}