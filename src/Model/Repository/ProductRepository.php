<?php declare(strict_types=1);

namespace Shop\Model\Repository;

use Shop\Model\Dto\ProductDataTransferObject;
use Shop\Model\Mapper\ProductsMapper;
use Shop\Model\PDOAttribute;
use Shop\Service\SQLConnector;

class ProductRepository
{
    private const PDO_ATTRIBUTE_TYPES = [
        'integer' => \PDO::PARAM_INT,
        'string' => \PDO::PARAM_STR,
        'double' => \PDO::PARAM_STR,
    ];

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

    public function addProduct(ProductDataTransferObject $data): ProductDataTransferObject
    {
        $sql = 'INSERT INTO products (`name`, `size`, `color`, `category`, `price`, `amount`) 
                VALUES(:name, :size, :color, :category, :price, :amount);';

        $attributes = [
            'name' => ['key' =>':name', 'type' => self::PDO_ATTRIBUTE_TYPES[gettype($data->name)]],
            'size' => ['key' =>':size', 'type' => self::PDO_ATTRIBUTE_TYPES[gettype($data->size)]],
            'color' => ['key' =>':color', 'type' => self::PDO_ATTRIBUTE_TYPES[gettype($data->color)]],
            'category' => ['key' =>':category', 'type' => self::PDO_ATTRIBUTE_TYPES[gettype($data->category)]],
            'price' => ['key' =>':price', 'type' => self::PDO_ATTRIBUTE_TYPES[gettype($data->price)]],
            'amount' => ['key' =>':amount', 'type' => self::PDO_ATTRIBUTE_TYPES[gettype($data->amount)]]
        ];

        $this->connector->set($sql, (array)$data, $attributes);

        return $this->mapper->mapToDto($this->getLastInsert());
    }

    public function saveProduct(ProductDataTransferObject $data): ProductDataTransferObject
    {
        $sql = 'UPDATE products SET 
                    `name` = :name, 
                    `size`= :size, 
                    `color`= :color, 
                    `category`= :category, 
                    `price`= :price, 
                    `amount`= :amount 
                WHERE `id` = :id LIMIT 1;';

        $attributes = [
            'id' => ['key' =>':id', 'type' => self::PDO_ATTRIBUTE_TYPES[gettype($data->id)]],
            'name' => ['key' =>':name', 'type' => self::PDO_ATTRIBUTE_TYPES[gettype($data->name)]],
            'size' => ['key' =>':size', 'type' => self::PDO_ATTRIBUTE_TYPES[gettype($data->size)]],
            'color' => ['key' =>':color', 'type' => self::PDO_ATTRIBUTE_TYPES[gettype($data->color)]],
            'category' => ['key' =>':category', 'type' => self::PDO_ATTRIBUTE_TYPES[gettype($data->category)]],
            'price' => ['key' =>':price', 'type' => self::PDO_ATTRIBUTE_TYPES[gettype($data->price)]],
            'amount' => ['key' =>':amount', 'type' => self::PDO_ATTRIBUTE_TYPES[gettype($data->amount)]]
        ];

        $this->connector->set($sql, (array)$data, $attributes);
        return $this->findProductById($data->id);
    }

    public function deleteProductById(int $id): void
    {
        $sql = 'UPDATE products SET `active` = 0 WHERE `id` = :id LIMIT 1;';
        $this->connector->set($sql, ['id' => $id], ['id' => ['key' => ':id', 'type' => self::PDO_ATTRIBUTE_TYPES['integer']]]);
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

    private function validateProduct(array $product): ProductDataTransferObject
    {
        if (!empty($product)) {
            $product['category'] = $product['categoryName'];
            $product['color'] = utf8_encode($product['color']);
            $product['active'] = (bool)$product['active'];
        }
        return $this->mapper->mapToDto($product);
    }

    private function getLastInsert(): array
    {
        $sql = 'SELECT *, p.`id` as id, p.`name` as name, c.`name` as categoryName FROM products as p 
                LEFT JOIN categories as c ON p.`category` = c.`id` 
                   WHERE p.id = LAST_INSERT_ID() LIMIT 1;';
        $product = $this->connector->get($sql)[0];

        $product['category'] = $product['categoryName'];
        $product['active'] = (bool)$product['active'];
        return $product;
    }
}