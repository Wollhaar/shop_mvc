<?php
declare(strict_types=1);

// list_products.php

require_once __DIR__ . "/../bootstrap-doctrine.php";

$userRepository = $entityManager->getRepository(\Shop\Model\Entity\User::class);
$users = $userRepository->findAll();
var_dump($users);
foreach ($users as $user) {
    $user = $entityManager->find(\Shop\Model\Entity\User::class, $user->id);
    var_dump($user);
    echo sprintf("-%s\n", $user->username);
}