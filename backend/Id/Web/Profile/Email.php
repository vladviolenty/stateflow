<?php

namespace Flow\Id\Web\Profile;

use Flow\Core\WebPrivate;
use Flow\Id\Controller\Profile\EmailController;
use VladViolentiy\VivaFramework\SuccessResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Email extends WebPrivate
{
    private readonly EmailController $controller;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->controller = new EmailController($this->storage);
    }

    public function addNewEmail(): JsonResponse
    {
        $emailEncrypted = $this->request->get('emailEncrypted');
        $emailHash = $this->request->get('emailHash');
        $allowAuth = (bool) $this->request->get('allowAuth');

        $this->controller->addNewEmail($this->info['userId'], $emailEncrypted, $emailHash, $allowAuth);

        return $this->getEmailList();
    }

    public function editEmail(): JsonResponse
    {
        $itemId = (int) $this->request->get('itemId');
        $emailEncrypted = $this->request->get('emailEncrypted');
        $emailHash = $this->request->get('emailHash');
        $allowAuth = (bool) $this->request->get('allowAuth');

        $this->controller->editItem($this->info['userId'], $itemId, $emailEncrypted, $emailHash, $allowAuth);

        return $this->getEmailList();
    }

    public function getEmailItem(): JsonResponse
    {
        $itemId = (int) $this->request->get('id');
        $info = $this->controller->getEmailItem($this->info['userId'], $itemId);

        return new JsonResponse(SuccessResponse::data($info));
    }

    public function getEmailList(): JsonResponse
    {
        $info = $this->controller->getEmailList($this->info['userId']);

        return new JsonResponse(SuccessResponse::data($info));
    }

    public function deleteEmail(): JsonResponse
    {
        $id = (int) $this->request->get('id');
        $this->controller->deleteEmail($this->info['userId'], $id);

        return $this->getEmailList();
    }
}
