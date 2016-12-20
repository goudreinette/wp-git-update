<?php namespace GitUpdate;


class Updates
{
    static function check()
    {
        self::setInitialCommitHash();
        self::showUpdateNotices();
    }

    static function showUpdateNotices()
    {
        $plugins = Github::filterUsesGit(get_plugins());
        foreach (LastUpdate::availableUpdates($plugins) as $relativePath => $pluginData) {
            Admin::showNotice($pluginData['Name']);
        }
    }

    static function setInitialCommitHash()
    {
        $usesGit    = Github::filterUsesGit(get_plugins());
        $newPlugins = LastUpdate::notUpdatedYet($usesGit);
        foreach ($newPlugins as $relativePath => $pluginData) {
            $repo       = Github::parseRepoUri($pluginData['PluginURI']);
            $lastCommit = Github::lastCommitHash($repo);
            LastUpdate::set($relativePath, $lastCommit);
        }
    }

    static function update($repo, $relativePath)
    {
        Github::downloadArchive($repo, $relativePath);
        Files::extract($relativePath);
        Composer::install($relativePath);
    }
}