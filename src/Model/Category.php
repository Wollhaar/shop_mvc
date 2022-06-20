<?php declare(strict_types=1);

namespace Shop\Model;

class Category implements Data
{
    private const CATEGORIES = [
        1 => ['id'=> 1,'name' => 'T-Shirt'],
        2 => ['id'=> 2,'name' => 'Pullover'],
        3 => ['id'=> 3,'name' => 'Hosen'],
        4 => ['id'=> 4,'name' => 'Sportswear'],
    ];

    private int $id = 0;
    private string $name = '';

    public function __construct(int $id = 0, string $name = '')
    {
        $this->id = $id;
        if ($id) {
            $this->name = self::CATEGORIES[$id]['name'] ?? $name;
        }
    }

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName():string
    {
        return $this->name;
    }

    public function summarize():array
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }

    public function getAll():array
    {
        return self::CATEGORIES;
    }
}