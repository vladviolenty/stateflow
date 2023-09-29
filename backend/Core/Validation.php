<?php

namespace Flow\Core;

use VladViolentiy\VivaFramework\Exceptions\ValidationException;

class Validation
{
    public static function RSAPublicKey(string $keyInput):void{
        $publicKey = openssl_get_publickey($keyInput);
        if (!$publicKey) {
            throw new ValidationException();
        }

        // Extract the key details
        $details = openssl_pkey_get_details($publicKey);
        if (!$details) {
            throw new ValidationException();
        }
        if ($details['type'] !== OPENSSL_KEYTYPE_RSA) {
            throw new ValidationException();
        }
    }
}