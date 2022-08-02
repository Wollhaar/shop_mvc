<?php
declare(strict_types=1);

namespace Shop\Model\Repository;

use Shop\Model\Dto\CategoryDataTransferObject;
use Shop\Model\Mapper\CategoriesMapper;
use Shop\Model\PDOAttribute;
use Shop\Service\SQLConnector;

class CategoryRepository
{
    private CategoriesMapper $mapper;
    private SQLConnector $connector;

    public function __construct(CategoriesMapper $mapper, SQLConnector $connection)
    {
        $this->mapper = $mapper;
        $this->connector = $connection;
    }

    public function findCategoryById(int $id): CategoryDataTransferObject|null
    {
        $sql = 'SELECT `id`, `name`, `active` FROM categories WHERE `id` = :id AND `active` = 1 LIMIT 1';
        if ($id) {
            $category = $this->connector->get($sql, $id)[0];
        }

        return $this->validateCategory($category ?? []);
    }

    public function addCategory(CategoryDataTransferObject $data): CategoryDataTransferObject
    {
        $sql = 'INSERT INTO categories (`name`) VALUES(:name)';
        $attributes = ['name' => new PDOAttribute(':name', gettype($data->name))];

        $this->connector->set($sql, (array)$data, $attributes);
        return $this->validateCategory($this->getLastInsert());
    }

    public function deleteCategoryById(int $id): void
    {
        $sql = 'UPDATE categories SET `active` = 0 WHERE `id` = :id LIMIT 1';
        $this->connector->set($sql, ['id' => $id], ['id' => new PDOAttribute(':id', 'integer')]);
    }

    public function getAll(): array
    {
        $sql = 'SELECT * FROM categories WHERE `active` = 1;';
        $categories = $this->connector->get($sql);
        $categoryList = [];
        foreach ($categories as $category) {
            $category['id'] = (int)$category['id'];
            $category['active'] = (bool)$category['active'];
            $categoryList[] = $this->mapper->mapToDto($category);
        }
        return $categoryList;
    }

    private function validateCategory(array $category): CategoryDataTransferObject
    {
        if (!empty($category)) {
            $category['id'] = (int)$category['id'];
            $category['active'] = (bool)$category['active'];
        }
        return $this->mapper->mapToDto($category);
    }

    private function getLastInsert(): array
    {
        $sql = 'SELECT * FROM categories WHERE `id` = LAST_INSERT_ID()';
        return $this->connector->get($sql)[0] ?? [];
    }
}