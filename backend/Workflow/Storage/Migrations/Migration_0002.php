<?php

namespace Flow\Workflow\Storage\Migrations;

use VladViolentiy\VivaFramework\Databases\Interfaces\MigrationInterface;

class Migration_0002 extends Migration implements MigrationInterface
{

    public function init(): void
    {
        $this->migrator->query("alter table organizationsEncryptInfo modify encryptedPrivateKey text not null");
        $this->migrator->query("alter table organizationsEncryptInfo modify publicKey text not null");
    }
}