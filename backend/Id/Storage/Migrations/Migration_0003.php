<?php

namespace Flow\Id\Storage\Migrations;

use VladViolentiy\VivaFramework\Databases\Interfaces\MigrationInterface;

class Migration_0003 extends Migration implements MigrationInterface
{
    public function init(): void
    {
        $this->migrator->query("create table sessionsMeta
(
    id             int unsigned auto_increment,
    sessionId      int unsigned not null,
    ip             varchar(64)  not null,
    ua             varchar(256) not null,
    acceptLang     varchar(128) not null,
    acceptEncoding varchar(128) not null,
    firstSeenAt varchar(64) not null,
    lastSeenAt varchar(64) not null,
    constraint sessionMeta_pk primary key (id),
    constraint sessionMeta_sessions_id_fk foreign key (sessionId) references sessions (id)
);");
    }
}
