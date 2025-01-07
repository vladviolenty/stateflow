<?php

namespace Flow\Core;

use Flow\Core\Enums\ServicesEnum;

abstract class Database
{
    public static function createConnection(ServicesEnum $database): \mysqli
    {
        $user = (string) getenv('DB_' . $database->value . '_USER');
        $password = (string) getenv('DB_' . $database->value . '_PASSWORD');
        $db = (string) getenv('DB_' . $database->value . '_DATABASE');
        $server = (string) getenv('DB_' . $database->value . '_SERVER');

        return new \mysqli($server, $user, $password, $db);
    }
}
