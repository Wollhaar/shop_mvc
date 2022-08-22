<?php declare(strict_types=1);

// create_product.php <name>
require_once __DIR__ . "/../bootstrap-doctrine.php";


$id = $argv[1];
$attr = $argv[2];
$val = $argv[3];


$user = $entityManager->find(\Shop\Model\Entity\User::class, $id);

switch ($attr) {
    case 'username':
        $user->setName($val);
        break;
    case 'password':
        $user->setPassword($val);
        break;
    case 'firstname':
        $user->setFirstname($val);
        break;
    case 'lastname':
        $user->setLastname($val);
        break;
    case 'role':
        $user->setRole($val);
        echo $val . "\n";
        break;
    case 'active':
        $user->setActive((bool)$val);
        break;
}
var_dump($user);
$entityManager->flush();
