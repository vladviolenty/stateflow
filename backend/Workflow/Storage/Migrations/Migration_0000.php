<?php

namespace Flow\Workflow\Storage\Migrations;

use VladViolentiy\VivaFramework\Databases\Interfaces\MigrationInterface;

class Migration_0000 extends Migration implements MigrationInterface
{
    public function init(): void
    {
        $this->migrator->query("

CREATE TABLE `organizations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `passwordHash` varchar(128) NOT NULL,
  `genericId` varchar(64) NOT NULL,
  `name` varchar(256) NOT NULL,
  `iv` varchar(64) NOT NULL,
  `salt` varchar(64) NOT NULL,
  CONSTRAINT PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");

$this->migrator->query("
CREATE TABLE `organizationsEncryptInfo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `organizationId` int(10) unsigned NOT NULL,
  `encryptedPrivateKey` int(10) unsigned NOT NULL,
  `publicKey` int(10) unsigned NOT NULL,
  `type` varchar(64) DEFAULT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  CONSTRAINT PRIMARY KEY (`id`),
  CONSTRAINT `organizationsEncryptInfo_organizations_id_fk` FOREIGN KEY (`organizationId`) REFERENCES `organizations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
$this->migrator->query("
CREATE TABLE `organizationsUsers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `organizationId` int(10) unsigned NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  `isMainUser` bit(1) NOT NULL DEFAULT b'0',
  `encryptionKey` varchar(128) NOT NULL,
  CONSTRAINT PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
    }
}