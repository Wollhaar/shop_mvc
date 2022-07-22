<?php
declare(strict_types=1);

namespace Shop\Service;

class SQLConnector
{
    private const HOST = 'shop_mvc_default';
    private const USER = 'babo';
    private const PASSWORD = 'pass123';
    private const DATABASE = 'shop';
    private const PORT = 3306;

    private \mysqli $connector;

    public function __construct()
    {
        $this->connector = mysqli_connect(
            self::HOST,
            self::USER,
            self::PASSWORD,
            self::DATABASE,
            self::PORT
        );
    }

    public function __destruct()
    {
        mysqli_close($this->connector);
    }

    public function connect(): bool
    {
        return is_string(mysqli_stat($this->connector)) ? true : false;
    }

    public function get(string $entity, int $id = 0): array
    {
        $where = '';
        if ($id) {
            $where = ' WHERE id = ?;';
        }
        $sql = 'SELECT * FROM ' . $entity . $where;
        $stmt = $this->connector->prepare($sql);
        if ($id) {
            $stmt->bind_param('i', $id);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        $retArray = [];
        while ($row = $result->fetch_assoc()) {
            $retArray[] = $row;
        }
        return $retArray;
    }

    public function getBy(string $entity, string $from, string $reference, string $name): array
    {
        $sql = 'SELECT * FROM ? as t1 LEFT JOIN ? as t2 ON t1.? = t2.`id` WHERE t2.`name` = ?;';
        $stmt = $this->connector->prepare($sql);
        $amount = 4;
        $stmt->bind_param('ssss',
            $amount,
            $entity,
            $from,
            $referencem,
            $name
        );
        $stmt->execute();
        $result = $stmt->get_result();

        $retArray = [];
        while ($row = $result->fetch_assoc()) {
            $retArray[] = $row;
        }
        return $retArray;
    }

    public function set(string $entity, array $properties): void
    {
        $sql = 'INSERT INTO ?';
        $attr = ' (';
        $values = ' VALUES(';
        $types = 's';
        foreach ($properties as $key => $value) {
            if (is_string($value)) {
                $types .= 's';
            }
            elseif (is_int($value)) {
                $types .= 'i';
            }
            elseif (is_float($value)) {
                $types .= 'd';
            }
            $attr .= $key . ', ';
            $values .= '?, ';
        }
        $sql .= rtrim(', ', $attr) . ')';
        $sql .= rtrim(', ', $values) . ');';

        $amnt = array_unshift($properties, $entity);
        $stmt = $this->connector->prepare($sql);
        $stmt->bind_param($types, $amnt, $properties);
    }

    public function update(): void
    {

    }

    public function delete(): void
    {

    }
}