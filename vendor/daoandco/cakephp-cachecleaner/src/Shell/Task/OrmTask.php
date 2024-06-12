<?php
namespace CacheCleaner\Shell\Task;

use Cake\Console\Shell;
use Cake\Console\ConsoleOptionParser;

class OrmTask extends Shell implements TaskInterface {

    public function getOptionParser() {
        $parser = new ConsoleOptionParser('console');
        $parser
            ->setDescription("Clear ORM Cache.")
            ->setCommand("model")
            ;
        return $parser;
    }

    public function help() {
        return 'Clear ORM Cache';
    }

    public function main() {
        $this->dispatchShell('orm_cache clear');
    }

    public function all() {
        $this->main();
    }
}
