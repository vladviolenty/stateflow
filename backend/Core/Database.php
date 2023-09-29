<?php

namespace Flow\Core;

use Flow\Core\Enums\ServicesEnum;

abstract class Database
{
    public static function createConnection(ServicesEnum $database):\mysqli{
        $user = $_ENV['DB_'.$database->value."_USER"];
        $password = $_ENV['DB_'.$database->value."_PASSWORD"];
        $db = $_ENV['DB_'.$database->value."_DATABASE"];
        $server = $_ENV['DB_'.$database->value."_SERVER"];
        return new \mysqli($server,$user,$password,$db);
    }
}