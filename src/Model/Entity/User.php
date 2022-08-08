<?php
declare(strict_types=1);

namespace Shop\Model\Entity;

class User
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $username;

    /**
     * @var string
     */
    private string $password;

    /**
     * @var string
     */
    private string $firstname;

    /**
     * @var string
     */
    private string $lastname;

    /**
     * @var string
     */
    private string $created;

    /**
     * @var string
     */
    private string $updated;

    /**
     * @var string
     */
    private string $birthday;

    /**
     * @var bool
     */
    private bool $active;
}