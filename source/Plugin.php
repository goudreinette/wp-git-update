<?php namespace GitUpdate;

use Utils\MetaPersist;

class Plugin
{
    use MetaPersist;
    static $key = 'git-update-plugin';

    private $id;
    public $name;
    public $path;
    public $repository;
    public $branch;
    public $lastUpdated;
    public $updateAvailable;

    static function all()
    {
        $all = array_map(function ($pluginArray) {
            $plugin = new Plugin();

        }, get_plugins());

    }

    /**
     * @param $plugins Plugin[]
     * @return array
     */
    static function usesGit($plugins)
    {
        return array_filter($plugins, function (Plugin $plugin) {
            return strpos($plugin->repository, 'git') !== false;
        });
    }

    function defaults()
    {

    }

    function update()
    {

    }

    function download()
    {

    }

    function overwrite()
    {

    }
}