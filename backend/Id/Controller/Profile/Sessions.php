<?php

namespace Flow\Id\Controller\Profile;

use Flow\Id\Controller\Base;
use Flow\Id\Storage\StorageInterface;
use VladViolentiy\VivaFramework\Exceptions\DatabaseException;
use VladViolentiy\VivaFramework\Exceptions\ValidationException;
use VladViolentiy\VivaFramework\Validation;

class Sessions extends Base
{
    /**
     * @var positive-int
     */
    private readonly int $userId;

    /**
     * @param StorageInterface $storage
     * @param positive-int $userId
     */
    public function __construct(StorageInterface $storage, int $userId)
    {
        parent::__construct($storage);
        $this->userId = $userId;
    }

    /**
     * @return list<array{authHash:non-empty-string}>
     * @throws DatabaseException
     */
    public function get():array
    {
        return $this->storage->getSessionsForUser($this->userId);
    }

    /**
     * @param string $hash
     * @param bool $returnAvailable
     * @return list<array{authHash:non-empty-string}>|null
     * @throws DatabaseException
     * @throws ValidationException
     */
    public function killSession(
        string $hash,
        bool $returnAvailable
    ):?array
    {
        Validation::hash($hash);
        $this->storage->killSession($this->userId,$hash);
        if($returnAvailable){
            return $this->get();
        } else {
            return null;
        }
    }
}