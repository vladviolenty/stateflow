<?php

namespace Flow\Core;

class Route
{
    /** @var list<array{route:non-empty-string,class:class-string,method:non-empty-string}> */
    public static array $list = [
        [
            "route" => "/api/id/checkIssetClient",
            "class" => \Flow\Id\Web\Auth::class,
            "method" => "checkIssetClient"
        ],
        [
            "route" => "/api/id/register",
            "class" => \Flow\Id\Web\Auth::class,
            "method" => "register"
        ],
        [
            "route" => "/api/id/passwordAuth",
            "class" => \Flow\Id\Web\Auth::class,
            "method" => "passwordAuth"
        ],
        [
            "route" => "/api/id/checkAuth",
            "class" => \Flow\Id\Web\Dashboard::class,
            "method" => "checkAuth"
        ],
        [
            "route" => "/api/id/killSession",
            "class" => \Flow\Id\Web\Profile\Sessions::class,
            "method" => "killSession"
        ],
        [
            "route" => "/api/id/session/get",
            "class" => \Flow\Id\Web\Profile\Sessions::class,
            "method" => "get"
        ],
        [
            "route" => "/api/id/writeMeta",
            "class" => \Flow\Id\Web\Dashboard::class,
            "method" => "writeMetaInfo"
        ],
        [
            "route" => "/api/id/email/get",
            "class" => \Flow\Id\Web\Profile\Email::class,
            "method" => "getEmailList"
        ],
        [
            "route" => "/api/id/email/getItem",
            "class" => \Flow\Id\Web\Profile\Email::class,
            "method" => "getEmailItem"
        ],
        [
            "route" => "/api/id/email/add",
            "class" => \Flow\Id\Web\Profile\Email::class,
            "method" => "addNewEmail"
        ],
        [
            "route" => "/api/id/email/delete",
            "class" => \Flow\Id\Web\Profile\Email::class,
            "method" => "deleteEmail"
        ],
        [
            "route" => "/api/id/phone/get",
            "class" => \Flow\Id\Web\Profile\Phones::class,
            "method" => "get"
        ],
        [
            "route" => "/api/id/phone/getItem",
            "class" => \Flow\Id\Web\Profile\Phones::class,
            "method" => "getItem"
        ],
        [
            "route" => "/api/id/phone/add",
            "class" => \Flow\Id\Web\Profile\Phones::class,
            "method" => "add"
        ],
        [
            "route" => "/api/id/phone/delete",
            "class" => \Flow\Id\Web\Profile\Phones::class,
            "method" => "delete"
        ]
    ];
}
