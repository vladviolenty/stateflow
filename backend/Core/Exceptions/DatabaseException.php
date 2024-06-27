<?php

namespace Flow\Core\Exceptions;

use Throwable;

class DatabaseException extends \Exception
{
    public function __construct(string $message = "Ошибка запроса к БД", int $code = 2, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
