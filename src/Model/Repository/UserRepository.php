<?php
declare(strict_types=1);

namespace Shop\Model\Repository;

use Doctrine\ORM\EntityManager;
use Shop\Model\Dto\UserDataTransferObject;
use Shop\Model\Entity\User;
use Shop\Model\Mapper\UsersMapper;

class UserRepository
{
    private EntityManager $dataManager;
    private UsersMapper $mapper;

    public function __construct(UsersMapper $mapper, EntityManager $entityManager)
    {
        $this->mapper = $mapper;
        $this->dataManager = $entityManager;
    }

    public function findUserById(int $id): UserDataTransferObject
    {
        $user = $this->dataManager->find(User::class, $id);
        return $this->validateUser($user);
    }

    public function findUserByUsername(string $name): UserDataTransferObject
    {
        $usrRepo = $this->dataManager->getRepository(User::class);
        $user = $usrRepo->findOneBy(['username' => $name]);

        return $this->validateUser($user);
    }

    public function getPasswordByUser(UserDataTransferObject $user): string
    {
        $userObj = $this->dataManager->find(User::class, $user->id);
        return isset($userObj) ? $userObj->getPassword() : '';
    }

    public function getAll(): array
    {
        $usrRepo = $this->dataManager->getRepository(User::class);
        $users = $usrRepo->findBy(['active' => true]);

        $userList = [];
        foreach ($users as $user) {
            $userList[] = $this->validateUser($user);
        }
        return $userList;
    }

    private function validateUser(?User $user): UserDataTransferObject
    {
        if (isset($user)) {
            $updated = $user->getUpdated();
            if (!empty($updated)) {
                $updated = $updated->format('Y-m-d h:i:s');
            }

            $newUser = [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'firstname' => $user->getFirstname(),
                'lastname' => $user->getLastname(),
                'created' => $user->getCreated()->format('Y-m-d h:i:s'),
                'updated' => $updated,
                'birthday' => $user->getBirthday()->format('Y-m-d h:i:s'),
                'active' => $user->getActive(),
            ];
        }
        return $this->mapper->mapToDto($newUser ?? []);
    }
}