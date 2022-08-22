<?php
declare(strict_types=1);

// create_product.php <name>
require_once __DIR__ . "/../bootstrap-doctrine.php";

$dbConnOLD = new \Shop\Service\SQLConnector();

$sql = 'SELECT 
            p.`name`, 
            p.`size`, 
            p.`color`, 
            p.`category`, 
            p.`price`, 
            p.`amount`,
            c.`name` as categoryName
         FROM products as p 
         LEFT JOIN categories as c 
            ON p.`category` = c.`id` 
        WHERE p.id > 1';
$products = $dbConnOLD->get($sql);
$categoryRepo = $entityManager->getRepository(\Shop\Model\Entity\Category::class);


foreach ($products as $oldProduct) {
    $category = $categoryRepo->findOneBy(['name' => $oldProduct['categoryName']]);

    $product = new \Shop\Model\Entity\Product();
    $product->setName($oldProduct['name']);
    $product->setSize($oldProduct['size']);
    $product->setColor($oldProduct['color']);
    $product->setCategory($category);
    $product->setPrice((string)$oldProduct['price']);
    $product->setAmount((int)$oldProduct['amount']);
    $product->setActive(true);
    $entityManager->persist($product);

//    echo "Created Product with ID " . $product->getId() . " and name: " . $product->getName() . " and Category: " . $category->getName() . "\n";
}

$entityManager->flush();

