<?php namespace GitUpdate;


use Utils\PluginContext;

class Updates
{
    /**
     * @var PluginContext
     */
    public $context;

    function __construct()
    {
        add_action('admin_init', [$this, 'init']);
    }

    function init()
    {
        $this->setInitialCommitHash();
        $this->showUpdateNotices();
    }

    static function array_filter($array, $function)
    {
        $result = [];
        foreach ($array as $key => $value) {
            if ($function($key, $value))
                $result[$key] = $value;
        }
        return $result;
    }

    function showUpdateNotices()
    {
        foreach (Plugins::updateAvailable() as $relativePath => $pluginData) {
            $this->context->controllers->admin->showNotice($relativePath, $pluginData);
        }
    }

    function setInitialCommitHash()
    {
        foreach (Plugins::withoutCommitHash() as $relativePath => $pluginData) {
            $repo       = Github::parseRepoUri($pluginData['PluginURI']);
            $lastCommit = Github::lastCommitHash($repo);
            LastUpdate::set($relativePath, $lastCommit);
        }
    }

    function update($repoUri, $relativePath)
    {
        $repo           = Github::parseRepoUri($repoUri);
        $lastCommitHash = Github::lastCommitHash($repo);
        $absolutePath   = Files::pluginAbsDir($relativePath);
        $composer       = new ComposerAPI("$absolutePath-master");

        Github::downloadArchive($repo, $absolutePath);
        Files::extract($absolutePath);
        $composer->install();
        Files::cleanup($absolutePath);
        LastUpdate::set($relativePath, $lastCommitHash);
    }
}