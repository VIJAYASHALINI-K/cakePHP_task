<?php
use Cake\Core\Configure;

if ( ! Configure::check('CacheCleaner') )
    Configure::load('CacheCleaner.config', 'default');