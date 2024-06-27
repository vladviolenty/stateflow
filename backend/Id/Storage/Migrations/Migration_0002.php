<?php

namespace Flow\Id\Storage\Migrations;

use VladViolentiy\VivaFramework\Databases\Interfaces\MigrationInterface;

class Migration_0002 extends Migration implements MigrationInterface
{
    public function init(): void
    {
        $this->migrator->query("alter table users modify lNameEncrypted varchar(128) not null");
        $this->migrator->query("alter table usersEncryptInfo add createdAt datetime default now() null");
    }
}
