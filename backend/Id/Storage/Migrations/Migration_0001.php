<?php

namespace Flow\Id\Storage\Migrations;

class Migration_0001 extends Migration
{
    public function init(): void
    {
        $this->migrator->query("
alter table users modify iv varchar(64) not null;
alter table users modify salt varchar(64) not null;
alter table usersPhones modify allowAuth bit default b'0' not null;
alter table usersPhones add deleted bit default false not null after allowAuth;
");
    }
}
