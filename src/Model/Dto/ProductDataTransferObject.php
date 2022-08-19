<?php
declare(strict_types=1);

namespace Shop\Model\Dto;

class ProductDataTransferObject
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $size,
        public readonly string $color,
        public readonly string $category,
        public readonly float $price,
        public readonly int $amount,
        public readonly bool $active)
    {
    }
}