<?php

namespace Flow\Id\Storage\Migrations;

use VladViolentiy\VivaFramework\Databases\Interfaces\MigrationInterface;
use VladViolentiy\VivaFramework\Databases\Migrations\MigrationsClassInterface;
use VladViolentiy\VivaFramework\Databases\Mysqli;

abstract class Migration extends Mysqli implements MigrationInterface
{
    protected readonly MigrationsClassInterface $migrator;

    public function __construct(MigrationsClassInterface $migrator)
    {
        $this->migrator = $migrator;
    }

    /**
     * @var class-string[]
     */
    public static array $list = [
        Migration_0000::class,
        Migration_0001::class,
        Migration_0002::class,
        Migration_0003::class,
    ];
}
