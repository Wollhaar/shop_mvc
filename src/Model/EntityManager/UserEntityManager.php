<?php
declare(strict_types=1);

namespace Shop\Model\EntityManager;

use Shop\Model\Dto\UserDataTransferObject;
use Shop\Service\SQLConnector;

class UserEntityManager
{
    private const PDO_ATTRIBUTE_TYPES = [
        'integer' => \PDO::PARAM_INT,
        'string' => \PDO::PARAM_STR,
        'double' => \PDO::PARAM_STR,
    ];

    private SQLConnector $connector;

    public function __construct(SQLConnector $connector)
    {
        $this->connector = $connector;
    }

    public function addUser(UserDataTransferObject $data, string $password): void
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
    }

    public function saveUser(UserDataTransferObject $data, string $password): void
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
    }

    public function deleteUserById(int $id): void
    {
        $sql = 'UPDATE users SET `active` = 0 WHERE `id` = :id LIMIT 1';
        $this->connector->set($sql, ['id' => $id], ['id' => ['key' => ':id', 'type' => self::PDO_ATTRIBUTE_TYPES['integer']]]);
    }

}