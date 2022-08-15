<?php
declare(strict_types=1);

namespace Shop\Model\EntityManager;

use Doctrine\ORM\EntityManager;
use Shop\Model\Dto\CategoryDataTransferObject;
use Shop\Model\Entity\Category;
use Shop\Service\SQLConnector;

class CategoryEntityManager
{
    private const PDO_ATTRIBUTE_TYPES = [
        'integer' => \PDO::PARAM_INT,
        'string' => \PDO::PARAM_STR,
        'double' => \PDO::PARAM_STR,
    ];

    private SQLConnector $connector;
    private EntityManager $dataManager;

    public function __construct(SQLConnector $connection, EntityManager $entityManager)
    {
        $this->connector = $connection;
        $this->dataManager = $entityManager;
    }

    public function addCategory(CategoryDataTransferObject $data): void
    {
//        $sql = 'INSERT INTO categories (`name`) VALUES(:name)';
//        $attributes = ['name' => ['key' => ':name', 'type' => self::PDO_ATTRIBUTE_TYPES[gettype($data->name)]]];
//
//        $this->connector->set($sql, (array)$data, $attributes);

        $category = new \Shop\Model\Entity\Category();
        $category->setName($data->name);
        $category->setActive(true);

        $this->dataManager->persist($category);
        $this->dataManager->flush();
    }

    public function deleteCategoryById(int $id): void
    {
//        $sql = 'UPDATE categories SET `active` = 0 WHERE `id` = :id LIMIT 1';
//        $this->connector->set($sql, ['id' => $id], ['id' => ['key' => ':id', 'type' => self::PDO_ATTRIBUTE_TYPES['integer']]]);

        $category = $this->dataManager->find(Category::class, $id);
//        $this->dataManager->remove($category);
        $category->setActive(false);

        $this->dataManager->flush();
    }
}