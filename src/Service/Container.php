<?php declare(strict_types=1);

namespace Shop\Service;

class Container
{
    private array $storage = [];

    public function set(string $classname, object $object): void
    {
        $this->storage[$classname] = $object;
    }

    public function get(string $classname): object
    {
        if (isset($this->storage[$classname])) {
            return $this->storage[$classname];
        }
        $this->set($classname, new $classname());

        return $this->storage[$classname];
    }
}