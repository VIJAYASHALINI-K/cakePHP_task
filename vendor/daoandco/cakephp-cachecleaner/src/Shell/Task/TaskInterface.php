<?php
namespace CacheCleaner\Shell\Task;

interface TaskInterface {

    /**
     * Display help for this console.
     *
     * @return ConsoleOptionParser
     */
    public function getOptionParser();

    /**
     * Main fonction, call with the task name
     */
    public function main();

    /**
     * All fonction, call with the option -a or --all
     */
    public function all();

    /**
     * Help message for --help
     * @return string
     */
    public function help();
}
