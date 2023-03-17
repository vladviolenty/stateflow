<?php
require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

$application = new Application();

$application->register('check-storage-security')
    ->setCode(function (InputInterface $input, OutputInterface $output): int {
        $storageSecurity = new \Flow\Tests\Custom\StorageSecurity();
        $storageSecurity->storageQueryTest();
        return Command::SUCCESS;
    });

$application->run();