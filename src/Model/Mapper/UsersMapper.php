<?php
declare(strict_types=1);

namespace Shop\Model\Mapper;

use Shop\Model\Dto\UserDataTransferObject;

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

    public function mapEntityToDto(array $data): UserDataTransferObject
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
}