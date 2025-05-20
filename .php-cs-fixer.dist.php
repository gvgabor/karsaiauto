<?php

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12'                 => true,
        'binary_operator_spaces' => ['default' => 'align_single_space_minimal'],
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__)
            ->exclude('vendor')
            ->exclude('runtime')
    );
