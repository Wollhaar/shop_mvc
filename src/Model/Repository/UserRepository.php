<?php
declare(strict_types=1);

namespace Shop\Model\Repository;

use Doctrine\ORM\EntityManager;
use Shop\Model\Dto\UserDataTransferObject;
use Shop\Model\Entity\User;
use Shop\Model\Mapper\UsersMapper;

class UserRepository
{
    public function __construct(private UsersMapper $mapper, private EntityManager $dataManager)
    {
    }

    public function findUserById(int $id): UserDataTransferObject|null
    {
        $user = $this->dataManager->find(User::class, $id);
        if (is_object($user)) {
            $user = $this->mapper->mapEntityToDto($user);
        }
        return $user;
    }

    public function findUserByUsername(string $name): UserDataTransferObject|null
    {
        $usrRepo = $this->dataManager->getRepository(User::class);
        $user = $usrRepo->findOneBy(['username' => $name]);

        if (is_object($user)) {
            $user = $this->mapper->mapEntityToDto($user);
        }
        return $user;
    }

    public function getAll(): array
    {
        $usrRepo = $this->dataManager->getRepository(User::class);
        $users = $usrRepo->findBy(['active' => true]);

        $userList = [];
        foreach ($users as $user) {
//            if ($user)
//            var_dump($user);
            $userList[] = $this->mapper->mapEntityToDto($user);
        }
        return $userList;
    }
}