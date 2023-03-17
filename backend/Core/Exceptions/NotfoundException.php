<?php

namespace Flow\Core\Exceptions;

use Throwable;

class NotfoundException extends \Exception
{
    public function __construct(string $message = "Не найдено", int $code = 3, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}