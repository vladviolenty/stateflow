<?php

namespace Flow\Tests\Core;

use Flow\Core\Req;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * @covers Flow\Core\Req
 */
class ReqTest extends TestCase
{
    public function testSimplePost():void{
        $request = new Request();
        $request->request->set("value","123");
        $request->request->set("text","textValue");
        $req = new Req($request);
        $this->assertEquals("123",$req->get("value"));
        $this->assertEquals("textValue",$req->get("text"));
    }

    public function testServerHeader():void{
        $request = new Request();
        $request->server->set("auth","testAuth");
        $req = new Req($request);
        $this->assertEquals("testAuth",$req->getServer("auth"));
    }
}