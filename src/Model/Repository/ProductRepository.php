<?php declare(strict_types=1);

namespace Shop\Model\Repository;

use Shop\Model\Dto\ProductDataTransferObject;
use Shop\Model\Mapper\ProductsMapper;
use Shop\Service\SQLConnector;

class ProductRepository
{
    private ProductsMapper $mapper;
    private SQLConnector $connector;

    public function __construct(ProductsMapper $mapper, SQLConnector $connector)
    {
        $this->mapper = $mapper;
        $this->connector = $connector;
    }

    public function findProductById(int $id): ProductDataTransferObject
    {
        $sql = 'SELECT *, p.`id` as id, p.`name` as name, c.`name` as categoryName FROM products as p 
                LEFT JOIN categories as c 
                    ON p.`category` = c.`id` 
                   WHERE p.`id` = :id AND p.`active` = 1 LIMIT 1';

        if ($id) {
            $product = $this->connector->get($sql, $id)[0];
        }
        return $this->validateProduct($product ?? []);
    }

    public function findProductsByCategoryId(int $id): array
    {
        $sql = 'SELECT *, p.`id` as id, p.`name` as name, c.`name` as categoryName FROM products as p 
                LEFT JOIN categories as c ON p.`category` = c.`id` 
                   WHERE c.id = :id AND p.`active` = 1;';
        $products = $this->connector->get($sql, $id);

        foreach ($products as $key => $product) {
            $products[$key] = $this->validateProduct($product);
        }
        return $products;
    }

    public function getAll(): array
    {
        $sql = 'SELECT *, p.`id` as id, p.`name` as name, c.`name` as categoryName FROM products as p 
                LEFT JOIN categories as c ON p.`category` = c.`id` 
                WHERE p.`active` = 1;';
        $products = $this->connector->get($sql);
        foreach ($products as $key => $product) {
            $product['category'] = $product['categoryName'];
            $product['active'] = (bool)$product['active'];
            $products[$key] = $this->mapper->mapToDto($product);
        }
        return $products;
    }

    public function getLastInsert(): ProductDataTransferObject
    {
        $sql = 'SELECT *, p.`id` as id, p.`name` as name, c.`name` as categoryName FROM products as p 
                LEFT JOIN categories as c ON p.`category` = c.`id` 
                   WHERE p.id = LAST_INSERT_ID() LIMIT 1;';

        $product = $this->connector->get($sql)[0];
        return $this->validateProduct($product);
    }

    private function validateProduct(array $product): ProductDataTransferObject
    {
        if (!empty($product)) {
            $product['category'] = $product['categoryName'];
            $product['color'] = utf8_encode($product['color']);
            $product['active'] = (bool)$product['active'];
        }
        return $this->mapper->mapToDto($product);
    }
}