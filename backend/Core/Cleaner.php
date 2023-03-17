<?php

namespace Flow\Core;

class Cleaner
{
    public static function phoneNumber(string $phone):string{
        /** @var string $phone */
        $phone = filter_var($phone,FILTER_SANITIZE_NUMBER_INT);
        return str_replace(["+","-"],"",$phone);
    }
}