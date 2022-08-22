<?php
declare(strict_types=1);

// list_products.php
use Shop\Model\Entity\Product;

require_once __DIR__ . "/../bootstrap-doctrine.php";

$productRepository = $entityManager->getRepository(Product::class);
$products = $productRepository->findAll();

foreach ($products as $product) {
    echo sprintf("-%s\n", $product->getName());
}