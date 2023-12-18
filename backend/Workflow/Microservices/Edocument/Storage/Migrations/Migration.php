<?php

namespace Flow\Workflow\Microservices\Edocument\Storage\Migrations;

use VladViolentiy\VivaFramework\Databases\Migrations\MigrationsClassInterface;
use VladViolentiy\VivaFramework\Databases\Mysqli;

class Migration extends Mysqli
{
    protected readonly MigrationsClassInterface $migrator;

    public function __construct(MigrationsClassInterface $migrator)
    {
        $this->migrator = $migrator;
    }

    public static array $list = [
        Migration_0000::class
    ];
}