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

    public function createOrg():Response
    {
        $name = $this->request->get("name");
        $genericId = $this->request->get("genericId");
        $iv = $this->request->get("iv");
        $salt = $this->request->get("salt");
        $encryptedPassword = $this->request->get("encryptedPassword");
        $publicFLNames = $this->request->get("publicFLNames");
        $encryptedRSAPrivate = $this->request->get("encryptedPrivateKey");
        $rsaPublic = $this->request->get("publicKey");
        $encryptedCreatedAt = $this->request->get("encryptedCreatedAt");


        $this->controller->createNewOrganization(
            $name,
            $genericId,
            $iv,
            $salt,
            $encryptedPassword,
            $encryptedRSAPrivate,
            $rsaPublic,
            $publicFLNames,
            $encryptedCreatedAt
        );

        return new JsonResponse(SuccessResponse::data([
            "organizations"=>$this->controller->getOrgListForUser()
        ]));
    }

    public function getOrgList():Response
    {
        $info = $this->controller->getOrgListForUser();

        return new JsonResponse(SuccessResponse::data([
            "organizations"=>$info
        ]));
    }
}