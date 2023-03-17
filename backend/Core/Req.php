<?php

namespace Flow\Core;

use Symfony\Component\HttpFoundation\Request;

class Req
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    public function get(string $key):string{
        /** @var string $line */
        $line = $this->request->get($key);
        return trim($line);
    }
}