<?php

namespace Flow\Id\Web;

use VladViolentiy\VivaFramework\SuccessResponse;
use Flow\Core\WebPrivate;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Dashboard extends WebPrivate
{
    public function checkAuth():Response{
        return new JsonResponse(SuccessResponse::data($this->info));
    }
}