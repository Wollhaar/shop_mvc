<?php
declare(strict_types=1);

namespace Shop\Model\EntityManager;

use Doctrine\ORM\EntityManager;
use Shop\Model\Dto\CategoryDataTransferObject;
use Shop\Model\Entity\Category;

class CategoryEntityManager
{
    public function __construct(private EntityManager $dataManager)
    {
    }

    public function addCategory(CategoryDataTransferObject $data): int
    {
        $category = new \Shop\Model\Entity\Category();
        $category->name = $data->name;
        $category->active = $data->active;

        $this->dataManager->persist($category);
        $this->dataManager->flush();

        return $category->id;
    }

    public function deleteCategoryById(int $id): void
    {
        $category = $this->dataManager->find(Category::class, $id);
        if (!empty($category)) {
            $category->active = false;
        }

        $this->dataManager->flush();
    }
}