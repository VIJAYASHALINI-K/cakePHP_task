<?php
namespace CacheCleaner\Shell\Task;

use Cake\Console\Shell;
use Cake\Console\ConsoleOptionParser;
use Cake\Cache\Cache;

class CakeTask extends Shell implements TaskInterface {

    public function getOptionParser() {
        $parser = new ConsoleOptionParser('console');
        $parser
            ->setDescription("Clear Cake\Cache\Cache")
            ->setCommand("cake")
            ;
        return $parser;
    }

    public function help() {
        return 'Clear Cake\Cache\Cache';
    }

    public function main() {
        if ( Cache::clear(false) )
            $this->success('Cake cache clear complete');
        else
            $this->err("Error : Cake cache clear failed");
    }

    public function all() {
        $this->main();
    }
}
