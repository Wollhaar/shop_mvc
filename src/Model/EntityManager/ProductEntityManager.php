<?php
declare(strict_types=1);

namespace Shop\Model\EntityManager;

use Doctrine\ORM\EntityManager;
use Shop\Model\Dto\ProductDataTransferObject;
use Shop\Model\Entity\{Category, Product};

class ProductEntityManager
{
    private EntityManager $dataManager;


    public function __construct(EntityManager $entityManager)
    {
        $this->dataManager = $entityManager;
    }

    public function addProduct(ProductDataTransferObject $data): void
    {
        $category = $this->dataManager->find(Category::class, (int)$data->category);

        $product = new Product();
        $product->setName($data->name);
        $product->setSize($data->size);
        $product->setColor($data->color);
        $product->assignToCategory($category);
        $product->setPrice((string)$data->price);
        $product->setAmount($data->amount);
        $product->setActive(true);

        $this->dataManager->persist($product);
        $this->dataManager->flush();
    }

    public function saveProduct(ProductDataTransferObject $data): void
    {
//        $product = $this->dataManager->find(Product::class, $data->id);
        $product = new Product();
        $category = $this->dataManager->find(Category::class, (int)$data->category);

        $product->setName($data->name);
        $product->setSize($data->size);
        $product->setColor($data->color);
        $product->assignToCategory($category);
        $product->setPrice((string)$data->price);
        $product->setAmount($data->amount);
        $product->setActive(true);

        $this->dataManager->persist($product);
        $this->dataManager->flush();
    }

    public function deleteProductById(int $id): void
    {
        $product = $this->dataManager->find(Product::class, $id);
        $product->setActive(false);

        $this->dataManager->flush();
    }
}