<?php

namespace Flow\Core;

use Flow\Core\Exceptions\ValidationException;
use Ramsey\Uuid\Rfc4122\Validator;

class Validation
{
    public const UUID_PATTERN = '/^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-'
    . '[1-8][0-9A-Fa-f]{3}-[ABab89][0-9A-Fa-f]{3}-[0-9A-Fa-f]{12}$/';
    /**
     * @throws ValidationException
     */
    public function phoneNumber(string $value):void{
        if(str_starts_with($value,"80")) {
            throw new ValidationException("Номер телефона введен неверно");
        }
        if(str_starts_with($value,"375") && !preg_match("/^375(29|33|44|25)[0-9]{7}$/",$value)){
            throw new ValidationException("Номер телефона введен неверно");
        }
    }

    /** @phpstan-assert positive-int $item */
    public function id(int $item):void{
        if($item<=0) throw new ValidationException();
    }

    /** @phpstan-assert non-empty-string $token */
    public function authToken(string $token):void{
        if(!preg_match("/^[a-z0-9]{96}$/",$token)) throw new ValidationException();
    }

    public function email(string $email):void{
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)) throw new ValidationException();
    }

    public function uuid(string $uuid):void{
        if(!preg_match(self::UUID_PATTERN,$uuid)) throw new ValidationException();
    }
}