<?php

namespace Flow\Core;

use Symfony\Component\HttpFoundation\Request;
use VladViolentiy\VivaFramework\Req;

abstract class Web
{
    protected readonly Req $request;

    public function __construct(Request $request)
    {
        $this->request = new Req($request);
    }
}
