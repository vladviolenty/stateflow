<?php

namespace Flow\Id\Storage;

use Flow\Core\Exceptions\DatabaseException;
use Ramsey\Uuid\UuidInterface;

interface StorageInterface
{
    /**
     * @param string $hashedEmail
     * @return array{userId:int,salt:string,iv:string}|null
     * @throws DatabaseException
     */
    public function getUserByEmail(string $hashedEmail):?array;

    /**
     * @param string $hashedPhone
     * @return array{userId:int,salt:string,iv:string}|null
     * @throws DatabaseException
     */
    public function getUserByPhone(string $hashedPhone):?array;

    /**
     * @param UuidInterface $uuid
     * @return array{userId:int,salt:string,iv:string}|null
     * @throws DatabaseException
     */
    public function getUserByUUID(UuidInterface $uuid):?array;

    public function checkIssetUUID(string $uuid):bool;

    /**
     * @param UuidInterface $uuid
     * @param non-empty-string $password
     * @param non-empty-string $iv
     * @param non-empty-string $salt
     * @param non-empty-string $fNameEncrypted
     * @param non-empty-string $lNameEncrypted
     * @param non-empty-string $bDayEncrypted
     * @param non-empty-string $globalHash
     * @return int
     */
    public function addNewUser(UuidInterface $uuid, string $password, string $iv, string $salt, string $fNameEncrypted, string $lNameEncrypted, string $bDayEncrypted, string $globalHash): int;

    public function insertNewEncryptInfo(int $userId,string $publicKey,string $encryptedPrivateKey):void;

    /**
     * @param int $userId
     * @return non-empty-string|null
     */
    public function getPasswordForUser(int $userId):?string;

    /**
     * @param non-empty-string $hash
     * @param int $userId
     * @return void
     */
    public function insertSession(string $hash, int $userId):void;

    /**
     * @param non-empty-string $token
     * @return array{userId:positive-int}|null
     * @throws DatabaseException
     */
    public function checkIssetToken(string $token):?array;

    /**
     * @param positive-int $userId
     * @return list<array{id:int,email:string}>
     * @throws DatabaseException
     */
    public function getEmailList(int $userId):array;

    /**
     * @param positive-int $userId
     * @param non-empty-string $encryptedEmail
     * @param non-empty-string $emailHash
     * @param bool $allowAuth
     * @return int
     */
    public function insertNewEmail(int $userId, string $encryptedEmail, string $emailHash, bool $allowAuth):int;

    /**
     * @param positive-int $userId
     * @param positive-int $itemId
     * @param non-empty-string $encryptedEmail
     * @param non-empty-string $emailHash
     * @param bool $allowAuth
     * @return void
     */
    public function editEmailItem(int $userId, int $itemId, string $encryptedEmail, string $emailHash, bool $allowAuth):void;

    /**
     * @param positive-int $userId
     * @param positive-int $itemId
     * @return array{emailEncrypted:string,allowAuth:int}|null
     * @throws DatabaseException
     */
    public function getEmailItem(int $userId, int $itemId):?array;
    public function deleteEmail(int $userId,int $itemId):void;
}