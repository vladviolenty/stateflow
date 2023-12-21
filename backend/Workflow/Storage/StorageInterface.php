<?php

namespace Flow\Workflow\Storage;

use VladViolentiy\VivaFramework\Exceptions\DatabaseException;

interface StorageInterface
{
    /**
     * @param positive-int $userId
     * @return list<array{name:non-empty-string,genericId:non-empty-string,iv:non-empty-string,salt:non-empty-string,encryptionKey:non-empty-string}>
     * @throws DatabaseException
     */
    public function getOrgForUser(int $userId):array;
}