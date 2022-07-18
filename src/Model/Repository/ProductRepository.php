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

    public function addProduct(array $data): ProductDataTransferObject
    {
        $data['id'] = count($this->products) + 1;
        $data['category'] = (int)$data['category'];
        $data['price'] = (float)$data['price'];
        $data['amount'] = (int)$data['amount'];
        $data['active'] = true;

        $this->products[$data['id']] = $data;
        $this->write();

        $data['category'] = $this->categories[$data['category']]['name'];
        return $this->mapper->mapToDto($data);
    }

    public function saveProduct(array $data): ProductDataTransferObject
    {
        $data['id'] = (int)$data['id'];
        $data['category'] = (int)$data['category'];
        $data['price'] = (float)$data['price'];
        $data['amount'] = (int)$data['amount'];

        $this->products[$data['id']] = $data;
        $this->write();

        $data['category'] = $this->categories[$data['category']]['name'];
        return $this->mapper->mapToDto($data);
    }

    public function deleteProductById(int $id): void
    {
        unset($this->products[$id]);
        $this->write();
    }

    public function getAll(): array
    {
        $products = $this->products;
        foreach ($products as $key => $product) {
            $product['category'] = $this->categories[$product['category']]['name'];
            $products[$key] = $this->mapper->mapToDto($product);
        }
        return $products;
    }

    private function write(): void
    {
        $data = json_encode($this->products);
        file_put_contents(__DIR__ . '/products.json', $data);
    }
}