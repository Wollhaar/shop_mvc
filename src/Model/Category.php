<?php declare(strict_types=1);

namespace Model;

class Category
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
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