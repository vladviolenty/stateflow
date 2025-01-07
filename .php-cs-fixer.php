<?php

return (new PhpCsFixer\Config())
    ->setRules([
        '@PER-CS' => true,
        'single_quote' => true,
        'blank_line_before_statement' => true,
        'class_reference_name_casing' => true,
        'no_empty_statement' => true,
        'class_attributes_separation' => [
            'elements' => [
                'method' => 'one',
            ],
        ],
    ])
    ->setFinder(
        (new PhpCsFixer\Finder())->in('backend'),
    );
