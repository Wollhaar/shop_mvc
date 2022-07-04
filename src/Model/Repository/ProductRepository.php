<?php declare(strict_types=1);

namespace Shop\Model\Repository;

use Shop\Model\Dto\ProductDataTransferObject;
use Shop\Model\Mapper\ProductsMapper;

class ProductRepository
{
    private ProductsMapper $mapper;
    private array $products;
    private array $categories;

    public function __construct(ProductsMapper $mapper)
    {
        $data = file_get_contents(__DIR__ . '/products.json');
        $this->products = json_decode($data, true);
        $data = file_get_contents(__DIR__ . '/categories.json');
        $this->categories = json_decode($data, true);

        $this->mapper = $mapper;
    }

    public function findProductById(int $id): ProductDataTransferObject
    {
        $product = $this->products[$id] ?? [];
        $categoryId = $product['category'] ?? 0;
        $product['category'] = $this->categories[$categoryId]['name'] ?? 'none';
        return $this->mapper->mapToDto($product);
    }

    public function findProductsByCategoryId(int $id): array
    {
        $products = $this->products;
        foreach ($products as $key => $product) {
            if ($product['category'] === $id) {
                $categoryId = $product['category'] ?? 0;
                $product['category'] = $this->categories[$categoryId]['name'] ?? 'none';
                $products[$key] = $this->mapper->mapToDto($product);
            }
            else {
                unset($products[$key]);
            }
        }
        return $products;
    }
}