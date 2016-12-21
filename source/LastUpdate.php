<?php namespace GitUpdate;

/**
 * lastUpdates: ['relativePath' => 'commitHash']
 */
class LastUpdate
{
    static $key = 'git-update-last-update';

    static function get()
    {
        return get_option(self::$key, []);
    }

    static function filterUsingLastUpdates($array, $fn)
    {
        $lastUpdates = self::get();
        return array_filter($array, function ($value, $key) use ($fn, $lastUpdates) {
            return $fn($key, $value, $lastUpdates);
        }, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * Law of Demeter?
     * @param $plugins array
     * @return array
     */
    static function filterUpdateAvailable($plugins)
    {
        return self::filterUsingLastUpdates($plugins, function ($relativePath, $pluginData, $lastUpdates) {
            $repo       = Github::parseRepoUri($pluginData['PluginURI']);
            $lastCommit = Github::lastCommitHash($repo);
            return $lastUpdates[$relativePath] != $lastCommit;
        });
    }

    static function notUpdatedYet($plugins)
    {
        return self::filterUsingLastUpdates($plugins, function ($relativePath, $pluginData, $lastUpdates) {
            return !in_array($relativePath, array_keys($lastUpdates));
        });
    }

    static function set($relativePath, $commitHash)
    {
        $lastUpdates                = self::get();
        $lastUpdates[$relativePath] = $commitHash;
        update_option(self::$key, $lastUpdates);
    }
}