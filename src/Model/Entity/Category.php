<?php
declare(strict_types=1);

namespace Shop\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="categories")
 */
class Category
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
     * @ORM\Column(type="boolean")
     */
    public bool $active;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="category_id")
     * @var Product[] An ArrayCollection of Product objects.
     */
    public $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function assignedProducts(Product $product): void
    {
        $this->products[] = $product;
    }
}