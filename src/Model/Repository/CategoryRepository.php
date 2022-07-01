<?php
declare(strict_types=1);

namespace Shop\Model\Repository;

use Shop\Model\Dto\CategoryDataTransferObject;

class CategoryRepository
{
    private array $categories;

    public function __construct()
    {
        $data = file_get_contents(__DIR__ . '/categories.json');
        $this->categories = json_decode($data, true);
    }
    public function findCategoryById(int $id): CategoryDataTransferObject
    {
        $category = $this->categories[$id] ?? [];

        if (!empty($category)) {
            $category = new CategoryDataTransferObject(
                $category['id'],
                $category['name']
            );
        }
        return empty($category) ? new CategoryDataTransferObject(0, 'All') : $category;
    }

    public function getAll(): array
    {
        $categories = [];
        foreach ($this->categories as $category) {
            $categories[$category['id']] = new CategoryDataTransferObject($category['id'], $category['name']);
        }
        return $categories;
    }
}