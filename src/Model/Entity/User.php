<?php
declare(strict_types=1);

namespace Shop\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    public int $id;

     /**
      * @ORM\Column(type="string", nullable=true)
      */
    public string $username;

    /**
     * @ORM\Column(type="string")
     */
    public string $passwordHash;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public string $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public string $firstname;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public string $lastname;

    /**
     * @ORM\Column(type="datetime")
     */
    public $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $updated;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $birthday;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public $role;

    /**
     * @ORM\Column(type="boolean")
     */
    public bool $active;
}