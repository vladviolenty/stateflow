<?php

namespace Flow\Core;

use Flow\Core\Enums\ServicesEnum;
use Flow\Core\Exceptions\DatabaseException;
use Flow\Core\Interfaces\MigrationInterface;

abstract class Database
{
    private \mysqli $db;

    public static function createConnection(ServicesEnum $database):\mysqli{
        $user = $_ENV['DB_'.$database->value."_USER"];
        $password = $_ENV['DB_'.$database->value."_PASSWORD"];
        $db = $_ENV['DB_'.$database->value."_DATABASE"];
        $server = $_ENV['DB_'.$database->value."_SERVER"];
        return new \mysqli($server,$user,$password,$db);
    }

    /**
     * @param \mysqli $db
     */
    final protected function setDb(\mysqli $db): void{
        $this->db = $db;
    }

    /**
     * @param string $query
     * @param string $types
     * @param array<int,string|int|float|null> $params
     * @return \mysqli_result<int,string|int|float|null>
     * @throws DatabaseException
     */
    final protected function executeQuery(string $query, string $types, array $params):\mysqli_result{
        $prepare = $this->prepare($query);
        $prepare->bind_param($types,...$params);
        $prepare->execute();
        $result = $prepare->get_result();
        if($result===false) throw new DatabaseException();
        return $result;
    }

    /**
     * @param string $query
     * @param string $types
     * @param array<int,string|int|float|null> $params
     * @throws DatabaseException
     */
    protected function executeQueryBool(string $query, string $types, array $params):void{
        $prepare = $this->prepare($query);
        $prepare->bind_param($types,...$params);
        if($prepare->execute()===false) throw new DatabaseException();
    }

    protected function executeQueryBoolRaw(string $query):void{
        $prepare = $this->prepare($query);
        if($prepare->execute()===false) throw new DatabaseException();
    }

    final protected function prepare(string $query):\mysqli_stmt{
        $pdo = $this->db->prepare($query);
        if($pdo===false) throw new DatabaseException();
        return $pdo;
    }

    final protected function insertId():int{
        return (int)$this->db->insert_id;
    }

    /**
     * @param class-string[] $migrations
     * @return void
     */
    final protected function takeMigrations(array $migrations):void{
        foreach ($migrations as $migration) {
            /** @var MigrationInterface $item */
            $item = new $migration($this->db);
            $item->init();
        }
    }
}