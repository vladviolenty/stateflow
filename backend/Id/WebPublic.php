<?php

namespace Flow\Id;

use Flow\Core\SuccessResponse;
use Flow\Id\Enums\AuthMethods;
use Flow\Id\Enums\AuthVia;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class WebPublic extends Web
{
    public function checkIssetClient():Response{
        $phone = $this->request->get("authString");
        $type = $this->request->get("type");
        $data = $this->controller->getAuthDataForUser($phone,AuthMethods::from($type));
        return new JsonResponse(SuccessResponse::data($data));
    }

    public function passwordAuth():Response{
        $phone = $this->request->get("authString");
        $type = $this->request->get("authStringType");
        $authString = $this->request->get("password");
        $data = $this->controller->auth($phone,AuthMethods::from($type),AuthVia::Password,$authString);
        return new JsonResponse(SuccessResponse::data($data));
    }

    public function register():Response{
        $password = $this->request->get("password");
        $iv = $this->request->get("iv");
        $salt = $this->request->get("salt");
        $publicKey = $this->request->get("publicKey");
        $privateKey = $this->request->get("encryptedPrivateKey");
        $fNameEncrypted = $this->request->get("fNameEncrypted");
        $lNameEncrypted = $this->request->get("lNameEncrypted");
        $bDayEncrypted = $this->request->get("bDayEncrypted");
        $hash = $this->request->get("globalHash");
        $uuid = $this->controller->createNewUser($password,$iv,$salt,$publicKey,$privateKey,$fNameEncrypted,$lNameEncrypted,$bDayEncrypted,$hash);

        return new JsonResponse(SuccessResponse::data([
            "uuid"=>$uuid->toString()
        ]));
    }
}