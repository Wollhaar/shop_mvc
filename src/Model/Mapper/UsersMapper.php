<?php
declare(strict_types=1);

namespace Shop\Model\Mapper;

use Shop\Model\Dto\UserDataTransferObject;

class UsersMapper
{
    public function mapToDto(array $data): UserDataTransferObject
    {
        return new UserDataTransferObject(
            $data['id'] ?? 0,
            $data['username'] ?? '',
            $data['firstname'] ?? 'none',
            $data['lastname'] ?? 'none',
            $data['created'] ?? 0,
            $data['updated'] ?? 0,
            $data['birthday'] ?? 0,
            $data['active'] ?? false,
        );
    }
}