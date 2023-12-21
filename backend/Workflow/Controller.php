<?php

namespace Flow\Workflow;

use Flow\Workflow\Storage\StorageInterface;
use VladViolentiy\VivaFramework\Exceptions\DatabaseException;

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