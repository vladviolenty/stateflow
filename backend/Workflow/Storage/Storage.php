<?php

namespace Flow\Workflow\Storage;

use Flow\Core\Database;
use Flow\Core\Enums\ServicesEnum;
use Flow\Workflow\Storage\Migrations\Migration;
use Ramsey\Uuid\UuidInterface;
use VladViolentiy\VivaFramework\Databases\Migrations\MysqliMigration;
use VladViolentiy\VivaFramework\Databases\Mysqli;
use VladViolentiy\VivaFramework\Exceptions\DatabaseException;

class Storage extends Mysqli implements StorageInterface
{
    public function __construct()
    {
        $connection = Database::createConnection(ServicesEnum::Workflow);
        $this->setDb($connection);
        Mysqli::checkMigration(new MysqliMigration($connection), Migration::$list);
    }

    public function getOrgForUser(int $userId): array
    {
        /** @var list<array{name:non-empty-string,genericId:non-empty-string,iv:non-empty-string,salt:non-empty-string,encryptionKey:non-empty-string}> $i */
        $i = $this->executeQuery("SELECT name,genericId,iv,salt,encryptionKey,hex(uuid) as uuid
FROM organizationsUsers 
    JOIN organizations o on o.id = organizationsUsers.organizationId 
WHERE userId=?", "i", [$userId])->fetch_all(MYSQLI_ASSOC);
        return $i;
    }

    public function insertNewOrganization(UuidInterface $uuid, string $name, string $genericId, bool $publicFLName, string $iv, string $salt, string $encryptedCreatedAt): int
    {
        $this->executeQueryBool("INSERT INTO organizations(uuid,genericId, name, iv, salt, publicFLNames, createdAt) VALUES (unhex(?),?,?,?,?,?,?)", "sssssis", [bin2hex($uuid->getBytes()), $genericId, $name, $iv, $salt, (int)$publicFLName, $encryptedCreatedAt]);
        /** @var positive-int $id */
        $id = $this->insertId();
        return $id;
    }

    public function insertEncryptInfo(int $orgId, string $encryptedPrivateKey, string $publicKey, string $type): void
    {
        $this->executeQueryBool("INSERT INTO organizationsEncryptInfo(organizationId, encryptedPrivateKey, publicKey, type) VALUES (?,?,?,?)", "isss", [$orgId, $encryptedPrivateKey, $publicKey, $type]);
    }

    public function insertUserInOrganization(int $orgId, int $userId, bool $isMainUser, string $encryptedKey, ?string $encryptedFLName): void
    {
        $this->executeQueryBool("INSERT INTO organizationsUsers(organizationId, userId, isMainUser, encryptionKey, encryptedFLName) VALUES (?,?,?,?,?)", "iiiss", [$orgId, $userId, (int)$isMainUser, $encryptedKey, $encryptedFLName]);
    }
}
