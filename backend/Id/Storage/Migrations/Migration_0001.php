<?php

namespace Flow\Id\Storage\Migrations;

use Flow\Core\Interfaces\MigrationInterface;

class Migration_0001 extends Migration implements MigrationInterface {
    public function init():void{
        $this->executeQueryBoolRaw("
alter table users modify iv varchar(64) not null;
alter table users modify salt varchar(64) not null;
alter table usersPhones modify allowAuth bit default b'0' not null;
alter table usersPhones add deleted bit default false not null after allowAuth;
");
    }
}