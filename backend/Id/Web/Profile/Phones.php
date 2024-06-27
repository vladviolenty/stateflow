<?php

namespace Flow\Id\Web\Profile;

use Flow\Core\WebPrivate;
use VladViolentiy\VivaFramework\SuccessResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Phones extends WebPrivate
{
    private readonly \Flow\Id\Controller\Profile\Phones $controller;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->controller = new \Flow\Id\Controller\Profile\Phones($this->storage, $this->info['userId']);
    }

    public function get(): Response
    {
        $info = $this->controller->get();
        return new JsonResponse(SuccessResponse::data($info));
    }

    public function addNewPhone(): Response
    {
        $emailEncrypted = $this->request->get("phoneEncrypted");
        $emailHash = $this->request->get("phoneHash");
        $allowAuth = (bool)$this->request->get("allowAuth");

        $this->controller->addNewPhone($emailEncrypted, $emailHash, $allowAuth);
        return $this->get();
    }

}
