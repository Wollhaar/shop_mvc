<?php
declare(strict_types=1);

namespace Shop\Model\EntityManager;

use Doctrine\ORM\EntityManager;
use Shop\Model\Dto\UserDataTransferObject;
use Shop\Model\Entity\User;

class UserEntityManager
{
    public function __construct(private EntityManager $dataManager)
    {
    }

    public function addUser(UserDataTransferObject $data): int
    {
        $user = new User();
        $user->username = $data->username;
        $user->passwordHash = $data->passwordHash;
        $user->email = $data->email;
        $user->firstname = $data->firstname;
        $user->lastname = $data->lastname;
        $user->created = new \DateTime($data->created);
        $user->birthday = new \DateTime($data->birthday);
        $user->role = $data->role;
        $user->active = $data->active;

        $this->dataManager->persist($user);
        $this->dataManager->flush();

        return $user->id;
    }

    public function saveUser(UserDataTransferObject $data): void
    {
        $user = $this->dataManager->find(User::class, $data->id);

        if ($data->passwordHash !== '') {
            $user->passwordHash = $data->passwordHash;
        }

        $user->username = $data->username;
        $user->email = $data->email;
        $user->firstname = $data->firstname;
        $user->lastname = $data->lastname;
        $user->updated = new \DateTime('now');
        $user->birthday = new \DateTime($data->birthday);

        $this->dataManager->flush();
    }

    public function savePassword(int $id, $passwordHash): bool
    {
        $user = $this->dataManager->find(User::class, $id);
        $user->passwordHash = $passwordHash;
        $this->dataManager->flush();
        return true;
    }

    public function deleteUserById(int $id): void
    {
        $user = $this->dataManager->find(User::class, $id);
        if (!empty($user) && $user->role !== 'root') {
            $user->active = false;
        }
        $this->dataManager->flush();
    }

}