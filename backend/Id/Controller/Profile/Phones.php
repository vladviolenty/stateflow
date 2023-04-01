<?php

namespace Flow\Id\Controller\Profile;

use Flow\Core\Exceptions\DatabaseException;
use Flow\Id\Controller\Base;
use Flow\Id\Storage\StorageInterface;

class Phones extends Base
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
     * @return list<array{id:int,phone:string}>
     * @throws DatabaseException
     */
    public function get():array{
        return $this->storage->getPhonesList($this->userId);
    }
}