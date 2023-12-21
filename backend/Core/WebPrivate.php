<?php

namespace Flow\Core;

use Flow\Id\Controller\Auth;
use Flow\Id\Storage\Storage;
use Symfony\Component\HttpFoundation\Request;

abstract class WebPrivate extends Web
{
    /** @var array{userId:positive-int} */
    protected readonly array $info;
    protected readonly Storage $storage;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $token = $this->request->getServer("HTTP_AUTHORIZATION")??"";
        $this->storage = new Storage();
        $controller = new Auth($this->storage);
        $this->info = $controller->checkAuth($token);
    }
}