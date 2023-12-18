<?php

namespace Flow\Workflow;

use Flow\Core\WebPrivate;
use Flow\Workflow\Storage\Storage;
use Symfony\Component\HttpFoundation\Request;

class Web extends WebPrivate
{
    private readonly Controller $controller;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->controller = new Controller(new Storage());
    }
}