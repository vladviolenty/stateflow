<?php

namespace Flow\Workflow\Storage\Migrations;

use VladViolentiy\VivaFramework\Databases\Interfaces\MigrationInterface;

class Migration_0001 extends Migration implements MigrationInterface
{
    public function init():void
    {
        $this->migrator->query("
alter table organizations add uuid binary(16) not null after id;
alter table organizations add publicFLNames bit not null;
alter table organizations add createdAt varchar(128) not null;
alter table organizations drop column passwordHash;
alter table organizationsUsers add encryptedFLName varchar(128) null;
alter table organizationsUsers add constraint organizationsUsers_organizations_id_fk foreign key (organizationId) references organizations (id);
");
    }
}