<?php

namespace Flow\Id\Controller\Profile;

use Flow\Id\Controller\Base;
use Flow\Id\Storage\StorageInterface;

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

    public function get():array
    {
        return $this->storage->getSessionsForUser($this->userId);
    }
}