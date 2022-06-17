<?php declare(strict_types=1);

namespace Shop\Model;

class Category implements Data
{
    private int $id = 0;
    private string $name = '';

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
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
}