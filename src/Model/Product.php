<?php declare(strict_types=1);

namespace Shop\Model;

use Shop\Controller\ErrorController;

class Product implements Data
{
    private int $id = 0;
    private string $name = '';
    private string $size = '';
    private string $category = '';
    private float $price = 0.0;


    public function __construct(int $id = 0, string $name = 'none', string $size = 'none', string $category = 'none', float $price = 0.0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->size = $size;
        $this->category = $category;
        $this->price = $price;
   }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $size
     */
    public function setSize(string $size): void
    {
        $this->size = $size;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
}