<?php

namespace Flow\Workflow\Microservices\Edocument\Storage;

use Flow\Core\Database;
use Flow\Core\Enums\ServicesEnum;
use VladViolentiy\VivaFramework\Databases\Mysqli;

class Storage extends Mysqli
{
    public function __construct(){
        $this->setDb(Database::createConnection(ServicesEnum::Workflow_edocument));
    }

}