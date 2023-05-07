<?php

namespace Flow\Id\Storage\Migrations;

use Flow\Core\Interfaces\MigrationInterface;

class Migration_0002 extends Migration implements MigrationInterface
{

    public function init(): void
    {
        $this->executeQueryBoolRaw("
create table migration
(
    currentState varchar(32) not null
        primary key
);");
    }
}