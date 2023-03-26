<?php

namespace Flow\Id;

use Flow\Core\Exceptions\ValidationException;
use Flow\Core\SuccessResponse;
use Flow\Id\Controller\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class WebPrivate extends Web
{
    /** @var array{userId:positive-int} */
    protected readonly array $info;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $token = $this->request->getServer("Authorization");
        $controller = new Auth($this->storage);
        $this->info = $controller->checkAuth($token);
    }
}