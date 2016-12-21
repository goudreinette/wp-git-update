<?php namespace GitUpdate;

use Utils\Utils;

class Plugins
{
    static function withoutCommitHash()
    {
        return LastUpdate::filterUsingLastUpdates(self::relevant(), function ($relativePath, $pluginData, $lastUpdates) {
            return !in_array($relativePath, array_keys($lastUpdates));
        });
    }

    static function updateAvailable()
    {
        return LastUpdate::filterUsingLastUpdates(self::relevant(), function ($relativePath, $pluginData, $lastUpdates) {
            $repo       = Github::parseRepoUri($pluginData['PluginURI']);
            $lastCommit = Github::lastCommitHash($repo);

            return $lastUpdates[$relativePath] != $lastCommit && $lastCommit != null;
        });
    }

    static function relevant()
    {
        $all                 = get_plugins();
        $activeRelativePaths = get_option('active_plugins');
        $active              = array_intersect_key($all, array_flip($activeRelativePaths));
        $withoutSelf         = self::excludeSelf($active);
        $usesGit             = self::filterUsesGit($withoutSelf);
        return $usesGit;
    }

    static function excludeSelf($plugins)
    {
        return Utils::array_filter($plugins, function ($relativePath, $pluginData) {
            return strpos($relativePath, 'git-update') === false;
        });
    }


    static function filterUsesGit($plugins)
    {
        return array_filter($plugins, function ($plugin) {
            return strpos($plugin['PluginURI'], 'github') !== false;
        });
    }
}