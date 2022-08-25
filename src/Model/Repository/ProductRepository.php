<?php declare(strict_types=1);

namespace Shop\Model\Repository;

use Doctrine\ORM\EntityManager;
use Shop\Model\Dto\ProductDataTransferObject;
use Shop\Model\Entity\Category;
use Shop\Model\Entity\Product;
use Shop\Model\Mapper\ProductsMapper;

class ProductRepository
{
    public function __construct(private ProductsMapper $mapper, private EntityManager $dataManager)
    {
    }

    public function findProductById(int $id): ProductDataTransferObject|null
    {
        $product = $this->dataManager->find(Product::class, $id);
        if (is_object($product)) {
            $product = $this->mapper->mapEntityToDto($product);
        }
        return $product;
    }

    public function findProductsByCategoryId(int $id): array
    {
        $category = $this->dataManager->find(Category::class, $id);
        $products = $this->dataManager->getRepository(Product::class)
            ->findBy(['category' => $category, 'active' => true]);

        foreach ($products as $key => $product) {
            $products[$key] = $this->mapper->mapEntityToDto($product);
        }
        return $products;
    }

    public function getAll(): array
    {
        $products = $this->dataManager
            ->getRepository(Product::class)
            ->findAll();

        foreach ($products as $key => $product) {
            unset($products[$key]);
            if ($product->active) {
                $products[$key] = $this->mapper->mapEntityToDto($product);
            }
        }
        return $products;
    }
}