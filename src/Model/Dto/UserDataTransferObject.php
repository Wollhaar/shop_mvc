<?php
declare(strict_types=1);

namespace Shop\Model\Dto;

class UserDataTransferObject
{
    public function __construct(
        public readonly int $id,
        public readonly string $username,
        public readonly string $firstname,
        public readonly string $lastname,
        public readonly string $created,
        public readonly string $updated,
        public readonly string $birthday,
        public readonly bool $active
    )
    {
    }
}