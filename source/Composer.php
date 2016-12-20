<?php namespace GitUpdate;


class Composer
{

    static function install($fullpath)
    {
        putenv("COMPOSER_HOME=$fullpath//vendor/bin/composer");
        $input       = new ArrayInput(['command' => 'install']);
        $application = new Application();
        $application->setAutoExit(false);
        $application->run($input);
    }
}