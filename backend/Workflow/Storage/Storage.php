<?php

namespace Flow\Workflow\Storage;

use Flow\Core\Database;
use Flow\Core\Enums\ServicesEnum;
use Flow\Workflow\Storage\Migrations\Migration;
use VladViolentiy\VivaFramework\Databases\Migrations\MysqliMigration;
use VladViolentiy\VivaFramework\Databases\Mysqli;
use VladViolentiy\VivaFramework\Exceptions\DatabaseException;

class Storage extends Mysqli implements StorageInterface
{
    public function __construct(){
        $connection = Database::createConnection(ServicesEnum::Workflow);
        $this->setDb($connection);
        Mysqli::checkMigration(new MysqliMigration($connection),Migration::$list);
    }

    /**
     * @param positive-int $userId
     * @return list<array{name:non-empty-string,genericId:non-empty-string,iv:non-empty-string,salt:non-empty-string,encryptionKey:non-empty-string}>
     * @throws DatabaseException
     */
    public function getOrgForUser(int $userId):array{
        /** @var list<array{name:non-empty-string,genericId:non-empty-string,iv:non-empty-string,salt:non-empty-string,encryptionKey:non-empty-string}> $i */
        $i = $this->executeQuery("SELECT name,genericId,iv,salt,encryptionKey
FROM organizationsUsers 
    JOIN flow_workflow.organizations o on o.id = organizationsUsers.organizationId 
WHERE userId=?","i",[$userId])->fetch_all(MYSQLI_ASSOC);
        return $i;
    }
}