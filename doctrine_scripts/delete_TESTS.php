<?php declare(strict_types=1);


// delete_TESTS.php <name>
use Shop\Model\Entity\Category;

require_once __DIR__ . "/../bootstrap-doctrine.php";

$category = $entityManager->find(Category::class, 1);

//$queryBuild = $entityManager->createQueryBuilder();
//$categories = $queryBuild
//    ->select('cat.id')
//    ->addSelect(['cat.name', 'cat.active'])
//    ->from(Category::class, 'cat')
//    ->andWhere('cat.name LIKE \'TEST%\'')
//    ->andWhere('cat.active = false')
//    ->getQuery()->execute();

$entityManager->remove($category);


//foreach ($categories as $category) {
//    $newCatObj = new Category();
//    $newCatObj->setId((int)$category['id']);
//    $newCatObj->setName($category['name']);
//    $newCatObj->setActive((bool)$category['active']);
//    $entityManager->remove($newCatObj);
//}
$entityManager->flush();