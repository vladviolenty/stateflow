<?php

namespace Flow\Workflow\Microservices\Edocument\Storage\Migrations;

use VladViolentiy\VivaFramework\Databases\Interfaces\MigrationInterface;

class Migration_0000 extends Migration implements MigrationInterface
{
    public function init(): void
    {
        $this->migrator->query("CREATE TABLE `documentsSource` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  constraint PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

        $this->migrator->query("CREATE TABLE `documents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `orgId` int(10) unsigned not null,
  `sourceId` int(10) unsigned NOT NULL,
  `from` varchar(128) NOT NULL,
  `shortInfo` varchar(256) NOT NULL,
  `createdBy` int(10) unsigned NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `deadlineAt` datetime DEFAULT NULL,
  constraint PRIMARY KEY (`id`),
  CONSTRAINT `documents_source_id_fk` FOREIGN KEY (`sourceId`) REFERENCES `documentsSource` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

        $this->migrator->query("CREATE TABLE `documentsFile` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `documentId` int(10) unsigned NOT NULL,
  `type` bit(1) NOT NULL DEFAULT b'0',
  `file` varchar(128) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  constraint PRIMARY KEY (`id`),
  CONSTRAINT `documentsFile_documents_id_fk` FOREIGN KEY (`documentId`) REFERENCES `documents` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

        $this->migrator->query("CREATE TABLE `documentsFileSign` (
  `id` int(10) unsigned NOT NULL,
  `fileId` int(10) unsigned NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  `signFile` varchar(256) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  constraint PRIMARY KEY (`id`),
  CONSTRAINT `documentsFileSign_documentsFile_id_fk` FOREIGN KEY (`fileId`) REFERENCES `documentsFile` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

        $this->migrator->query("CREATE TABLE `tags` (
  `id` int(10) unsigned NOT NULL,
  `tag` varchar(64) NOT NULL,
  `color` enum('primary','secondary','success','info','warning','danger','light') not null default 'primary',
  constraint PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

        $this->migrator->query("CREATE TABLE `documentsTags` (
  `id` int(10) unsigned NOT NULL,
  `documentId` int(10) unsigned NOT NULL,
  `tagId` varchar(64) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  constraint PRIMARY KEY (`id`),
  CONSTRAINT `documentsStatus_documents_id_fk` FOREIGN KEY (`documentId`) REFERENCES `documents` (`id`),
  CONSTRAINT `documentsStatus_tags_id_fk` FOREIGN KEY (`tagId`) REFERENCES `tags` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

        $this->migrator->query("CREATE TABLE `documentsStatus` (
  `id` int(10) unsigned NOT NULL,
  `documentId` int(10) unsigned NOT NULL,
  `status` enum('created','noted','inwork','finished') NOT NULL,
  `createdBy` int(10) unsigned NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  constraint PRIMARY KEY (`id`),
  CONSTRAINT `documentsStatus_documents_id_fk` FOREIGN KEY (`documentId`) REFERENCES `documents` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

        $this->migrator->query("CREATE TABLE `documentsUser` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `documentId` int(10) unsigned NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  `status` enum('executor','control') NOT NULL,
  `important` bit(1) NOT NULL DEFAULT b'0',
  `setByUserId` int(10) unsigned NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  constraint PRIMARY KEY (`id`),
  CONSTRAINT `documentsUser_documents_id_fk` FOREIGN KEY (`documentId`) REFERENCES `documents` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
    }
}
