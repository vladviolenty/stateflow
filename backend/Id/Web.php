<?php

namespace Flow\Id;

use Flow\Core\Req;
use Flow\Core\Validation;
use Flow\Id\Storage\Storage;
use Symfony\Component\HttpFoundation\Request;


abstract class Web
{
    protected readonly Req $request;
    protected readonly Storage $storage;

    public function __construct(Request $request)
    {
        $this->request = new Req($request);
        $this->storage = new Storage();
    }
}