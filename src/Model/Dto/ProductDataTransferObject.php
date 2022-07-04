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

    public function __construct(int $id = 0, string $name = 'none', string $size = 'none', string $category = 'none', float $price = 0.0, int $amount = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->size = $size;
        $this->category = $category;
        $this->price = $price;
        $this->amount = $amount;
    }
}