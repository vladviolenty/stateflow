<?php

namespace Flow\Id;

use Flow\Core\Req;
use Flow\Core\Validation;
use Flow\Id\Storage\Storage;
use Symfony\Component\HttpFoundation\Request;


abstract class Web
{
    protected Req $request;
    protected Controller $controller;

    public function __construct(Request $request)
    {
        $this->request = new Req($request);
        $this->controller = new Controller(new Storage());
    }
}