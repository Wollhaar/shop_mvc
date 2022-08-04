<?php
declare(strict_types=1);

namespace Shop\Model\Repository;

use Shop\Model\Dto\CategoryDataTransferObject;
use Shop\Model\Mapper\CategoriesMapper;
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
            $category = $this->connector->get($sql, $id)[0] ?? [];
        }

        return $this->validateCategory($category ?? []);
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

    public function getLastInsert(): CategoryDataTransferObject
    {
        $sql = 'SELECT * FROM categories WHERE `id` = LAST_INSERT_ID()';
        $category = $this->connector->get($sql)[0] ?? [];

        return $this->validateCategory($category);
    }

    private function validateCategory(array $category): CategoryDataTransferObject
    {
        if (!empty($category)) {
            $category['id'] = (int)$category['id'];
            $category['active'] = (bool)$category['active'];
        }
        return $this->mapper->mapToDto($category);
    }
}