<?php
declare(strict_types=1);

namespace Shop\Model\Dto;

class UserDataTransferObject
{
    public readonly int $id;
    public readonly string $username;
    public readonly string $firstname;
    public readonly string $lastname;
    public readonly int $created;
    public readonly int $updated;
    public readonly int $birthday;
    public readonly bool $active;

    public function __construct(
        int $id,
        string $username,
        string $firstname,
        string $lastname,
        int $created,
        int $updated,
        int $birthday,
        bool $active
    )
    {
        $this->id = $id;
        $this->username = $username;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->created = $created;
        $this->updated = $updated;
        $this->birthday = $birthday;
        $this->active = $active;
    }
}