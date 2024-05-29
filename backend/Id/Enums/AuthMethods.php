<?php

namespace Flow\Id\Enums;

enum AuthMethods: string
{
    case UUID = 'uuid';
    case Phone = 'phone';
    case Email = 'email';
}
