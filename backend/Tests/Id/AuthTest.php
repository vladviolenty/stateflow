<?php

namespace Flow\Tests\Id;

use VladViolentiy\VivaFramework\Exceptions\ValidationException;
use Flow\Id\Controller\Auth;
use Flow\Id\Enums\AuthMethods;
use Flow\Id\Storage\UsersArrayStorage;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

/**
 * @covers \Flow\Id\Controller\Auth
 * @covers \Flow\Id\Controller\Base
 */
class AuthTest extends TestCase
{
    private Auth $auth;
    /**
     * @var UuidInterface[]
     */
    private array $uuidList = [];

    public function setUp(): void
    {
        parent::setUp();
        $this->auth = new Auth(new UsersArrayStorage());
    }



    public function testCreatingNewUser():void{
        $this->createNewUser();
        $this->assertTrue(true);
    }

    public function testIncorrectInfo():void{
        $this->expectException(ValidationException::class);

        $password = hash("sha384","testPassword");
        $hash = hash("sha384","TESTDATA");
        $iv = base64_encode(random_bytes(12));
        $salt = base64_encode(random_bytes(4));
        $uuid = $this->auth->createNewUser(
            $password,
            $iv,
            $salt,
            "RSAPUBLIC",
            "RSAPRIVATE",
            "TEST",
            "TEST",
            "TEST",
            $hash,
        );
        $this->assertTrue(true);
    }

    public function testGetUserInfo():void{
        $this->createNewUser();
        foreach ($this->uuidList as $item) {
            $info = $this->auth->getAuthDataForUser($item,AuthMethods::UUID);
            $this->assertEquals(base64_encode("1234567890abcdef"),$info['iv']);
        }
    }

    /**
     * @return void
     * @throws ValidationException
     */
    public function createNewUser(): void
    {
        $password = hash("sha384", "testPassword");
        $hash = hash("sha384", "TESTDATA");
        $iv = base64_encode("1234567890abcdef");
        $salt = base64_encode(random_bytes(16));
        $uuid = $this->auth->createNewUser(
            $password,
            $iv,
            $salt,
            "RSAPUBLIC",
            "RSAPRIVATE",
            "TEST",
            "TEST",
            "TEST",
            $hash,
        );
        $this->uuidList[] = $uuid;
    }
}