<?php

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'no_unused_imports' => true,
        'not_operator_with_successor_space' => true,
        'trailing_comma_in_multiline' => true,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__)
            ->name('*.php')
            ->notName('*.blade.php')
            ->ignoreDotFiles(true)
            ->ignoreVCS(true)
    );
