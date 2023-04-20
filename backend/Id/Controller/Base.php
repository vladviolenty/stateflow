<?php

namespace Flow\Id\Controller;

use Flow\Id\Storage\StorageInterface;

class Base
{
    protected readonly StorageInterface $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }
}