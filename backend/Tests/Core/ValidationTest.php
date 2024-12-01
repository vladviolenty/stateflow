<?php

namespace Flow\Tests\Core;

use Flow\Core\Validation;
use Flow\Tests\Methods\RSA;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Flow\Core\Validation
 */
class ValidationTest extends TestCase
{
    public function testRSAValidation(): void
    {
        $public = RSA::createPublicKey(2048);
        $this->assertTrue(Validation::RSAPublicKey($public));
    }
}
