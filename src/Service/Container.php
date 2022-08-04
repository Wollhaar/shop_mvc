<?php declare(strict_types=1);

namespace Shop\Service;

class Container
{
    private array $storage = [];

    public function set(string $classname, object $object): void
    {
        $this->storage[$classname] = $object;
    }

    public function get(string $classname)
    {
        return $this->storage[$classname];
    }
}