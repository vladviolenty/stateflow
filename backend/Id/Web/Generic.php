<?php

namespace Flow\Id\Web;

use Flow\Core\WebPrivate;
use Flow\Id\Storage\Storage;
use Symfony\Component\HttpFoundation\Request;

class Generic extends WebPrivate
{
    protected readonly Storage $storage;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->storage = new Storage();
    }
}