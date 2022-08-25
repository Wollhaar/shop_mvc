<?php
declare(strict_types=1);

namespace Shop\Model\Repository;

use Doctrine\ORM\EntityManager;
use Shop\Model\Dto\CategoryDataTransferObject;
use Shop\Model\Entity\Category;
use Shop\Model\Mapper\CategoriesMapper;

class CategoryRepository
{
    public function __construct(private CategoriesMapper $mapper, private EntityManager $dataManager)
    {
    }

    public function findCategoryById(int $id): CategoryDataTransferObject|null
    {
        $category = $this->dataManager->find(Category::class, $id);
        if (is_object($category)) {
            $category = $this->mapper->mapEntityToDto($category);
        }
        return $category;
    }

    public function getAll(): array
    {
        $catRepo = $this->dataManager->getRepository(Category::class);
        $categories = $catRepo->findBy(['active' => true]);

        $categoryList = [];
        foreach ($categories as $category) {
            $categoryList[] = $this->mapper->mapEntityToDto($category);
        }
        return $categoryList;
    }
}