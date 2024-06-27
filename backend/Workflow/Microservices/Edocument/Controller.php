<?php

namespace Flow\Workflow\Microservices\Edocument;

class Controller
{
    public function __construct(
        private readonly Storage $storage
    ) {
    }
}
