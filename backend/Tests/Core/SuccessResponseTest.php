<?php

namespace Flow\Tests\Core;

use Flow\Core\SuccessResponse;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Flow\Core\SuccessResponse
 */
class SuccessResponseTest extends TestCase
{
    public function testSuccessResponseData():void{
        $this->assertEquals([
            "success"=>true,
            "data"=>[
                "testBool"=>true,
                "testString"=>"123"
            ]
        ],SuccessResponse::data([
            "testBool"=>true,
            "testString"=>"123"
        ]));
    }
    public function testSuccessResponseText():void{
        $this->assertEquals([
            "success"=>true,
            "text"=>"Hello world"
        ],SuccessResponse::text("Hello world"));
    }
}