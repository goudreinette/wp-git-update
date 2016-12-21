<?php namespace GitUpdate;

use kabachello\ComposerAPI\ComposerAPI;

class Composer
{
    static function install($absolutePath)
    {
        $composer = new ComposerAPI($absolutePath);
        $composer->install();
    }
}