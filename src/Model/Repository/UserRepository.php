<?php
declare(strict_types=1);

namespace Shop\Model\Repository;

use Shop\Model\Dto\UserDataTransferObject;
use Shop\Model\Mapper\UsersMapper;

class UserRepository
{
    private UsersMapper $mapper;
    private array $users;

    public function __construct(UsersMapper $mapper)
    {
        $data = file_get_contents(__DIR__ . '/users.json');
        $this->users = json_decode($data, true);

        $this->mapper = $mapper;
    }

    public function findUserById(int $id): UserDataTransferObject
    {
        $userData = [];
        foreach ($this->users as $user) {
            if ($user['id'] === $id) {
                $userData = $user;
            }
        }
        return $this->mapper->mapToDto($userData);
    }

    public function findUserByUsername(string $name): UserDataTransferObject
    {
        foreach ($this->users as $user) {
            if ($user['active'] && $user['username'] === $name) {
                $userData = $user;
                break;
            }
        }
        return $this->mapper->mapToDto($userData ?? []);
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

    public function saveUser(array $data): UserDataTransferObject
    {
        $data['id'] = (int)$data['id'];
        $user = $this->findUserById($data['id']);
        $data['password'] = $data['password'] !== '' ?
            $data['password'] : $this->getPasswordByUser($user);

        $created = strtotime($data['created']);
        $created = is_int($created) ? $created : mktime(0);
        $data['created'] = $created;

        $data['updated'] = time();

        $birthday = strtotime($data['birthday']);
        $birthday = is_int($birthday) ? $birthday : mktime(0);
        $data['birthday'] = $birthday;
        $data['active'] = (bool)$data['active'];


        $this->users[$data['id']] = $data;
        $this->write();

        return $this->mapper->mapToDto($data);
    }

    public function deleteUserById(int $id): void
    {
        $this->users[$id]['active'] = false;
        $this->write();
    }

    public function getPasswordByUser(UserDataTransferObject $user): string
    {
        foreach ($this->users as $userData) {
            if ($userData['id'] === $user->id) {
                return $userData['password'] ?? '';
            }
        }
        return '';
    }

    public function getAll(): array
    {
        $users = $this->users ?? [];
        foreach ($users as $user) {
            if (!$user['active']) {
                unset($users[$user['id']]);
                continue;
            }
            $users[$user['id']] = $this->mapper->mapToDto($user);
        }
        return $users;
    }

    private function write(): void
    {
        $data = json_encode($this->users);
        file_put_contents(__DIR__ . '/users.json', $data);
    }
}