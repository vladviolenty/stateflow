<?php

namespace Flow\Tests\Core;

use Flow\Core\Validation;
use PHPUnit\Framework\TestCase;
use VladViolentiy\VivaFramework\Exceptions\ValidationException;

/**
 * @covers \Flow\Core\Validation
 */
class ValidationTest extends TestCase
{
    public function testRSAValidation():void{
        $keyPair = openssl_pkey_new(array(
            "digest_alg" => 'sha512',
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA
        ));
        if($keyPair===null) throw new ValidationException();
        $public = openssl_pkey_get_details($keyPair)['key'];
        Validation::RSAPublicKey($public);
        $this->assertTrue(true);
    }
}