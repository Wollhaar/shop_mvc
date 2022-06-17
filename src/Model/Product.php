<?php declare(strict_types=1);

namespace Shop\Model;

class Product implements Data
{
    private int $id = 0;
    private string $name = '';
    private string $size = '';
    private string $category = '';
    private float $price = 0.0;

    public function __construct(int $id, string $name, string $size, string $category, float $price)
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
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @param string $size
     */
    public function setSize(string $size): void
    {
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function summarize():array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'size' => $this->size,
            'category' => $this->category,
            'price' => $this->price
        ];
    }
}