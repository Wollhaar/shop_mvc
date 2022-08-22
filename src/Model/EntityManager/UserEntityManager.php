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
        $user->setUsername($data->username);
        $user->setPasswordHash($data->passwordHash);
        $user->setFirstname($data->firstname);
        $user->setLastname($data->lastname);
        $user->setCreated(new \DateTime('now'));
        $user->setBirthday(new \DateTime($data->birthday));
        $user->setRole($data->role);
        $user->setActive(true);

        $this->dataManager->persist($user);
        $this->dataManager->flush();

        return $user->getId();
    }

    public function saveUser(UserDataTransferObject $data): void
    {
        $user = $this->dataManager->find(User::class, $data->id);

        if ($data->passwordHash !== '') {
            $user->setPasswordHash($data->passwordHash);
        }

        $user->setUsername($data->username);
        $user->setFirstname($data->firstname);
        $user->setLastname($data->lastname);
        $user->setUpdated(new \DateTime('now'));
        $user->setBirthday(new \DateTime($data->birthday));

        $this->dataManager->flush();
    }

    public function deleteUserById(int $id): void
    {
        $user = $this->dataManager->find(User::class, $id);
        if (!empty($user)) {
            $user->setActive(false);
        }
        $this->dataManager->flush();
    }

}