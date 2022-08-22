<?php
declare(strict_types=1);

// create_product.php <name>
require_once __DIR__ . "/../bootstrap-doctrine.php";


$newCategoryName = $argv[1];

$category = new \Shop\Model\Entity\Category();
$category->setName($newCategoryName);
$category->setActive(true);

$entityManager->persist($category);
$entityManager->flush();

echo "Created Product with ID " . $category->getId() . " and name: $newCategoryName\n";