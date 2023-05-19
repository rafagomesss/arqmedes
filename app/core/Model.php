<?php

declare(strict_types=1);

namespace Arqmedes\Core;

use PDO;
use PDOStatement;

class Model
{
    protected $connection;

    private function bind($sql, $data): PDOStatement
    {
        $statement = $this->connection->prepare($sql);
        foreach ($data as $key => $value) {
            $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $statement->bindValue(":$key", $value, $type);
        }
        return $statement;
    }

    public function create(array|object $data)
    {
        $fields = implode(",", array_keys((array) $data));
        $placeholders = ":" . implode(", :", array_keys((array) $data));
        $sql = "INSERT INTO tabela ($fields) VALUES ($placeholders)";

        $statement = $this->bind($sql, $data);
        $statement->execute();
        return $this->connection->lastInsertId();
    }
}
