<?php

namespace App\core;

use PDO;
use PDOException;

class Database
{
    private static $host;
    private static $name;
    private static $user;
    private static $pass;

    private $table;
    private $connection;

    public static function config($host, $name, $user, $pass)
    {
        self::$host = $host;
        self::$name = $name;
        self::$user = $user;
        self::$pass = $pass;
    }

    public function __construct($table = null)
    {
        $this->table = $table;
        $this->setConnection();
    }

    private function setConnection()
    {
        try {
            $this->connection = new PDO("sqlsrv:Server=".self::$host.";Database=".self::$name.";ConnectionPooling=0", self::$user, self::$pass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die('ERROR: '.$e->getMessage());
        }
    }

    public function execute($query, $params = [])
    {
        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        } catch(PDOException $e) {
            die('ERROR: '.$e->getMessage());
        }
    }

    public function insert($values)
    {
        $fields = array_keys($values);
        $binds = array_pad([], count($fields), '?');

        $query = 'INSERT INTO '.$this->table.' ('.implode(',', $fields).') VALUES ('.implode(',', $binds).')';

        $this->execute($query, array_values($values));

        return $this->connection->lastInsertId();
    }

    public function select($where = null, $order = null, $limit = null, $fields = '*')
    {
        $where = strlen($where) ? "WHERE ".$where : "";
        $limit = strlen($limit) ? "OFFSET ".$limit : "";
        $order = strlen($order) ? "ORDER BY ".$order : "";

        $query = "SELECT ".$fields." FROM ".$this->table." ".$where." ".$order." ".$limit;

        return $this->execute($query);
    }
}