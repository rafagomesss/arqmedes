<?php

declare(strict_types=1);

namespace Arqmedes\Core;

use Arqmedes\Core\Database\MySQLDatabase;
use PDO;
use PDOStatement;
use stdClass;

class Model
{
    protected $connection;
    protected $table;

    public function __construct()
    {
        $this->connection = MySQLDatabase::connect();
    }

    protected function bind($sql, $data): PDOStatement
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
        $sql = "INSERT INTO $this->table ($fields) VALUES ($placeholders)";

        $statement = $this->bind($sql, $data);
        $statement->execute();
        $lastInsertedId = intval($this->connection->lastInsertId());
        return $this->find($lastInsertedId);
    }

    public function all()
    {
        return $this->connection->query("SELECT * FROM $this->table")->fetchAll();
    }

    public function where(array $conditions)
    {
        $whereConditions = [];
        foreach ($conditions as $field => $value) {
            $whereConditions[] = "$field = :$field";
        }
        $whereClause = implode(" AND ", $whereConditions);
        $sql = "SELECT * FROM $this->table WHERE $whereClause";

        $statement = $this->bind($sql, $conditions);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function join(string $table, array $conditions, string $type = 'INNER')
    {
        $joinType = strtoupper($type) . ' JOIN';
        $joinConditions = [];
        $parameters = [];

        foreach ($conditions as $field1 => $field2) {
            $joinConditions[] = "$field1 = $field2";
        }

        $joinClause = implode(" AND ", $joinConditions);
        $sql = "SELECT * FROM $this->table $joinType $table ON $joinClause";

        $statement = $this->connection->prepare($sql);
        $statement->execute($parameters);

        return $statement->fetchAll();
    }

    public function find(int $id): ?stdClass
    {
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $statement = $this->bind($sql, ['id' => $id]);
        $statement->execute();
        if ($statement->rowCount() > 0) {
            return $statement->fetch();
        }
        return null;
    }
}
