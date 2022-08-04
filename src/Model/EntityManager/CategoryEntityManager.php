<?php
declare(strict_types=1);

namespace Shop\Model\EntityManager;

use Shop\Model\Dto\CategoryDataTransferObject;
use Shop\Service\SQLConnector;

class CategoryEntityManager
{
    private const PDO_ATTRIBUTE_TYPES = [
        'integer' => \PDO::PARAM_INT,
        'string' => \PDO::PARAM_STR,
        'double' => \PDO::PARAM_STR,
    ];

    private SQLConnector $connector;

    public function __construct(SQLConnector $connection)
    {
        $this->connector = $connection;
    }

    public function addCategory(CategoryDataTransferObject $data): void
    {
        $sql = 'INSERT INTO categories (`name`) VALUES(:name)';
        $attributes = ['name' => ['key' => ':name', 'type' => self::PDO_ATTRIBUTE_TYPES[gettype($data->name)]]];

        $this->connector->set($sql, (array)$data, $attributes);
    }

    public function deleteCategoryById(int $id): void
    {
        $sql = 'UPDATE categories SET `active` = 0 WHERE `id` = :id LIMIT 1';
        $this->connector->set($sql, ['id' => $id], ['id' => ['key' => ':id', 'type' => self::PDO_ATTRIBUTE_TYPES['integer']]]);
    }
}