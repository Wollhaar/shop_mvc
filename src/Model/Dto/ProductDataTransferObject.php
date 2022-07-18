<?php
declare(strict_types=1);

namespace Shop\Model\Dto;

class ProductDataTransferObject
{
    public readonly int $id;
    public readonly string $name;
    public readonly string $size;
    public readonly string $category;
    public readonly float $price;
    public readonly int $amount;
    public readonly bool $active;

    public function __construct(int $id, string $name, string $size, string $category, float $price, int $amount, bool $active)
    {
        $this->id = $id;
        $this->name = $name;
        $this->size = $size;
        $this->category = $category;
        $this->price = $price;
        $this->amount = $amount;
        $this->active = $active;
    }
}