<?php
$baseDir = dirname(dirname(__FILE__));

return [
    'plugins' => [
        'Bake' => $baseDir . '/vendor/cakephp/bake/',
        'CacheCleaner' => $baseDir . '/vendor/daoandco/cakephp-cachecleaner/',
        'DebugKit' => $baseDir . '/vendor/cakephp/debug_kit/',
        'Migrations' => $baseDir . '/vendor/cakephp/migrations/',
        'WyriHaximus/TwigView' => $baseDir . '/vendor/wyrihaximus/twig-view/',
    ],
];
