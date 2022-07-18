<?php declare(strict_types=1);

namespace Shop\Model\Dto;

class CategoryDataTransferObject
{
    public readonly int $id;
    public readonly string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}