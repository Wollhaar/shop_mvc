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
        $product->name = $data->name;
        $product->size = $data->size;
        $product->color = $data->color;
        $product->setCategory($category);
        $product->price = $data->price;
        $product->amount = $data->amount;
        $product->active = $data->active;

        $this->dataManager->persist($product);
        $this->dataManager->flush();

        return $product->id;
    }

    public function saveProduct(ProductDataTransferObject $data): void
    {
        $product = $this->dataManager->find(Product::class, $data->id);
        $category = $this->dataManager->getRepository(Category::class)
            ->findOneBy(['name' => $data->category]);

        $product->name = $data->name;
        $product->size = $data->size;
        $product->color = $data->color;
        $product->setCategory($category);
        $product->price = $data->price;
        $product->amount = $data->amount;

        $this->dataManager->flush();
    }

    public function deleteProductById(int $id): void
    {
        $product = $this->dataManager->find(Product::class, $id);
        if (is_object($product)) {
            $product->active = false;
        }

        $this->dataManager->flush();
    }
}