<?php

namespace Flow\Tests\Id;

use Flow\Tests\Methods\RSA;
use VladViolentiy\VivaFramework\Exceptions\ValidationException;
use Flow\Id\Controller\Auth;
use Flow\Id\Enums\AuthMethods;
use Flow\Id\Storage\UsersArrayStorage;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;

/**
 * @covers \Flow\Id\Controller\Auth
 * @covers \Flow\Id\Controller\Base
 * @covers \Flow\Core\Validation
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



    public function testCreatingNewUser(): void
    {
        $data = $this->createNewUser();
        $this->assertTrue($data);
    }

    public function testIncorrectInfo(): void
    {
        $this->expectException(ValidationException::class);

        $password = hash('sha384', 'testPassword');
        $hash = hash('sha384', 'TESTDATA');
        $iv = base64_encode(random_bytes(12));
        $salt = base64_encode(random_bytes(4));
        $this->auth->createNewUser(
            $password,
            $iv,
            $salt,
            'RSAPUBLIC',
            'RSAPRIVATE',
            'TEST',
            'TEST',
            'TEST',
            $hash,
        );
    }

    public function testGetUserInfo(): void
    {
        $this->createNewUser();
        foreach ($this->uuidList as $item) {
            $info = $this->auth->getAuthDataForUser($item, AuthMethods::UUID);
            $this->assertEquals(base64_encode('1234567890abcdef'), $info['iv']);
        }
    }

    /**
     * @return bool
     * @throws ValidationException
     */
    public function createNewUser(): bool
    {
        $password = hash('sha384', 'testPassword');
        $hash = hash('sha384', 'TESTDATA');
        $iv = base64_encode('1234567890abcdef');
        $salt = base64_encode(random_bytes(16));

        $public = RSA::createPublicKey(2048);

        $uuid = $this->auth->createNewUser(
            $password,
            $iv,
            $salt,
            $public,
            'PRIVATE',
            'TEST',
            'TEST',
            'TEST',
            $hash,
        );
        $this->uuidList[] = $uuid;
        return true;
    }
}
