<?php declare(strict_types=1);

namespace Shop\Model;

use Shop\Controller\ErrorController;

class Category implements Data
{
    private int $id = 0;

    private string $name = '';


    public function __construct(int $id = 0, string $name = 'All')
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

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}