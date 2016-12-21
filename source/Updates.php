<?php namespace GitUpdate;


class Updates
{
    function __construct(Admin $admin)
    {
        $this->admin = $admin;
        $this->admin->connect($this);
        $this->setInitialCommitHash();
        $this->showUpdateNotices();
    }

    function showUpdateNotices()
    {
        foreach (Plugins::updateAvailable() as $relativePath => $pluginData) {
            $this->admin->showNotice($relativePath, $pluginData);
        }
    }

    function setInitialCommitHash()
    {
        foreach (Plugins::new() as $relativePath => $pluginData) {
            $repo       = Github::parseRepoUri($pluginData['PluginURI']);
            $lastCommit = Github::lastCommitHash($repo);
            LastUpdate::set($relativePath, $lastCommit);
        }
    }

    function update($repoUri, $relativePath)
    {
        $repo         = Github::parseRepoUri($repoUri);
        $absolutePath = Files::pluginAbsDir($relativePath);

        Github::downloadArchive($repo, $absolutePath);
        Files::extract($absolutePath);
        Composer::install($absolutePath);
        Files::cleanup($absolutePath);
    }
}