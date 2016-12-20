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
        $plugins = Github::filterUsesGit($this->getActivePlugins());
        foreach (LastUpdate::filterUpdateAvailable($plugins) as $relativePath => $pluginData) {
            $this->admin->showNotice($relativePath, $pluginData, $this);
        }
    }

    function setInitialCommitHash()
    {
        $usesGit    = Github::filterUsesGit($this->getActivePlugins());
        $newPlugins = LastUpdate::notUpdatedYet($usesGit);
        foreach ($newPlugins as $relativePath => $pluginData) {
            $repo       = Github::parseRepoUri($pluginData['PluginURI']);
            $lastCommit = Github::lastCommitHash($repo);
            LastUpdate::set($relativePath, $lastCommit);
        }
    }

    /**
     * TODO: Naar WooUtils
     */
    function getActivePlugins()
    {
        $active = get_option('active_plugins');
        $all    = get_plugins();
        return array_filter($all, function ($relativePath) use ($active) {
            return in_array($relativePath, $active) && strpos($relativePath, 'git-update') === false;
        }, ARRAY_FILTER_USE_KEY);
    }

    function update($repoUri, $relativePath)
    {
        $repo         = Github::parseRepoUri($repoUri);
        $absolutePath = Files::pluginAbsDir($relativePath);

        Github::downloadArchive($repo, $absolutePath);
        Files::extract($absolutePath);
//        Composer::install($absolutePath);
        Files::cleanup($absolutePath);
    }
}