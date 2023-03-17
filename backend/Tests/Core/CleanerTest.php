<?php

namespace Flow\Tests\Core;

use Flow\Core\Cleaner;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Flow\Core\Cleaner
 */
class CleanerTest extends TestCase{
    public function testPhoneCleaner():void{
        $this->assertEquals("375333333333",Cleaner::phoneNumber("+375333333333"));
        $this->assertEquals("375333333333",Cleaner::phoneNumber(" +375333333333 "));
    }
}