<?php

namespace Flow\Core\Exceptions;

use Throwable;

class ValidationException extends \Exception
{
    public function __construct(string $message = "Ошибка валидации", int $code = 1, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}