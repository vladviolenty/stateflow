<?php

namespace Flow\Workflow;

use Flow\Workflow\Storage\StorageInterface;

class Controller
{
    public function __construct(
        private readonly StorageInterface $storage
    )
    {
    }
}