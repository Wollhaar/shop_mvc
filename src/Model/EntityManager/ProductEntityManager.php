<?php
declare(strict_types=1);

namespace Shop\Model\EntityManager;

use Doctrine\ORM\EntityManager;
use Shop\Model\Dto\ProductDataTransferObject;
use Shop\Model\Entity\{Category, Product};

class ProductEntityManager
{
    public function __construct(private EntityManager $dataManager)
    {
    }

    public function addProduct(ProductDataTransferObject $data): int
    {
        $category = $this->dataManager
            ->getRepository(Category::class)
            ->findOneBy(['name' => $data->category]);

        $product = new Product();
        $product->setName($data->name);
        $product->setSize($data->size);
        $product->setColor($data->color);
        $product->setCategory($category);
        $product->setPrice((string)$data->price);
        $product->setAmount($data->amount);
        $product->setActive(true);

        $this->dataManager->persist($product);
        $this->dataManager->flush();

        return $product->getId();
    }

    public function saveProduct(ProductDataTransferObject $data): void
    {
        $product = $this->dataManager->find(Product::class, $data->id);
        $category = $this->dataManager->getRepository(Category::class)
            ->findOneBy(['name' => $data->category]);

        $product->setName($data->name);
        $product->setSize($data->size);
        $product->setColor($data->color);
        $product->setCategory($category);
        $product->setPrice((string)$data->price);
        $product->setAmount($data->amount);

        $this->dataManager->flush();
    }

    public function deleteProductById(int $id): void
    {
        $product = $this->dataManager->find(Product::class, $id);
        $product->setActive(false);

        $this->dataManager->flush();
    }
}