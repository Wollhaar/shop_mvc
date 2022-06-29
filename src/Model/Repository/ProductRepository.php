<?php declare(strict_types=1);

namespace Shop\Model\Repository;

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

    public function findProductById(int $id): array
    {
        $product = $this->products[$id] ?? [];
        if (!empty($product)) {
            $product['categoryName'] = $this->categories[$product['category']]['name'] ?? 'none';
        }
        return $product;
    }

    public function findProductsByCategoryId(int $id): array
    {
        $products = $this->products;
        foreach ($products as $key => $item) {
            if ($item['category'] !== $id) {
                unset($products[$key]);
            }
        }
        return $products;
    }

    public function getAll(): array
    {
        return $this->products ?? [];
    }
}