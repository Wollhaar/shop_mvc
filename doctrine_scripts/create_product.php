<?php
declare(strict_types=1);

// create_product.php <name>
require_once __DIR__ . "/../bootstrap-doctrine.php";


$newProductName = $argv[1];
$newProductSize = $argv[2];
$newProductColor = $argv[3];
$newProductCategory = $argv[4];
$newProductPrice = $argv[5];
$newProductAmount = $argv[6];
$newProductActive = $argv[7];


$category = $entityManager->find(\Shop\Model\Entity\Category::class, (int)$newProductCategory);

$product = new \Shop\Model\Entity\Product();
$product->setName($newProductName);
$product->setSize($newProductSize);
$product->setColor($newProductColor);
$product->setCategory($category);
$product->setPrice($newProductPrice);
$product->setAmount((int)$newProductAmount);
$product->setActive((bool)$newProductActive);

$entityManager->persist($product);
$entityManager->flush();

echo "Created Product with ID " . $product->getId() . " and name: $newProductName and Category: " . $category->getName() . "\n";