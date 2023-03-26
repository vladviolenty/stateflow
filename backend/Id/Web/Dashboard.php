<?php

namespace Flow\Id\Web;

use Flow\Core\SuccessResponse;
use Flow\Id\WebPrivate;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Dashboard extends WebPrivate
{
    public function checkAuth():Response{
        return new JsonResponse(SuccessResponse::data($this->info));
    }
}