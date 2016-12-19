<?php namespace GitUpdate;


class Updater
{
    static $key = 'git-update-last-update';

    static function check()
    {
        $plugins     = get_plugins();
        $gitPlugins  = Git::filterGit($plugins);
        $lastUpdates = self::getLastUpdates();

        foreach ($gitPlugins as $file => $data) {
            $repo       = Git::parseRepoUri($data['PluginURI']);
            $lastCommit = Git::lastCommitHash($repo);
            $lastUpdate = $lastUpdates[$file];
        }
    }

    static function update()
    {

    }

    static function getLastUpdates()
    {
        get_option(self::$key, []);
    }

    static function updateLastUpdates($array)
    {
        update_option(self::$key, $array);
    }
}