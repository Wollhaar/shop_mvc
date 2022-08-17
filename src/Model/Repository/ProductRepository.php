<?php declare(strict_types=1);

namespace Shop\Model\Repository;

use Doctrine\ORM\EntityManager;
use Shop\Model\Dto\ProductDataTransferObject;
use Shop\Model\Entity\Category;
use Shop\Model\Entity\Product;
use Shop\Model\Mapper\ProductsMapper;

class ProductRepository
{
    private ProductsMapper $mapper;
    private EntityManager $dataManager;

    public function __construct(ProductsMapper $mapper, EntityManager $entityManager)
    {
        $this->mapper = $mapper;
        $this->dataManager = $entityManager;
    }

    public function findProductById(int $id): ProductDataTransferObject|null
    {
        $product = $this->dataManager->find(Product::class, $id);
        return $this->validateProduct($product);
    }

    public function findProductsByCategoryId(int $id): array
    {
        $category = $this->dataManager->find(Category::class, $id);
        $prodRepo = $this->dataManager->getRepository(Product::class);
        $products = $prodRepo->findBy(['category' => $category->getId(), 'active' => true]);

        foreach ($products as $key => $product) {
            $products[$key] = $this->validateProduct($product);
        }
        return $products;
    }

    public function getAll(): array
    {
        $prodDataRepository = $this->dataManager->getRepository(Product::class);
        $products = $prodDataRepository->findAll();

        foreach ($products as $key => $product) {
            unset($products[$key]);
            if ($product->isActive()) {
                $products[$key] = $this->validateProduct($product);
            }
        }
        return $products;
    }

    private function validateProduct(?Product $product): ProductDataTransferObject
    {
        if (isset($product)) {
            $newProduct = [
                'id' => $product->getId(),
                'name' => utf8_encode($product->getName()),
                'size' => $product->getSize(),
                'color' => utf8_encode($product->getColor()),
                'category' => $product->getCategory()->getName(),
                'price' => (float)$product->getPrice(),
                'amount' => $product->getAmount(),
                'active' => $product->isActive(),
            ];
        }

        return $this->mapper->mapToDto($newProduct ?? []);
    }
}