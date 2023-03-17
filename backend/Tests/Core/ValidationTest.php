<?php

namespace Flow\Tests\Core;

use Flow\Core\Exceptions\ValidationException;
use Flow\Core\Validation;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Flow\Core\Validation
 * @covers \Flow\Core\Exceptions\ValidationException
 */
class ValidationTest extends TestCase
{
    private Validation $validation;

    public function setUp():void{
        $this->validation = new Validation();
    }

    public function testPhoneValidation():void{
        $this->validation->phoneNumber("375333333333");
        $this->assertTrue(true);
    }
    public function testInvalidPhones80():void{
        $this->expectException(ValidationException::class);
        $this->validation->phoneNumber("80293333333");
    }
    public function testInvalidPhones375():void{
        $this->expectException(ValidationException::class);
        $this->validation->phoneNumber("375173333333");
    }
}