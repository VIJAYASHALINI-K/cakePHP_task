<?php
namespace CacheCleaner\Shell\Task;

use Cake\Console\Shell;
use Cake\Console\ConsoleOptionParser;

class OpcacheTask extends Shell implements TaskInterface {

    public function getOptionParser() {
        $parser = new ConsoleOptionParser('console');
        $parser
            ->setDescription("Resets the entire opcode cache")
            ->setCommand("opcache")
            ;
        return $parser;
    }

    public function help() {
        return 'Resets the entire opcode cache';
    }

    public function main() {
        if ( opcache_reset() )
            $this->success('Opcache clear complete');
        else
            $this->err("Error : Opcache clear failed");
    }

    public function all() {
        $this->main();
    }
}
