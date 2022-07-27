<?php
declare(strict_types=1);

namespace Shop\Service;

class SQLConnector
{
    private const HOST = '127.0.0.1';
    private const USER = 'root';
    private const PASSWORD = 'pass123';
    private const DATABASE = 'shop';
    private const PORT = 3306;

    private \PDO $connector;

    public function __construct()
    {
        $dsn = 'mysql:host=' . self::HOST . ';dbname=' . self::DATABASE . ';port=' . self::PORT . ';charset=UTF8';
        $this->connector = new \PDO(
            $dsn,
            self::USER,
            self::PASSWORD
        );
    }

    public function __destruct()
    {
        unset($this->connector);
    }

    public function get(string $query, int $id = 0): array
    {
        $stmt = $this->connector->prepare($query);

        if ($id) {
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function set(string $query, array $properties, array $attributes): void
    {
        var_dump($properties);
        $stmt = $this->connector->prepare($query);

        foreach ($properties as $key => $property) {
            $stmt->bindParam($attributes[$key]['key'], $property, $attributes[$key]['type']);
        }
        $stmt->execute();
    }

    public function update(string $query, string $type, int $id): void
    {
        $stmt = $this->connector->prepare($query);
        $stmt->bind_param($type, $id);
        $stmt->execute();
    }

    public function delete(string $query, string $type, int $id): void
    {
        $stmt = $this->connector->prepare($query);
        $stmt->bind_param($type, $id);
        $stmt->execute();
    }
}