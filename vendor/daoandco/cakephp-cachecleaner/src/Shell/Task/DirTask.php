<?php
namespace CacheCleaner\Shell\Task;

use Cake\Console\Shell;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

class DirTask extends Shell implements TaskInterface {

    protected $Dir;
    protected $_cacheDirs;

    public function initialize() {
        parent::initialize();

        $this->Dir = new Folder(CACHE);
        $this->_cacheDirs = ( Configure::read('CacheCleaner.Dir.dirs') === true ) ? $this->Dir->read()[0] : Configure::read('CacheCleaner.Dir.dirs');
    }

    /**
     * Display help for this console.
     *
     * @return ConsoleOptionParser
     */
    public function getOptionParser() {
        $parser = new ConsoleOptionParser('console');
        $parser
            ->setDescription('Clear directories in "tmp/cache/"')
            ->setCommand("dir")
            ->addOption('all', [
                'short' => 'a',
                'help' => 'Clear all directories',
                'boolean' => true,
            ])
            ;
        return $parser;
    }

    public function help() {
        return 'Clear directories in "tmp/cache/"';
    }

    public function main() {

        if ( $this->params['all'] )
            return $this->_clearDirs(true);

        if ( $this->args )
            return $this->_clearDirs($this->args);

        $this->out("Usage : ");
        $this->out($this->nl(1));
        $this->out('bin/cake cache.clear dir dir_name');
        $this->out('bin/cake cache.clear dir dir_name other_dir_name');
        $this->out('bin/cake cache.clear dir --all');
        $this->out('bin/cake cache.clear dir -a');

        $this->hr();

        $this->out("Directories : ");
        $this->out($this->nl(1));
        $this->out($this->_cacheDirs);
    }

    /**
     * Clear all dirs
     * @return void
     */
    public function all() {
        $this->_clearDirs(true);
    }

    /**
     * Clear dirs
     * @param  array $dirsToClear : dirs names
     * @return void
     */
    protected function _clearDirs($dirsToClear) {

        if ( $dirsToClear === true )
            $dirsToClear = $this->_cacheDirs;

        foreach ( $dirsToClear as $dir ) {
            if ( $this->_clearDir($dir) )
                $this->success("Dir {$dir} clear complete");
        }
    }

    /**
     * Clear a dir
     * @param  string $dir : dir name
     * @return bool
     */
    protected function _clearDir($dir) {

        $dirPath = $this->Dir->pwd() . $dir;

        if ( ! $this->isExistFolder($dir) ) {
            $this->err("Error : directory {$dir} not exist");
            return false;
        }

        if ( ! $this->Dir->delete($dirPath) ) {
            $this->err("Error : delete directory {$dir} failed");
            $this->verbose($this->Dir->errors());
            return false;
        }

        if ( ! $this->Dir->create($dirPath, 0777) ) {
            $this->err("Error : recreate directory {$dir} failed");
            $this->verbose($this->Dir->errors());
            return false;
        }

        return true;
    }

    protected function isExistFolder($dir) {
        return in_array($dir, $this->Dir->read()[0]);
    }
}
