<?php
return [
    'CacheCleaner' => [
        'tasks' => ['CacheCleaner.Dir', 'CacheCleaner.Orm', 'CacheCleaner.Cake', 'CacheCleaner.Opcache'],

        'Dir' => [
            'dirs' => true,
        ],
    ]
];