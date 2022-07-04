<?php
declare(strict_types=1);

namespace Shop\Model\Repository;

use Shop\Model\Dto\CategoryDataTransferObject;
use Shop\Model\Mapper\CategoriesMapper;

class CategoryRepository
{
    private CategoriesMapper $mapper;
    private array $categories;

    public function __construct(CategoriesMapper $mapper)
    {
        $data = file_get_contents(__DIR__ . '/categories.json');
        $this->categories = json_decode($data, true);

        $this->mapper = $mapper;
    }

    public function findCategoryById(int $id): CategoryDataTransferObject|null
    {
        $category = $this->categories[$id] ?? [];
        $category = $this->mapper->mapToDto($category);
        return $category;
    }

    public function getAll(): array
    {
        $categories = [];
        foreach ($this->categories as $category) {
            $categories[$category['id']] = $this->mapper->mapToDto($category);
        }
        return $categories;
    }
}