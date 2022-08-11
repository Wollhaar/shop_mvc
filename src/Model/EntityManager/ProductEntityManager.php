<?php
declare(strict_types=1);

namespace Shop\Model\EntityManager;

use Shop\Model\Dto\ProductDataTransferObject;
use Shop\Service\SQLConnector;

class ProductEntityManager
{
    private const PDO_ATTRIBUTE_TYPES = [
        'integer' => \PDO::PARAM_INT,
        'string' => \PDO::PARAM_STR,
        'double' => \PDO::PARAM_STR,
    ];

    private SQLConnector $connector;


    public function __construct(SQLConnector $connector)
    {
        $this->connector = $connector;
    }

    public function addProduct(ProductDataTransferObject $data): void
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


        $category = $entityManager->find(\Shop\Model\Entity\Category::class, (int)$newProductCategory);

        $product = new \Shop\Model\Entity\Product();
        $product->setName($newProductName);
        $product->setSize($newProductSize);
        $product->setColor($newProductColor);
        $product->assignToCategory($category);
        $product->setPrice($newProductPrice);
        $product->setAmount((int)$newProductAmount);
        $product->setActive((bool)$newProductActive);

        $entityManager->persist($product);
        $entityManager->flush();
    }

    public function saveProduct(ProductDataTransferObject $data): void
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
    }

    public function deleteProductById(int $id): void
    {
        $sql = 'UPDATE products SET `active` = 0 WHERE `id` = :id LIMIT 1;';
        $this->connector->set($sql, ['id' => $id], ['id' => ['key' => ':id', 'type' => self::PDO_ATTRIBUTE_TYPES['integer']]]);
    }
}