<?php
declare(strict_types=1);

namespace Shop\Model\Repository;

use Shop\Model\Dto\UserDataTransferObject;
use Shop\Model\Mapper\UsersMapper;
use Shop\Model\PDOAttribute;
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

    public function addUser(UserDataTransferObject $data, string $password): UserDataTransferObject
    {
        $sql = 'INSERT INTO users (
                   `username`,
                   `password`,
                   `firstname`,
                   `lastname`,
                   `birthday`
                ) VALUES(
                     :username,
                     :password,
                     :firstname,
                     :lastname,
                     :birthday
                );';

        $data->password = $password;

        $attributes = [
            'username' => new PDOAttribute(':username', gettype($data->username)),
            'password' => new PDOAttribute(':password', gettype($data->password)),
            'firstname' => new PDOAttribute(':firstname', gettype($data->firstname)),
            'lastname' => new PDOAttribute(':lastname', gettype($data->lastname)),
            'birthday' => new PDOAttribute(':birthday', gettype($data->birthday)),
        ];

        $this->connector->set($sql, (array)$data, $attributes);
        return $this->validateUser($this->getLastInsert() ?? []);
    }

    public function saveUser(UserDataTransferObject $data, string $password): UserDataTransferObject
    {
        $sql = 'UPDATE users SET 
                     `username` = :username, 
                     `firstname` = :firstname, 
                     `lastname` = :lastname, 
                     `updated` = :updated, 
                     `birthday` = :birthday';

        $attributes = [
            'id' => new PDOAttribute(':id', gettype($data->id)),
            'username' => new PDOAttribute(':username', gettype($data->username)),
            'firstname' => new PDOAttribute(':firstname', gettype($data->firstname)),
            'lastname' => new PDOAttribute(':lastname', gettype($data->lastname)),
            'updated' => new PDOAttribute(':updated', gettype($data->lastname)),
            'birthday' => new PDOAttribute(':birthday', gettype($data->birthday)),
        ];

        if ($password !== '') {
            $sql .= ', `password` = :password';
            $attributes['password'] = new PDOAttribute(':password', 'string'); //TODO: resolve dependencies (object necessary?)
            $data->password = $password;
        }
        $sql .= ' WHERE `id` = :id LIMIT 1;';
        $this->connector->set($sql, (array)$data, $attributes);

        $sql = 'SELECT * FROM users WHERE `id` = :id  LIMIT 1;';
        return $this->validateUser($this->connector->get($sql, $data->id)[0] ?? []);
    }

    public function deleteUserById(int $id): void
    {
        $sql = 'UPDATE users SET `active` = 0 WHERE `id` = :id LIMIT 1';
        $this->connector->set($sql, ['id' => $id], ['id' => new PDOAttribute(':id', 'integer')]);
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

    private function validateUser(array $user): UserDataTransferObject
    {
        $user['active'] = (bool)$user['active'];
        return $this->mapper->mapToDto($user);
    }

    private function getLastInsert(): array
    {
        $sql = 'SELECT * FROM users WHERE `id` = LAST_INSERT_ID()';
        return $this->connector->get($sql)[0] ?? [];
    }
}