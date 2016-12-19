<?php namespace GitUpdate;

use Utils\Persist;
use Utils\Utils;

class Plugin
{
    use Persist;

    public $name;
    public $path;
    public $repository;
    public $branch;
    public $lastUpdated;
    public $updateAvailable;


    function update()
    {

    }

    function download()
    {

    }

    function overwrite()
    {

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

    static function createForNew()
    {
        $existing  = self::all();
        $installed = get_plugins();
        $new       = array_filter($installed, function ($plugin) use ($existing) {
            return !in_array($plugin['PluginURI'], Utils::array_pluck($existing, 'repository'));
        });

        foreach ($new as $name => $plugin) {
            $gitPlugin             = new Plugin();
            $gitPlugin->repository = $plugin['PluginURI'];
            $gitPlugin->branch     = 'master';
            $gitPlugin->name       = $plugin['Name'];
        }
    }
}