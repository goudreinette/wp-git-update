<?php namespace GitUpdate;

use Composer\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;

class Composer
{
    static function install($absolutePath)
    {
        $pluginPath = dirname(__DIR__);
        putenv("COMPOSER_HOME=$absolutePath-master/vendor/bin/composer");
        $input       = new ArrayInput(['command' => 'install']);
        $application = new Application();
        $application->setAutoExit(false);
        $application->run($input);
    }
}