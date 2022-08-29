<?php declare(strict_types=1);

// create_product.php <name>
require_once __DIR__ . "/../bootstrap-doctrine.php";
$helper = new \Shop\Core\PasswordGenerator();

$id = $argv[1];
$attr = $argv[2];
$val = $argv[3];


$user = $entityManager->find(\Shop\Model\Entity\User::class, $id);

switch ($attr) {
    case 'username':
        $user->username = $val;
        break;
    case 'password':
        $user->passwordHash = $helper->hash($val);
        break;
    case 'firstname':
        $user->firstname = $val;
        break;
    case 'lastname':
        $user->lastname = $val;
        break;
    case 'role':
        $user->role = $val;
        break;
    case 'update':
        $user->updated = new DateTime();
        break;
    case 'active':
        $user->active = (bool)$val;
        break;
}
$entityManager->flush();
