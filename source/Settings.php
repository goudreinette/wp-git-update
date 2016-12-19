<?php namespace GitUpdate;


use Utils\OptionPersist;

class Settings
{
    use OptionPersist;
    static $key = 'git-update-settings';

    public $autoUpdate = false;
}