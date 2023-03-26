<?php

namespace Flow\Id;

use Flow\Core\Exceptions\AuthenticationException;
use Flow\Core\Exceptions\DatabaseException;
use Flow\Core\Exceptions\IncorrectPasswordException;
use Flow\Core\Exceptions\NotfoundException;
use Flow\Core\Exceptions\ValidationException;
use Flow\Core\Random;
use Flow\Core\Validation;
use Flow\Id\Enums\AuthMethods;
use Flow\Id\Enums\AuthVia;
use Flow\Id\Storage\StorageInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Controller
{
    private readonly StorageInterface $storage;
    private readonly Validation $validation;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
        $this->validation = new Validation();
    }

    public function createNewUser(
        string $password,
        string $iv,
        string $salt,
        string $publicKey,
        string $encryptedPrivateKey,
        string $fNameEncrypted,
        string $lNameEncrypted,
        string $bDayEncrypted,
        string $hash,
    ):UuidInterface{
        if($password==="" or $iv==="" or $salt==="" or $fNameEncrypted==="" or $lNameEncrypted==="" or $bDayEncrypted==="" or $hash==="") throw new ValidationException();

        $decodedIv = base64_decode($iv);
        $decodedSalt = base64_decode($salt);
        if(
            $decodedSalt===$decodedIv or
            strlen($decodedIv)!==16 or
            strlen($decodedSalt)!==16
        ) throw new ValidationException();

        $uuid = UUID::uuid4();
        /** @var non-empty-string $passwordHash */
        $passwordHash = password_hash($password,PASSWORD_BCRYPT);
        $userId = $this->storage->addNewUser($uuid,$passwordHash,$iv,$salt,$fNameEncrypted,$lNameEncrypted,$bDayEncrypted,$hash);
        $this->storage->insertNewEncryptInfo($userId,$publicKey,$encryptedPrivateKey);
        return $uuid;
    }

    /**
     * @param string $userInfo
     * @param AuthMethods $authTypesEnum
     * @return array{userId:int,salt:string,iv:string}
     * @throws NotfoundException
     * @throws ValidationException
     * @throws DatabaseException
     */
    private function getUserInfoAuth(string $userInfo, AuthMethods $authTypesEnum):array{
        if($authTypesEnum === AuthMethods::UUID){
            $this->validation->uuid($userInfo);
            $userInfo = $this->storage->getUserByUUID(Uuid::fromString($userInfo));
        } elseif ($authTypesEnum === AuthMethods::Email) {
            $this->validation->email($userInfo);
            $userInfo = $this->storage->getUserByEmail($userInfo);
        } elseif ($authTypesEnum === AuthMethods::Phone) {
            $this->validation->phoneNumber($userInfo);
            $userInfo = $this->storage->getUserByPhone($userInfo);
        } else {
            throw new ValidationException();
        }
        if($userInfo===null) throw new NotfoundException();
        return $userInfo;
    }

    /**
     * @param string $userInfo
     * @param AuthMethods $authTypesEnum
     * @return array{salt:string,iv:string}
     * @throws NotfoundException
     */
    public function getAuthDataForUser(string $userInfo, AuthMethods $authTypesEnum):array{
        $userInfo = $this->getUserInfoAuth($userInfo,$authTypesEnum);
        unset($userInfo['userId']);
        return $userInfo;
    }

    /**
     * @param string $token
     * @return array{userId:positive-int}
     * @throws AuthenticationException
     */
    public function checkAuth(string $token):array{
        $this->validation->authToken($token);
        $userInfo = $this->storage->checkIssetToken($token);
        if($userInfo===null) throw new AuthenticationException();
        return $userInfo;
    }

    /**
     * @param string $userInfo
     * @param AuthMethods $authTypesEnum
     * @param string $authString
     * @return array{hash:string}
     * @throws DatabaseException
     * @throws IncorrectPasswordException
     * @throws NotfoundException
     * @throws ValidationException
     */
    public function auth(string $userInfo, AuthMethods $authTypesEnum,AuthVia $authVia, string $authString):array{
        $userInfo = $this->getUserInfoAuth($userInfo,$authTypesEnum);
        if($authString==="") throw new ValidationException();
        if($authVia==AuthVia::Password){
            $passwordHash = $this->storage->getPasswordForUser($userInfo['userId']);
            if($passwordHash===null) throw new ValidationException();
            if(!password_verify($authString,$passwordHash)) throw new IncorrectPasswordException();
        }
        $hash = Random::hash(Random::get());
        $this->storage->insertSession($hash,$userInfo['userId']);
        return [
            "hash"=>$hash,
            "salt"=>$userInfo['salt'],
            "iv"=>$userInfo['iv']
        ];
    }


    /**
     * @param positive-int $userId
     * @return list<array{id:int,email:string}>
     * @throws DatabaseException
     */
    public function getEmailList(int $userId):array{
        return $this->storage->getEmailList($userId);
    }

    /**
     * @param positive-int $userId
     * @param non-empty-string $emailEncrypted
     * @param non-empty-string $emailHash
     * @param bool $allowAuth
     */
    public function addNewEmail(int $userId, string $emailEncrypted, string $emailHash, bool $allowAuth):int{
        $id = $this->storage->insertNewEmail($userId,$emailEncrypted,$emailHash,$allowAuth);
        return $id;
    }

    /**
     * @param positive-int $userId
     * @param int $itemId
     * @param string $emailEncrypted
     * @param string $emailHash
     * @param bool $allowAuth
     * @throws ValidationException
     */
    public function editItem(int $userId,int $itemId, string $emailEncrypted, string $emailHash, bool $allowAuth):void{
        $this->validation->id($itemId);
        if($emailHash==="" or $emailEncrypted==="") throw new ValidationException();

        $this->storage->editEmailItem($itemId,$userId,$emailEncrypted,$emailHash,$allowAuth);
    }

    /**
     * @param positive-int $userId
     * @param int $itemId
     * @return array{emailEncrypted:string,allowAuth:bool}
     * @throws DatabaseException
     * @throws NotfoundException
     */
    public function getEmailItem(int $userId, int $itemId):array{
        $this->validation->id($itemId);

        $i = $this->storage->getEmailItem($userId,$itemId);
        if($i===null) throw new NotfoundException();
        $i['allowAuth'] = (bool)$i['allowAuth'];
        return $i;

    }

    /**
     * @param positive-int $userId
     * @param int $itemId
     * @return void
     */
    public function deleteEmail(int $userId, int $itemId):void{
        $this->validation->id($itemId);

        $this->storage->deleteEmail($userId,$itemId);
    }
}