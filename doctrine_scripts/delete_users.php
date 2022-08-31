<?php declare(strict_types=1);

// create_product.php <name>
require_once __DIR__ . "/../bootstrap-doctrine.php";
$helper = new \Shop\Core\PasswordGenerator();


//$users = $entityManager->createQuery('SELECT id, username FROM User WHERE id = 4')->getResult(); //getRepository(\Shop\Model\Entity\User::class)->createQueryBuilder()->findBy(['id' => '>4']);
var_dump((new DateTime())->diff(new DateTime()));

//$entityManager->flush();
