<?php
declare(strict_types=1);

namespace Shop;

class Calculator
{
    public function add(array $operands): int
    {
        return array_sum($operands);
    }
}