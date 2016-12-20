<?php namespace GitUpdate;


class Updates
{
    static function check()
    {
        self::setLastUpdateToCurrentForNew();
    }

    static function setLastUpdateToCurrentForNew()
    {
        $newPlugins = LastUpdate::withoutUpdate(get_plugins());
        $usesGit    = Github::filterUsesGit($newPlugins);
        foreach ($usesGit as $relativePath => $pluginData) {
            $repo       = Github::parseRepoUri($pluginData['PluginURI']);
            $lastCommit = Github::lastCommitHash($repo);
            LastUpdate::set($relativePath, $lastCommit);
        }
    }

    static function update($repo, $dir)
    {
        Github::downloadArchive($repo, $dir);
        Files::extract($dir);
        Composer::install($dir);
    }
}