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
    private array $users;

    public function __construct(UsersMapper $mapper, SQLConnector $connector)
    {
        $this->mapper = $mapper;
        $this->connector = $connector;
    }

    public function findUserById(int $id): UserDataTransferObject
    {
        $sql = 'SELECT * FROM users WHERE `id` = :id AND `active` = 1;';
        $user = $this->connector->get($sql, $id)[0] ?? [];
        return $this->validateUser((array)$user);
    }

    public function findUserByUsername(string $name): UserDataTransferObject
    {
        $sql = 'SELECT * FROM users WHERE `username` = :username AND `active` = 1';
        $user = $this->connector->getByString($sql, $name, ':username')[0] ?? [];

        return $this->validateUser($user);
    }

    public function addUser(array $data): UserDataTransferObject
    {
        $data['id'] = count($this->users);

        $data['created'] = time();
        $data['updated'] = $data['created'];

        $birthday = strtotime($data['birthday'] ?? '');
        $birthday = is_int($birthday) ? $birthday : mktime(0);
        $data['birthday'] = $birthday;

        $data['active'] = true;

        $this->users[$data['id']] = $data;
        $this->write();

        return $this->mapper->mapToDto($data);
    }

    public function saveUser(UserDataTransferObject $data, string $password): UserDataTransferObject
    {
        $sql = 'UPDATE users SET 
                 `username` = :username, 
                 `firstname` = :firstname, 
                 `lastname` = :lastname, 
                 `created` = :created, 
                 `updated` = :updated, 
                 `birthday` = :birthday,
                 `active` = :active 
                 ';
        $data = (array)$data;
        $attributes = array_flip(array_keys($data));

        foreach ($attributes as $key => $value) {
            $attributes[$key] = new PDOAttribute(':' . $key, gettype($data[$key]));
        }

        if ($password !== '') {
            $sql .= ', `password` = :password';
            $attributes['password'] = new PDOAttribute(':password', 'string'); //TODO: resolve dependencies (object necessary?)
        }
        $sql .= ' WHERE `id` = :id LIMIT 1;';

        $this->connector->set($sql, $data, $attributes);
        return $this->mapper->mapToDto($this->connector->get($sql, $data['id']));
    }

    public function deleteUserById(int $id): void
    {
        $sql = 'UPDATE users SET `active` = 0 WHERE `id` = :id LIMIT 1';
        $this->connector->set($sql, [$id], ['key'=>':id','type'=>\PDO::PARAM_INT]);
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
            $userList[] = $this->mapper->mapToDto($user);
        }
        return $userList;
    }

    private function validateUser(array $user): UserDataTransferObject
    {
        $user['created'] = strtotime($user['created']);
        $user['updated'] = strtotime($user['updated']);
        $user['birthday'] = strtotime($user['birthday']);
        $user['active'] = (bool)$user['active'];

        return $this->mapper->mapToDto($user);
    }
}