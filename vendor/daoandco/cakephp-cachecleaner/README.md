# CacheCleaner plugin for CakePHP
This plugin is a shell that cleans the cache in your application

## Requirements
- PHP version 5.4.16 or higher
- CakePhp 3.0 or higher

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require daoandco/cakephp-cachecleaner
```

Loading the Plugin
```PHP
  // In config/bootstrap.php
  Plugin::load('CacheCleaner', ['bootstrap' => true, 'routes' => false]);
```

## Quick Start

Clear all cache
```BASH
bin/cake CacheCleaner.clear -a
```

Clear cake cache
```BASH
bin/cake CacheCleaner.clear cake
```

## Tasks

### ORM
It's the equivalent to `orm_cache clear`. See [more informations](http://book.cakephp.org/3.0/fr/console-and-shells/orm-cache.html)
```BASH
bin/cake CacheCleaner.clear orm
```

### Cake
Clear the cache generate by `Cake\Cache\Cache`
```BASH
bin/cake CacheCleaner.clear cake
```

### Opcache
Resets the entire opcode cache, See [more informations](http://php.net/manual/fr/function.opcache-reset.php)
```BASH
bin/cake CacheCleaner.clear opcache
```

### Dir
Clear directories in "tmp/cache/"

- Clear all directories
```BASH
bin/cake CacheCleaner.clear dir -a
```

- Clear one directory
```BASH
bin/cake CacheCleaner.clear dir dir_name
```

- Clear many directories
```BASH
bin/cake CacheCleaner.clear dir dir_name other_dir_name
```

## Configuration

### Create config file
Create a file in `app/config` like 'vendor/daoandco/cakephp-cachecleaner/config/config.php'

```PHP
<?php
// config/cachecleaner.php


return [
    'CacheCleaner' => [
        'tasks' => ['CacheCleaner.Dir', 'CacheCleaner.Orm', 'CacheCleaner.Cake', 'CacheCleaner.Opcache'],

        'Dir' => [
            'dirs' => true,
        ],
    ]
];
```

### Load configuration

```PHP
<?php
// In config/bootstrap.php

Configure::load('cachecleaner', 'default');
```

### Options

- **tasks** : add or remove tasks
Exemple : if you do not want Opcache you can write 
```PHP
tasks' => ['CacheCleaner.Dir', 'CacheCleaner.Orm', 'CacheCleaner.Cake'],
```

- **Dir.dirs** : choose the folders to clear
Exemple : if you want clear only `persistent` forler you can write
```PHP
'Dir' => [
	'dirs' => ['persistent'],
],
```

## Create a new task for your usage
You can add your own tasks, Your class must implement `Task Interface`

### Create the task
```PHP
// In Shell/Task

namespace App\Shell\Task;

use Cake\Console\Shell;
use Cake\Console\ConsoleOptionParser;
use CacheCleaner\Shell\Task\TaskInterface;

class DemoTask extends Shell implements TaskInterface {

    public function getOptionParser() {
        $parser = new ConsoleOptionParser('console');
        $parser
            ->description("Task description")
            ->command("demo")
            ;
        return $parser;
    }

    public function help() {
        return 'Task description';
    }

    public function main() {
        // call with de command : "bin/cake CacheCleaner.clear demo"
        $this->success('OK');
    }

    public function all() {
        // call with de command : "bin/cake CacheCleaner.clear demo -a"
        $this->success('OK');
    }
}
```

### Load the task
```PHP
<?php
// In config/cachecleaner.php

return [
    'CacheCleaner' => [
        'tasks' => ['CacheCleaner.Dir', 'CacheCleaner.Orm', 'CacheCleaner.Cake', 'CacheCleaner.Opcache', 'Demo'],

        'Dir' => [
            'dirs' => true,
        ],
    ]
];
```
