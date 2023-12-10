<?php

namespace Flow\Id\Controller;

use Flow\Core\Database;
use Flow\Core\Enums\ServicesEnum;
use Flow\Id\Storage\Migrations\Migration;
use Flow\Id\Storage\StorageInterface;
use VladViolentiy\VivaFramework\Databases\Migrations\MysqliMigration;
use VladViolentiy\VivaFramework\Databases\Mysqli;

class Base
{
    protected readonly StorageInterface $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
        Mysqli::checkMigration(new MysqliMigration(Database::createConnection(ServicesEnum::Id)),Migration::$list);
    }
}