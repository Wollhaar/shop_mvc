<?php
declare(strict_types=1);

// create_product.php <name>
require_once __DIR__ . "/../bootstrap-doctrine.php";

$dbConnOLD = new \Shop\Service\SQLConnector();

$sql = 'SELECT 
            `username`, 
            `password`, 
            `firstname`, 
            `lastname`, 
            `created`, 
            `updated`,
            `birthday`
         FROM users';
$users = $dbConnOLD->get($sql);

foreach ($users as $oldUser) {
    $user = new \Shop\Model\Entity\User();
    $user->setUsername($oldUser['username']);
    $user->setPasswordHash($oldUser['password']);
    $user->setFirstname($oldUser['firstname']);
    $user->setLastname($oldUser['lastname']);
    $user->setCreated(new DateTime($oldUser['created']));
    $user->setUpdated(new DateTime($oldUser['updated']));
    $user->setBirthday(new DateTime($oldUser['birthday']));
    $user->setActive(true);

    $entityManager->persist($user);
//    echo "Created Product with ID " . $product->getId() . " and name: " . $product->getName() . " and Category: " . $category->getName() . "\n";
}

$entityManager->flush();

