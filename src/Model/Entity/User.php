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
    private int $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $username;

    /**
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @ORM\Column(type="string")
     */
    private string $firstname;

    /**
     * @ORM\Column(type="string")
     */
    private string $lastname;

    /**
     * @ORM\Column(type="string")
     */
    private string $created;

    /**
     * @ORM\Column(type="string")
     */
    private string $updated;

    /**
     * @ORM\Column(type="string")
     */
    private string $birthday;

    /**
     * @ORM\Column(type="integer")
     */
    private bool $active;
}