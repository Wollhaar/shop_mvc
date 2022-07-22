<?php
declare(strict_types=1);

namespace Shop\Model\Repository;

use Shop\Model\Dto\CategoryDataTransferObject;
use Shop\Model\Mapper\CategoriesMapper;
use Shop\Service\SQLConnector;

class CategoryRepository
{
    private CategoriesMapper $mapper;
    private array $categories;
    private SQLConnector $database;

    public function __construct(CategoriesMapper $mapper, SQLConnector $connection)
    {
        $data = file_get_contents(__DIR__ . '/categories.json');
        $this->categories = json_decode($data, true);

        $this->mapper = $mapper;
        $this->database = $connection;
    }

    public function findCategoryById(int $id): CategoryDataTransferObject|null
    {
//        $category = $this->categories[$id] ?? [];
        $category = $this->database->get('categories', $id);
        var_dump($category);
        return $this->mapper->mapToDto($category);
    }

    public function addCategory(array $data): CategoryDataTransferObject
    {
        $data['id'] = count($this->categories) + 1;
        $data['active'] = true;
        $this->categories[$data['id']] = $data;

        $this->write();
        return $this->mapper->mapToDto($data);
    }

    public function deleteCategoryById(int $id): void
    {
        $category = $this->categories[$id] ?? [];
        $category['active'] = false;
        $this->categories[$id] = $category;
        $this->write();
    }

    public function getAll(): array
    {
        $categories = [];
        foreach ($this->categories as $key => $category) {
            if (!$category['active']) {
                unset($categories[$key]);
                continue;
            }
            $categories[$category['id']] = $this->mapper->mapToDto($category);
        }
        return $categories;
    }

    private function write(): void
    {
        $data = json_encode($this->categories);
        file_put_contents(__DIR__ . '/categories.json', $data);
    }
}