<?php declare(strict_types=1);

namespace Shop\Service;

use Doctrine\ORM\EntityManager;

class Container
{
    public static EntityManager $entityManager;
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