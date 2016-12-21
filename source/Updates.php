<?php namespace GitUpdate;

use bookin\composer\api\Composer;

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
        $composer     = Composer::getInstance("$absolutePath-master/composer.json", "$absolutePath-master");

        Github::downloadArchive($repo, $absolutePath);
        Files::extract($absolutePath);
        $composer::runCommand('install');
        Files::cleanup($absolutePath);
    }
}