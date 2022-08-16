<?php
declare(strict_types=1);

namespace Shop\Model\EntityManager;

use Doctrine\ORM\EntityManager;
use Shop\Model\Dto\CategoryDataTransferObject;
use Shop\Model\Entity\Category;
use Shop\Service\SQLConnector;

class CategoryEntityManager
{
    private EntityManager $dataManager;

    public function __construct(SQLConnector $connection, EntityManager $entityManager)
    {
        $this->dataManager = $entityManager;
    }

    public function addCategory(CategoryDataTransferObject $data): void
    {
        $category = new \Shop\Model\Entity\Category();
        $category->setName($data->name);
        $category->setActive(true);

        $this->dataManager->persist($category);
        $this->dataManager->flush();
    }

    public function deleteCategoryById(int $id): void
    {
        $category = $this->dataManager->find(Category::class, $id);
//        $this->dataManager->remove($category);
        $category->setActive(false);

        $this->dataManager->flush();
    }
}