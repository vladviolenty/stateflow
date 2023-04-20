<?php

namespace Flow\Core;

use Flow\Id\Storage\Storage;
use Symfony\Component\HttpFoundation\Request;
use VladViolentiy\VivaFramework\Req;


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