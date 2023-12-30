<?php

namespace Flow\Workflow;

use Flow\Core\Validation;
use Flow\Workflow\Storage\StorageInterface;
use Ramsey\Uuid\Uuid;
use VladViolentiy\VivaFramework\Exceptions\DatabaseException;
use VladViolentiy\VivaFramework\Exceptions\ValidationException;

class Controller
{
    /**
     * @param StorageInterface $storage
     * @param array{userId:positive-int,lang:string} $userInfo
     */
    public function __construct(
        private readonly StorageInterface $storage,
        private readonly array $userInfo
    )
    {
    }

    public function createNewOrganization(
        string $name,
        string $genericId,
        string $iv,
        string $salt,
        string $encryptedPassword,
        string $encryptedPrivateRSAKey,
        string $publicRSAKey,
        bool $publicFLNames,
        string $encryptedCreatedAt
    ):int
    {
        \VladViolentiy\VivaFramework\Validation::nonEmpty($name);
        \VladViolentiy\VivaFramework\Validation::nonEmpty($genericId);
        \VladViolentiy\VivaFramework\Validation::nonEmpty($encryptedPassword);
        \VladViolentiy\VivaFramework\Validation::nonEmpty($encryptedCreatedAt);
        \VladViolentiy\VivaFramework\Validation::nonEmpty($encryptedPrivateRSAKey);
        \VladViolentiy\VivaFramework\Validation::nonEmpty($iv);
        \VladViolentiy\VivaFramework\Validation::nonEmpty($salt);
        Validation::RSAPublicKey($publicRSAKey);

        $decodedIv = base64_decode($iv);
        $decodedSalt = base64_decode($salt);
        if(
            $decodedSalt===$decodedIv or
            strlen($decodedIv)!==16 or
            strlen($decodedSalt)!==16
        ) throw new ValidationException();

        $orgUUID = Uuid::uuid4();

        $orgId = $this->storage->insertNewOrganization($orgUUID,$name,$genericId,$publicFLNames,$iv,$salt,$encryptedCreatedAt);
        $this->storage->insertEncryptInfo($orgId,$encryptedPrivateRSAKey,$publicRSAKey,"generic");

        return 0;
    }

    /**
     * @return list<array{name:non-empty-string,genericId:non-empty-string,iv:non-empty-string,salt:non-empty-string,encryptionKey:non-empty-string}>
     * @throws DatabaseException
     */
    public function getOrgListForUser():array
    {
        $info = $this->storage->getOrgForUser($this->userInfo['userId']);
        return $info;
    }
}