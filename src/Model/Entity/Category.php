<?php
declare(strict_types=1);

namespace Shop\Model\Entity;

class Category
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var bool
     */
    private bool $active;
}