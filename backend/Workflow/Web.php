<?php

namespace Flow\Workflow;

use Flow\Core\WebPrivate;
use Flow\Workflow\Storage\Storage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VladViolentiy\VivaFramework\SuccessResponse;

class Web extends WebPrivate
{
    private readonly Controller $controller;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->controller = new Controller(new Storage(),$this->info);
    }

    public function getOrgListForUsers():Response
    {
        $info = $this->controller->getOrgListForUser();

        return new JsonResponse(SuccessResponse::data([
            "organizations"=>$info
        ]));
    }
}