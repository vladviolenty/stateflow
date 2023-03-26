<?php

namespace Flow\Id;

use Flow\Id\Controller\Auth;
use Symfony\Component\HttpFoundation\Request;

abstract class WebPrivate extends Web
{
    /** @var array{userId:positive-int} */
    protected readonly array $info;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $token = $this->request->getServer("HTTP_AUTHORIZATION");
        $controller = new Auth($this->storage);
        $this->info = $controller->checkAuth($token);
    }
}