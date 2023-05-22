<?php

declare(strict_types=1);

namespace Arqmedes\Core\Database;

use PDO;
use PDOException;

class MySQLDatabase implements DatabaseInterface
{
    protected static $db;

    private function __construct()
    {

        try {
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            self::$db = new PDO(
                DB_CONNECT['DB_DRIVER'] . ':host=' . DB_CONNECT['DB_HOST'] . ';dbname=' . DB_CONNECT['DB_NAME'],
                DB_CONNECT['DB_USER'],
                DB_CONNECT['DB_PASSWORD'],
                $options
            );
        } catch (PDOException $e) {
            echo "MySql Connection Error: " . $e->getMessage();
        }
    }

    public static function connect(): PDO
    {
        if (!self::$db) {
            new MySQLDatabase();
        }

        return self::$db;
    }
}
