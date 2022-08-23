<?php
declare(strict_types=1);


// create_product.php <name>
require_once __DIR__ . "/../bootstrap-doctrine.php";


$username = $argv[1];
$pass = $argv[2];
$role = $argv[3] ?? null;

$user = new \Shop\Model\Entity\User();
$user->username = $username;
$user->passwordHash = $pass;
if (isset($role)) {
    $user->role = $role;
}
$user->created = new DateTime('now');
$user->active = true;

$entityManager->persist($user);
$entityManager->flush();

echo "Created User with ID " . $user->id . " and name: " . $user->username . "\n";