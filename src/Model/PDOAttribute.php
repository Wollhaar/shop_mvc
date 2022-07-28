<?php
declare(strict_types=1);

namespace Shop\Model;

class PDOAttribute
{
    private const TYPES = [
        'integer' => \PDO::PARAM_INT,
        'string' => \PDO::PARAM_STR,
        'double' => \PDO::PARAM_STR,
    ];

    public readonly string $key;
    public readonly string $type;

    public function __construct(string $key, string $type)
    {
        $this->key = $key;
        $this->type = self::TYPES[$type];
    }
}