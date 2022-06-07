<?php declare(strict_types=1);

namespace Model\Shop;

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

    public function summarize():string
    {
        return 'ID:' . $this->id . ';Kategorie: ' . $this->name;
    }
}