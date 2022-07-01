<?php declare(strict_types=1);

namespace Shop\Model\Repository;

use Shop\Model\Dto\ProductDataTransferObject;

class ProductRepository
{
    private array $products;
    private array $categories;

    public function __construct()
    {
        $data = file_get_contents(__DIR__ . '/products.json');
        $this->products = json_decode($data, true);
        $data = file_get_contents(__DIR__ . '/categories.json');
        $this->categories = json_decode($data, true);
    }

    public function findProductById(int $id): ProductDataTransferObject
    {
        $product = $this->products[$id] ?? [];
        if (!empty($product)) {
            $product = new ProductDataTransferObject(
                $product['id'],
                $product['name'],
                $product['size'],
                $this->categories[$product['category']]['name'],
                $product['price'],
                $product['amount']
            );
        }
        return empty($product) ?
            new ProductDataTransferObject(0, 'none', 'none', 'none', 0, 0) :
            $product;
    }

    public function findProductsByCategoryId(int $id): array
    {
        $products = $this->products;
        foreach ($products as $key => $product) {
            if ($product['category'] === $id) {
                $products[$key] = new ProductDataTransferObject(
                    $product['id'],
                    $product['name'],
                    $product['size'],
                    $this->categories[$product['category']]['name'],
                    $product['price'],
                    $product['amount']
                );
            }
            else {
                unset($products[$key]);
            }
        }
        return $products;
    }
}