<?php
declare(strict_types=1);

namespace Shop\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="products")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    public int $id;

    /**
     * @ORM\Column(type="string")
     */
    public string $name;

    /**
     * @ORM\Column(type="string")
     */
    public string $size;

    /**
     * @ORM\Column(type="string")
     */
    public string $color;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     */
    public $category;

    /**
     * @ORM\Column(type="float")
     */
    public $price;

    /**
     * @ORM\Column(type="integer")
     */
    public int $amount;

    /**
     * @ORM\Column(type="boolean")
     */
    public bool $active;

    public function setCategory(Category $category): void
    {
        $category->assignedProducts($this);
        $this->category = $category;
    }
}