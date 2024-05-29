<?php

namespace Flow\Workflow\Microservices\Edocument\Storage;

use Flow\Core\Database;
use Flow\Core\Enums\ServicesEnum;
use Flow\Workflow\Storage\Migrations\Migration;
use VladViolentiy\VivaFramework\Databases\Migrations\MysqliMigration;
use VladViolentiy\VivaFramework\Databases\Mysqli;

class Storage extends Mysqli
{
    public function __construct()
    {
        $connection = Database::createConnection(ServicesEnum::Workflow_edocument);
        $this->setDb($connection);
        Mysqli::checkMigration(new MysqliMigration($connection), Migration::$list);
    }

}