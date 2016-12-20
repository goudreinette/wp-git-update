<?php namespace GitUpdate;


class Updates
{
    function __construct(Admin $admin)
    {
        $this->admin = $admin;
        $this->setInitialCommitHash();
        $this->showUpdateNotices();
    }

    function showUpdateNotices()
    {
        $plugins = Github::filterUsesGit(get_plugins());
        foreach (LastUpdate::availableUpdates($plugins) as $relativePath => $pluginData) {
            $this->admin->showNotice($pluginData['Name']);
        }
    }

    function setInitialCommitHash()
    {
        $usesGit    = Github::filterUsesGit(get_plugins());
        $newPlugins = LastUpdate::notUpdatedYet($usesGit);
        foreach ($newPlugins as $relativePath => $pluginData) {
            $repo       = Github::parseRepoUri($pluginData['PluginURI']);
            $lastCommit = Github::lastCommitHash($repo);
            LastUpdate::set($relativePath, $lastCommit);
        }
    }

    function update($repo, $relativePath)
    {
        Github::downloadArchive($repo, $relativePath);
        Files::extract($relativePath);
        Composer::install($relativePath);
    }
}