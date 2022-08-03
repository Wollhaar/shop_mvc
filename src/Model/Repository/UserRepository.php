<?php
declare(strict_types=1);

namespace Shop\Model\Repository;

use Shop\Model\Dto\UserDataTransferObject;
use Shop\Model\Mapper\UsersMapper;
use Shop\Model\PDOAttribute;
use Shop\Service\SQLConnector;

class UserRepository
{
    private const PDO_ATTRIBUTE_TYPES = [
        'integer' => \PDO::PARAM_INT,
        'string' => \PDO::PARAM_STR,
        'double' => \PDO::PARAM_STR,
    ];

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
            'username' => ['key' => ':username', 'type' => self::PDO_ATTRIBUTE_TYPES[gettype($data->username)]],
            'password' => ['key' => ':password', 'type' => self::PDO_ATTRIBUTE_TYPES[gettype($data->password)]],
            'firstname' => ['key' => ':firstname', 'type' => self::PDO_ATTRIBUTE_TYPES[gettype($data->firstname)]],
            'lastname' => ['key' => ':lastname', 'type' => self::PDO_ATTRIBUTE_TYPES[gettype($data->lastname)]],
            'birthday' => ['key' => ':birthday', 'type' => self::PDO_ATTRIBUTE_TYPES[gettype($data->birthday)]],
        ];

        $this->connector->set($sql, (array)$data, $attributes);
        return $this->validateUser($this->getLastInsert());
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
            'id' => ['key' => ':id', 'type' => self::PDO_ATTRIBUTE_TYPES[gettype($data->id)]],
            'username' => ['key' => ':username', 'type' => self::PDO_ATTRIBUTE_TYPES[gettype($data->username)]],
            'firstname' => ['key' => ':firstname', 'type' => self::PDO_ATTRIBUTE_TYPES[gettype($data->firstname)]],
            'lastname' => ['key' => ':lastname', 'type' => self::PDO_ATTRIBUTE_TYPES[gettype($data->lastname)]],
            'updated' => ['key' => ':updated', 'type' => self::PDO_ATTRIBUTE_TYPES[gettype($data->updated)]],
            'birthday' => ['key' => ':birthday', 'type' => self::PDO_ATTRIBUTE_TYPES[gettype($data->birthday)]],
        ];

        if ($password !== '') {
            $sql .= ', `password` = :password';
            $attributes['password'] = ['key' => ':password', 'type' => self::PDO_ATTRIBUTE_TYPES['string']];
            $data->password = $password;
        }
        $sql .= ' WHERE `id` = :id LIMIT 1;';

        $this->connector->set($sql, (array)$data, $attributes);
        return $this->findUserById($data->id);
    }

    public function deleteUserById(int $id): void
    {
        $sql = 'UPDATE users SET `active` = 0 WHERE `id` = :id LIMIT 1';
        $this->connector->set($sql, ['id' => $id], ['id' => ['key' => ':id', 'type' => self::PDO_ATTRIBUTE_TYPES['integer']]]);
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
        if (!empty($user)) {
            $user['id'] = (int)$user['id'];
            $user['active'] = (bool)$user['active'];
        }
        return $this->mapper->mapToDto($user);
    }

    private function getLastInsert(): array
    {
        $sql = 'SELECT * FROM users WHERE `id` = LAST_INSERT_ID()';
        return $this->connector->get($sql)[0] ?? [];
    }
}