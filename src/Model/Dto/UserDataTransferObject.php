<?php
declare(strict_types=1);

namespace Shop\Model\Dto;

class UserDataTransferObject
{
    public readonly int $id;
    public readonly string $username;
    public readonly string $firstname;
    public readonly string $lastname;
    public readonly string $created;
    public readonly string $updated;
    public readonly string $birthday;
    public readonly bool $active;

    public function __construct(
        int $id,
        string $username,
        string $firstname,
        string $lastname,
        string $created,
        string $updated,
        string $birthday,
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