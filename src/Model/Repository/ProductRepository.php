<?php declare(strict_types=1);

namespace Shop\Model\Repository;

use phpDocumentor\Reflection\Types\This;
use Shop\Model\Dto\ProductDataTransferObject;
use Shop\Model\Mapper\ProductsMapper;
use Shop\Service\SQLConnector;
use function PHPUnit\Framework\stringContains;

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
        $product = $this->connector->get($sql, $id)[0];

        $product['category'] = $product['categoryName'];
        $product['color'] = utf8_encode($product['color']);
        $product['active'] = (bool)$product['active'];

        return $this->mapper->mapToDto($product);
    }

    public function findProductsByCategoryId(int $id): array
    {
        $sql = 'SELECT *, p.`id` as id, p.`name` as name, c.`name` as categoryName FROM products as p LEFT JOIN categories as c ON p.`category` = c.`id` WHERE c.id = :id;';
        $products = $this->connector->get($sql, $id);

        foreach ($products as $key => $product) {
            $product['category'] = $product['categoryName'];
            $product['color'] = utf8_encode($product['color']);
            $product['active'] = (bool)$product['active'];
            $products[$key] = $this->mapper->mapToDto($product);
        }
        return $products;
    }

    public function addProduct(array $data): ProductDataTransferObject
    {
        $sql = 'INSERT INTO products (`name`, `size`, `color`, `category`, `price`, `amount`) 
                VALUES(:name, :size, :color, :category, :price, :amount);';

        $data['category'] = (int)$data['category'];
        $data['price'] = (float)$data['price'];
        $data['amount'] = (int)$data['amount'];

        $this->connector->set($sql, $data);

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
                    `amount`= :amount, 
                    `active`= :active 
                WHERE `id` = :id LIMIT 1;';

        $attributes = [
            'id' => ['key' => ':id', 'type' => \PDO::PARAM_INT],
            'name' => ['key' => ':name', 'type' => \PDO::PARAM_STR],
            'size' => ['key' => ':size', 'type' => \PDO::PARAM_STR],
            'color' => ['key' => ':color', 'type' => \PDO::PARAM_STR],
            'category' => ['key' => ':category', 'type' => \PDO::PARAM_INT],
            'price' => ['key' => ':price', 'type' => \PDO::PARAM_STR],
            'amount' => ['key' => ':amount', 'type' => \PDO::PARAM_INT],
            'active' => ['key' => ':active', 'type' => \PDO::PARAM_INT],
        ];

        $this->connector->set($sql, (array)$data, $attributes);
        return $this->findProductById($data->id);
    }

    public function deleteProductById(int $id): void
    {
        $sql = 'UPDATE products SET `active` = 0 WHERE `id` = :id LIMIT 1;';
        $this->connector->set($sql, [$id], ['id'=>['key'=>':id','type'=>\PDO::PARAM_INT]]);
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

    private function getLastInsert(): array
    {
        $sql = 'SELECT *, p.`name` as name, c.`name` as categoryName FROM products as p LEFT JOIN categories as c ON p.`category` = c.`id` WHERE c.id = LAST_INSERT_ID() LIMIT 1;';
        $product = current($this->connector->get($sql));

        $product['category'] = $product['categoryName'];
        $product['active'] = (bool)$product['active'];
        return $product;
    }
}