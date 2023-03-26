<?php

namespace Flow\Id\Controller;

use Flow\Core\Validation;
use Flow\Id\Storage\StorageInterface;

class Base
{
    protected readonly StorageInterface $storage;
    protected readonly Validation $validation;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
        $this->validation = new Validation();
    }
}