<?php

return (new PhpCsFixer\Config())
    ->setRules([
        '@PER-CS' => true,
        'single_quote' => true,
    ])
    ->setFinder(
        (new PhpCsFixer\Finder())->in('backend')
    );