<?php

namespace Flow\Core\Exceptions;

use Throwable;

class IncorrectPasswordException extends \Exception
{
    public function __construct(string $message = 'Пароль введен неверно', int $code = 4, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
