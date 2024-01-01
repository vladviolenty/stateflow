<?php

namespace Flow\Workflow\Storage;

use Ramsey\Uuid\UuidInterface;
use VladViolentiy\VivaFramework\Exceptions\DatabaseException;

interface StorageInterface
{
    /**
     * @param positive-int $userId
     * @return list<array{name:non-empty-string,genericId:non-empty-string,iv:non-empty-string,salt:non-empty-string,encryptionKey:non-empty-string,uuid:non-empty-string}>
     * @throws DatabaseException
     */
    public function getOrgForUser(int $userId):array;

    /**
     * @param UuidInterface $uuid
     * @param non-empty-string $name
     * @param non-empty-string $genericId
     * @param bool $publicFLName
     * @param non-empty-string $iv
     * @param non-empty-string $salt
     * @param non-empty-string $encryptedCreatedAt
     * @return positive-int
     */
    public function insertNewOrganization(UuidInterface $uuid,string $name, string $genericId, bool $publicFLName, string $iv, string $salt, string $encryptedCreatedAt):int;

    /**
     * @param positive-int $orgId
     * @param non-empty-string $encryptedPrivateKey
     * @param non-empty-string $publicKey
     * @param non-empty-string $type
     * @return void
     */
    public function insertEncryptInfo(int $orgId, string $encryptedPrivateKey, string $publicKey, string $type):void;

    /**
     * @param positive-int $orgId
     * @param positive-int $userId
     * @param bool $isMainUser
     * @param non-empty-string $encryptedKey
     * @param non-empty-string|null $encryptedFLName
     * @return void
     */
    public function insertUserInOrganization(int $orgId, int $userId, bool $isMainUser, string $encryptedKey, ?string $encryptedFLName):void;
}