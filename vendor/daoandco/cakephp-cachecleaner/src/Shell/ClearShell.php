<?php
namespace CacheCleaner\Shell;

use Cake\Console\Shell;
use Cake\Cache\Cache;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;

use Cache\Shell\Task\CacheDirTask;

class ClearShell extends Shell {

    public function initialize() {
        $this->tasks = Configure::read('CacheCleaner.tasks');
        $this->_mergeVars(
            ['tasks'],
            ['associative' => ['tasks']]
        );

        parent::initialize();
    }

    public function main() {
        if ( $this->params['all'] )
            $this->all();
        else
            $this->dispatchShell('CacheCleaner.clear --help');
    }

    /**
     * Display help for this console.
     *
     * @return ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = new ConsoleOptionParser('console');
        $parser
            ->setDescription("This shell clean the cache of your application.")
            ->setCommand("cache.clear")
            ->addOption('all', [
                'short' => 'a',
                'help' => 'Clear all caches',
                'boolean' => true,
            ])

            ->addSubcommand('all', [
                'help' => 'Clear all caches',
            ])
            ;

        foreach ( $this->tasks as $task => $option ) {
            $classname = $this->taskClassname($task);

            $parser->addSubcommand($this->taskName($task), [
                'help' => $this->$classname->help(),
                'parser' => $this->$classname->getOptionParser(),
            ]);
        }

        return $parser;
    }

    /**
     * Execute all tasks
     */
    public function all() {

        foreach ( $this->tasks as $task => $option ) {
            $task = $this->taskClassname($task);
            $this->$task->all();
        }
    }

    /**
     * Get classname for a task
     * @param  string $task : plugin.taskname
     * @return string
     */
    private function taskClassname($task) {
        $explode = explode('.', $task);
        return ucfirst(end($explode));
    }

    /**
     * Get cmd name for a task
     * @param  string $task : plugin.taskname
     * @return string
     */
    private function taskName($task) {
        $explode = explode('.', $task);
        return strtolower(end($explode));
    }

}
