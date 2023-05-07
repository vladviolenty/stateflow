<?php

namespace Flow\Id\Storage\Migrations;

use VladViolentiy\VivaFramework\Databases\Mysqli;

class Migration extends Mysqli
{
    /**
     * @var class-string[]
     */
    public static array $list = [
        Migration_0000::class,
        Migration_0001::class,
        Migration_0002::class,

    ];

    public function __construct(\mysqli $db)
    {
        $this->setDb($db);
    }
}