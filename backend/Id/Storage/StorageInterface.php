<?php

namespace Flow\Id\Storage;

use Flow\Core\Exceptions\DatabaseException;
use Ramsey\Uuid\UuidInterface;

interface StorageInterface
{
    /**
     * @param non-empty-string $hashedEmail
     * @return array{userId:int,salt:string,iv:string}|null
     * @throws DatabaseException
     */
    public function getUserByEmail(string $hashedEmail):?array;

    /**
     * @param non-empty-string $hashedPhone
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
     * @return positive-int
     */
    public function addNewUser(UuidInterface $uuid, string $password, string $iv, string $salt, string $fNameEncrypted, string $lNameEncrypted, string $bDayEncrypted, string $globalHash): int;

    /**
     * @param positive-int $userId
     * @param non-empty-string $publicKey
     * @param non-empty-string $encryptedPrivateKey
     * @return void
     */
    public function insertNewEncryptInfo(int $userId, string $publicKey, string $encryptedPrivateKey):void;

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
     * @return array{userId:positive-int,lang:string}|null
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

    /**
     * @param positive-int $userId
     * @param positive-int $itemId
     * @return void
     */
    public function deleteEmail(int $userId, int $itemId):void;

    /**
     * @param positive-int $userId
     * @return list<array{id:int,phone:string}>
     * @throws DatabaseException
     */
    public function getPhonesList(int $userId):array;
    public function deletePhone(int $userId,int $itemId):void;

    /**
     * @param positive-int $userId
     * @param positive-int $itemId
     * @return array{emailEncrypted:string,allowAuth:int}|null
     * @throws DatabaseException
     */
    public function getPhoneItem(int $userId, int $itemId):?array;

    /**
     * @param positive-int $userId
     * @param non-empty-string $phoneEncrypted
     * @param non-empty-string $phoneHash
     * @param bool $allowAuth
     * @return int
     */
    public function insertNewPhone(int $userId, string $phoneEncrypted, string $phoneHash, bool $allowAuth):int;

    /**
     * @param non-empty-string $emailHash
     * @return bool
     */
    public function checkEmailInDatabase(string $emailHash):bool;

    /**
     * @param non-empty-string $phoneHash
     * @return bool
     */
    public function checkPhoneInDatabase(string $phoneHash):bool;
}