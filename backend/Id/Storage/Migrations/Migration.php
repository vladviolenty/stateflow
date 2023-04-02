<?php

namespace Flow\Id\Storage\Migrations;

use Flow\Core\Database;

class Migration extends Database
{
    /**
     * @var class-string[]
     */
    public static array $list = [
        Migration_0001::class
    ];

    public function __construct(\mysqli $db)
    {
        $this->setDb($db);
    }
}