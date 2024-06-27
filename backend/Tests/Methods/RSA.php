<?php

namespace Flow\Tests\Methods;

use VladViolentiy\VivaFramework\Exceptions\ValidationException;

class RSA
{
    /**
     * @param positive-int $bits
     * @return string
     * @throws ValidationException
     */
    public static function createPublicKey(int $bits): string
    {
        $keyPair = openssl_pkey_new(array(
            "digest_alg" => 'sha512',
            "private_key_bits" => $bits,
            "private_key_type" => OPENSSL_KEYTYPE_RSA
        ));
        if($keyPair === false) {
            throw new ValidationException();
        }
        $keyDetail = openssl_pkey_get_details($keyPair);
        if($keyDetail === false) {
            throw new ValidationException();
        }
        return $keyDetail['key'];
    }
}
