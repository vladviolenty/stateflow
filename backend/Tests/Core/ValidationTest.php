<?php

namespace Flow\Tests\Core;

use Flow\Core\Exceptions\ValidationException;
use Flow\Core\Validation;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

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

    public function testEmail():void{
        $this->validation->email("a@a.by");
        $this->validation->email("123@a.com");
        $this->validation->email("123@a.solutions");
        $this->validation->email("123@a.digital");
        $this->assertTrue(true);
    }

    public function testIncorrectId():void{
        $this->expectException(ValidationException::class);
        $this->validation->id(-1);
    }
    public function testHash():void{
        $uuid = "d8499a9b-f819-43ca-8f18-40a68734d31a";
        $this->validation->uuid($uuid);
        $this->assertTrue(true);
    }
}