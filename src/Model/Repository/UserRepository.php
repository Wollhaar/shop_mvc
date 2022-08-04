<?php
declare(strict_types=1);

namespace Shop\Model\Repository;

use Shop\Model\Dto\UserDataTransferObject;
use Shop\Model\Mapper\UsersMapper;
use Shop\Service\SQLConnector;

class UserRepository
{
    private SQLConnector $connector;
    private UsersMapper $mapper;

    public function __construct(UsersMapper $mapper, SQLConnector $connector)
    {
        $this->mapper = $mapper;
        $this->connector = $connector;
    }

    public function findUserById(int $id): UserDataTransferObject
    {
        $sql = 'SELECT * FROM users WHERE `id` = :id AND `active` = 1;';
        if ($id) {
            $user = $this->connector->get($sql, $id)[0] ?? [];
        }
        return $this->validateUser($user ?? []);
    }

    public function findUserByUsername(string $name): UserDataTransferObject
    {
        $sql = 'SELECT * FROM users WHERE `username` = :username AND `active` = 1';
        $user = $this->connector->getByString($sql, $name, ':username')[0] ?? [];

        return $this->validateUser($user);
    }

    public function getPasswordByUser(UserDataTransferObject $user): string
    {
        $sql = 'SELECT `password` FROM users WHERE `id` = :id AND `active` = 1 LIMiT 1;';
        $password = $this->connector->get($sql, $user->id)[0] ?? [];
        return $password['password'] ?? '';
    }

    public function getAll(): array
    {
        $sql = 'SELECT * FROM users WHERE `active` = 1;';
        $users = $this->connector->get($sql);
        $userList = [];
        foreach ($users as $user) {
            $user['active'] = (bool)$user['active'];
            $userList[] = $this->mapper->mapToDto($user);
        }
        return $userList;
    }

    public function getLastInsert(): UserDataTransferObject
    {
        $sql = 'SELECT * FROM users WHERE `id` = LAST_INSERT_ID()';
        $user = $this->connector->get($sql)[0] ?? [];

        return $this->validateUser($user);
    }

    private function validateUser(array $user): UserDataTransferObject
    {
        if (!empty($user)) {
            $user['id'] = (int)$user['id'];
            $user['active'] = (bool)$user['active'];
        }
        return $this->mapper->mapToDto($user);
    }
}