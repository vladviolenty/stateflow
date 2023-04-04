<?php

namespace Flow\Core;

use Flow\Core\Enums\ServicesEnum;
use Flow\Core\Exceptions\DatabaseException;

abstract class DatabaseMultireplica extends Database
{
    /**
     * @var array{server:string,login:string,password:string,database:string}
     */
    protected array $masterInfo;

    private bool $isMaster = false;
    /**
     * @return array{db:\mysqli,info:array{server:string,login:string,password:string,database:string}}
     */
    public static function initMultireplica(ServicesEnum $database):array{
        $user = $_ENV['DB_'.$database->value."_USER"];
        $password = $_ENV['DB_'.$database->value."_PASSWORD"];
        $db = $_ENV['DB_'.$database->value."_DATABASE"];

        $replicaLists = explode(",",$_ENV['DB_'.$database->value."_SLAVE"]);
        $server = $replicaLists[array_rand($replicaLists)];

        return [
            "db"=>new \mysqli($server,$user,$password,$db),
            "info"=>[
                "server"=>$_ENV['DB_'.$database->value."_MASTER"],
                "login"=>$user,
                "password"=>$password,
                "database"=>$db
            ]
        ];
    }

    protected function executeQueryBool(string $query, string $types, array $params):void{
        if(!$this->isMaster){
            $this->setDb(new \mysqli(
                $this->masterInfo['server'],
                $this->masterInfo['login'],
                $this->masterInfo['password'],
                $this->masterInfo['database'],
            ));
            $this->isMaster = true;
        }
        $prepare = $this->prepare($query);
        $prepare->bind_param($types,...$params);
        if($prepare->execute()===false) throw new DatabaseException();
    }
}