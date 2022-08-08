<?php
declare(strict_types=1);

namespace Shop\Model\Entity;

class Product
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
     * @var string
     */
    private string $size;

    /**
     * @var string
     */
    private string $color;

    /**
     * @var string
     */
    private string $category;

    /**
     * @var float
     */
    private float $price;

    /**
     * @var int
     */
    private int $amount;

    /**
     * @var bool
     */
    private bool $active;
}