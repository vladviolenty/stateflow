<?php

namespace Flow\Id\Storage;

use Flow\Core\Database;
use Flow\Core\Enums\ServicesEnum;
use VladViolentiy\VivaFramework\Exceptions\DatabaseException;
use Ramsey\Uuid\UuidInterface;
use VladViolentiy\VivaFramework\Databases\Mysqli;

class Storage extends Mysqli implements StorageInterface
{
    public function __construct(){
        $this->setDb(Database::createConnection(ServicesEnum::Id));
    }

    public function getUserByEmail(string $hashedEmail):?array{
        /** @var array{userId:int,salt:string,iv:string}|null $info */
        $info = $this->executeQuery("SELECT u.id as userId,salt,iv
FROM usersEmails 
    JOIN users u on usersEmails.userId = u.id
WHERE emailHash=? and allowAuth=true and deleted=false","s",[$hashedEmail])->fetch_array(MYSQLI_ASSOC);
        if($info===null) return null;
        return $info;
    }

    public function getUserByUUID(UuidInterface $uuid):?array{
        /** @var array{userId:int,salt:string,iv:string}|null $info */
        $info = $this->executeQuery("SELECT id as userId,salt,iv
FROM users
WHERE uuid=unhex(?)","s",[bin2hex($uuid->getBytes())])->fetch_array(MYSQLI_ASSOC);
        if($info===null) return null;
        return $info;
    }

    public function getUserByPhone(string $hashedPhone):?array{
        /** @var array{userId:int,salt:string,iv:string}|null $info */
        $info = $this->executeQuery("SELECT users.id as userId,salt,iv
FROM users
    JOIN usersPhones uP on users.id = uP.userId
WHERE phoneHash=?","s",[$hashedPhone])->fetch_array(MYSQLI_ASSOC);
        if($info===null) return null;
        return $info;
    }

    public function checkIssetUUID(string $uuid): bool{
        /** @var array<int,int> $info */
        $info = $this->executeQuery("SELECT COUNT(*) FROM users WHERE uuid=?","s",[$uuid])->fetch_array();
        return $info[0]>0;
    }

    public function addNewUser(UuidInterface $uuid, string $password, string $iv, string $salt,string $fNameEncrypted,string $lNameEncrypted,string $bDayEncrypted,string $globalHash): int{
        /** @var string $globalHash */
        $globalHash = hex2bin($globalHash);
        $this->executeQueryBool("INSERT INTO users(uuid, password, iv, salt,fNameEncrypted,lNameEncrypted,bDayEncrypted,globalHash) VALUES(unhex(?),?,?,?,?,?,?,?)",
            "ssssssss",[bin2hex($uuid->getBytes()),$password,$iv,$salt,$fNameEncrypted,$lNameEncrypted,$bDayEncrypted, $globalHash]);
        /** @var positive-int $insId */
        $insId = $this->insertId();
        return $insId;
    }

    public function insertNewEncryptInfo(int $userId,string $publicKey,string $encryptedPrivateKey):void{
        $this->executeQueryBool("INSERT INTO usersEncryptInfo(userId, publicKey, encryptedPrivateKey) VALUES(?,?,?)",
            "iss",[$userId,$publicKey,$encryptedPrivateKey]);
    }


    public function getPasswordForUser(int $userId): ?string{
        /** @var array{password:non-empty-string}|null $info */
        $info = $this->executeQuery("SELECT password
FROM users
WHERE id=?","i",[$userId])->fetch_array(MYSQLI_ASSOC);
        if($info===null) return null;
        return $info['password'];
    }


    public function checkIssetToken(string $token):?array{
        /** @var array{userId:positive-int,lang:string,sessionId:positive-int}|null $info */
        $info = $this->executeQuery("SELECT userId,u.defaultLang as lang,sessions.id as sessionId FROM sessions JOIN users u on u.id = sessions.userId WHERE authHash=unhex(?)","s",[$token])->fetch_array(MYSQLI_ASSOC);
        if($info===null) return null;
        return $info;
    }

    public function insertSession(string $hash, int $userId):void{
        $this->executeQueryBool("INSERT INTO sessions(authHash, userId, expiredAt) VALUES (UNHEX(?),?,DATE_ADD(now(),INTERVAL 90 DAY ))","si",[$hash,$userId]);
    }

    public function getEmailList(int $userId):array{
        return $this->executeQuery("SELECT id,emailEncrypted as email FROM usersEmails WHERE userId=? and deleted=false","i",[$userId])->fetch_all(MYSQLI_ASSOC);
    }

    public function editEmailItem(int $userId, int $itemId, string $encryptedEmail, string $emailHash, bool $allowAuth):void{
        $this->executeQueryBool("UPDATE usersEmails SET emailEncrypted=?, emailHash=UNHEX(?),allowAuth=? WHERE id=? and userId=?","ssiii",[$encryptedEmail,$emailHash,(int)$allowAuth,$itemId,$userId]);
    }

    public function insertNewEmail(int $userId, string $encryptedEmail, string $emailHash, bool $allowAuth):int{
        $this->executeQueryBool("INSERT INTO usersEmails(userId, emailHash, emailEncrypted,allowAuth) VALUES (?,unhex(?),?,?)",'issi',[$userId,$emailHash,$encryptedEmail,(int)$allowAuth]);
        return $this->insertId();
    }


    public function getEmailItem(int $userId, int $itemId):?array{
        /** @var array{emailEncrypted:string,allowAuth:int}|null $info */
        $info = $this->executeQuery("SELECT emailEncrypted,allowAuth FROM usersEmails WHERE id=? and userId=?","ii",[$itemId,$userId])->fetch_array(MYSQLI_ASSOC);
        return $info;
    }

    public function deleteEmail(int $userId,int $itemId):void{
        $this->executeQueryBool("UPDATE usersEmails SET deleted=true WHERE id=? and userId=?","ii",[$itemId,$userId]);
    }


    public function getPhonesList(int $userId):array{
        return $this->executeQuery("SELECT id,phoneEncrypted as phone FROM usersPhones WHERE userId=? and deleted=false","i",[$userId])->fetch_all(MYSQLI_ASSOC);
    }

    public function deletePhone(int $userId,int $itemId):void{
        $this->executeQueryBool("UPDATE usersPhones SET deleted=true WHERE id=? and userId=?","ii",[$itemId,$userId]);
    }


    public function getPhoneItem(int $userId, int $itemId):?array{
        /** @var array{emailEncrypted:string,allowAuth:int}|null $info */
        $info = $this->executeQuery("SELECT phoneEncrypted,allowAuth FROM usersPhones WHERE id=? and userId=?","ii",[$itemId,$userId])->fetch_array(MYSQLI_ASSOC);
        return $info;
    }


    public function insertNewPhone(int $userId, string $phoneEncrypted, string $phoneHash, bool $allowAuth):int{
        $this->executeQueryBool("INSERT INTO usersPhones(userId, phoneHash, phoneEncrypted,allowAuth) VALUES (?,unhex(?),?,?)",'issi',[$userId,$phoneHash,$phoneEncrypted,(int)$allowAuth]);
        return $this->insertId();
    }

    public function checkPhoneInDatabase(string $phoneHash): bool
    {
        /** @var array{count:int} $data */
        $data = $this->executeQuery("SELECT COUNT(*) as count FROM usersPhones WHERE phoneHash=?",'s',[$phoneHash]);
        return $data['count']>0;
    }

    public function checkEmailInDatabase(string $emailHash):bool{
        /** @var array{count:int} $i */
        $i = $this->executeQuery("SELECT count(*) as count FROM usersEmails WHERE emailHash=? and deleted=false","s",[$emailHash])->fetch_array(MYSQLI_ASSOC);
        return $i['count']>0;
    }

    public function getSessionsForUser(int $userId):array{
        /** @var list<array{authHash:non-empty-string,uas:non-empty-string,ips:non-empty-string,createdAt:non-empty-string}> $i */
        $i = $this->executeQuery("SELECT 
    hex(authHash) as authHash,
    DATE_FORMAT(createdAt,'%d.%m.%Y %H:%i') as createdAt,
    group_concat(sM.ua) as uas,
    group_concat(sM.ip) as ips
FROM sessions 
    JOIN flow_id.sessionsMeta sM on sessions.id = sM.sessionId
WHERE userId=? and expiredAt>now() group by sessions.id","i",[$userId])->fetch_all(MYSQLI_ASSOC);
        return $i;
    }

    public function killSession(int $userId, string $hash):void{
        $this->executeQueryBool("UPDATE sessions SET expiredAt=now() WHERE userId=? and authHash=unhex(?)","is",[$userId,$hash]);
    }

    public function checkIssetSessionMetaInfo(
        string $session,
        string $encryptedIp,
        string $encryptedUa,
        string $encryptedAE,
        string $encryptedAL
    ):?int
    {
        /** @var array{id:positive-int}|null $i */
        $i = $this->executeQuery("SELECT sessionsMeta.id
FROM sessionsMeta 
    JOIN sessions ON sessionsMeta.sessionId=sessions.id 
WHERE authHash=unhex(?) and ip=? and ua=? and acceptEncoding=? and acceptLang=?","sssss",[$session,$encryptedIp,$encryptedUa,$encryptedAE,$encryptedAL])->fetch_array(MYSQLI_ASSOC);
        if($i===null) return null;
        return $i['id'];
    }

    public function insertSessionMeta(
        int $sessionId,
        string $encryptedIp,
        string $encryptedUa,
        string $encryptedAE,
        string $encryptedAL,
        string $encryptedLastSeenAt
    ):void
    {
        $this->executeQueryBool("INSERT INTO 
    sessionsMeta(sessionId, ip, ua, acceptLang, acceptEncoding, firstSeenAt, lastSeenAt) 
VALUES (?,?,?,?,?,?,?)","issssss",[$sessionId,$encryptedIp,$encryptedUa,$encryptedAL,$encryptedAE,$encryptedLastSeenAt,$encryptedLastSeenAt]);
    }

    public function updateLastSeenSessionMeta(int $sessionMetainfoId, string $encryptedLastSeenAt): void
    {
        $this->executeQueryBool("UPDATE sessionsMeta SET lastSeenAt=? where id=?","si",[$encryptedLastSeenAt,$sessionMetainfoId]);
    }
}