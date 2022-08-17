<?php
declare(strict_types=1);

namespace Shop\Model\Repository;

use Doctrine\ORM\EntityManager;
use Shop\Model\Dto\CategoryDataTransferObject;
use Shop\Model\Entity\Category;
use Shop\Model\Mapper\CategoriesMapper;

class CategoryRepository
{
    private CategoriesMapper $mapper;
    private EntityManager $dataManager;

    public function __construct(CategoriesMapper $mapper, EntityManager $entityManager)
    {
        $this->mapper = $mapper;
        $this->dataManager = $entityManager;
    }

    public function findCategoryById(int $id): CategoryDataTransferObject|null
    {
        $category = $this->dataManager->find(Category::class, $id);
        return $this->validateCategory($category);
    }

    public function getAll(): array
    {
        $catRepo = $this->dataManager->getRepository(Category::class);
        $categories = $catRepo->findBy(['active' => true]);

        $categoryList = [];
        foreach ($categories as $category) {
            $categoryList[] = $this->validateCategory($category);
        }
        return $categoryList;
    }

    private function validateCategory(?Category $category): CategoryDataTransferObject
    {
        if (isset($category)) {
            $newCategory = [
                'id' => $category->getId(),
                'name' => $category->getName(),
                'active' => $category->getActive(),
            ];
        }

        return $this->mapper->mapToDto($newCategory ?? []);
    }
}