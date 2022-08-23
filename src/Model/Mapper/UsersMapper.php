<?php
declare(strict_types=1);

namespace Shop\Model\Mapper;

use Shop\Model\Dto\UserDataTransferObject;
use Shop\Model\Entity\User;

class UsersMapper
{
    public function mapToDto(array $data): UserDataTransferObject
    {
        return new UserDataTransferObject(
            $data['id'],
            $data['username'],
            $data['passwordHash'],
            $data['firstname'],
            $data['lastname'],
            $data['created'],
            $data['updated'],
            $data['birthday'],
            $data['role'],
            $data['active'],
        );
    }

    public function mapEntityToDto(User $data): UserDataTransferObject
    {
        return new UserDataTransferObject(
            $data->id,
            $data->username,
            $data->passwordHash,
            $data->firstname,
            $data->lastname,
            $this->validateTime($data->created),
            $this->validateTime($data->updated),
            $this->validateTime($data->birthday),
            $data->role,
            $data->active,
        );
    }

    private function validateTime(?\DateTime $date): string
    {
        if (is_object($date)) {
            return $date->format('Y-m-d h:i:s');
        }
        return '';
    }
}