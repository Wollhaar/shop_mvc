<?php
declare(strict_types=1);

namespace Shop\Service;

use const http\Client\Curl\Versions\IDN;

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

    public function getByString(string $query, string $str, string $attr): array
    {
        $stmt = $this->connector->prepare($query);
        $stmt->bindParam($attr, $str);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function set(string $query, array $properties, array $attributes): void
    {
        $stmt = $this->connector->prepare($query);
        foreach ($attributes as $key => $attr) {
//            var_dump($properties[$key], $attr);
            $stmt->bindParam($attr['key'], $properties[$key], $attr['type']);
        }
//        $stmt->debugDumpParams();
        $stmt->execute();
    }
}