<?php declare(strict_types=1);

namespace Shop\Model\Dto;

class CategoryDataTransferObject
{
    public readonly int $id;
    public readonly string $name;
    public readonly bool $active;

    public function __construct(int $id, string $name, bool $active)
    {
        $this->id = $id;
        $this->name = $name;
        $this->active = $active;
    }
}