<?php

namespace Flow\Id\Storage;

use Flow\Core\Database;
use Flow\Core\Interfaces\DatabaseInitInterface;
use Flow\Id\Storage\Migrations\Migration;
use VladViolentiy\VivaFramework\Databases\Mysqli;

class Init extends Mysqli implements DatabaseInitInterface
{
    public function initDatabase(\mysqli $db):void{
        $this->setDb($db);
        $this->takeMigrations(Migration::$list);
    }
}