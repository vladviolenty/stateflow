<?php

namespace Flow\Core\Exceptions;

use Throwable;

class AuthenticationException extends \Exception
{
    public function __construct(string $message = "", int $code = 403, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}