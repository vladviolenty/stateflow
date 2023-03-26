<?php

namespace Flow\Core;

use Flow\Core\Enums\ServicesEnum;
use Flow\Core\Exceptions\DatabaseException;

abstract class Database
{
    private \mysqli $db;

    public static function createConnection(ServicesEnum $database):\mysqli{
        $user = $_ENV['DB_'.$database->value."_USER"];
        $password = $_ENV['DB_'.$database->value."_PASSWORD"];
        $db = $_ENV['DB_'.$database->value."_DATABASE"];
        return new \mysqli("127.0.0.1",$user,$password,$db);
    }

    /**
     * @param \mysqli $db
     */
    public function setDb(\mysqli $db): void{
        $this->db = $db;
    }

    /**
     * @param string $query
     * @param string $types
     * @param array<int,string|int|float|null> $params
     * @return \mysqli_result<int,string|int|float|null>
     * @throws DatabaseException
     */
    protected function executeQuery(string $query, string $types, array $params):\mysqli_result{
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

    protected function prepare(string $query):\mysqli_stmt{
        $pdo = $this->db->prepare($query);
        if($pdo===false) throw new DatabaseException();
        return $pdo;
    }

    protected function insertId():int{
        return (int)$this->db->insert_id;
    }
}