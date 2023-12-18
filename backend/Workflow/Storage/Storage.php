<?php

namespace Flow\Workflow\Storage;

use Flow\Core\Database;
use Flow\Core\Enums\ServicesEnum;
use VladViolentiy\VivaFramework\Databases\Mysqli;

class Storage extends Mysqli implements StorageInterface
{
    public function __construct(){
        $this->setDb(Database::createConnection(ServicesEnum::Workflow));
    }
}