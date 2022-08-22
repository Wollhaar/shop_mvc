<?php
declare(strict_types=1);


// create_product.php <name>
require_once __DIR__ . "/../bootstrap-doctrine.php";


$username = $argv[1];
$pass = $argv[2];
$role = $argv[3] ?? null;

$user = new \Shop\Model\Entity\User();
$user->setUsername($username);
$user->setPasswordHash($pass);
if (isset($role)) {
    $user->setRole($role);
}
$user->setCreated(new DateTime('now'));
$user->setActive(true);

$entityManager->persist($user);
$entityManager->flush();

echo "Created User with ID " . $user->getId() . " and name: " . $user->getUsername() . "\n";