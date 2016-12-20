<?php namespace GitUpdate;


class Updates
{
    static $key = 'git-update-last-update';

    static function check()
    {
        $plugins     = get_plugins();
        $gitPlugins  = Github::filterGit($plugins);
        $lastUpdates = LastUpdate::getLastUpdates();

        foreach ($gitPlugins as $file => $data) {
            $repo       = Github::parseRepoUri($data['PluginURI']);
            $lastCommit = Github::lastCommitHash($repo);
            $lastUpdate = $lastUpdates[$file];

            if ($lastUpdate != $lastCommit) {
                self::update($repo, Files::pluginAbsDir($file));
            }
        }
    }

    static function update($repo, $dir)
    {
        Github::downloadArchive($repo, $fullpath);
        Files::extract($fullpath);
        Composer::install("$fullpath");
    }

}