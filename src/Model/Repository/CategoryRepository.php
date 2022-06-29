<?php
declare(strict_types=1);

namespace Shop\Model\Repository;

class CategoryRepository
{
    private array $categories;

    public function __construct()
    {
        $data = file_get_contents(__DIR__ . '/categories.json');
        $this->categories = json_decode($data, true);
    }
    public function findCategoryById(int $id): array
    {
        return $this->categories[$id] ?? [];
    }

    public function getAll(): array
    {
        return $this->categories ?? [];
    }
}