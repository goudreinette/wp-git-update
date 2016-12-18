<?php namespace GitUpdate;

class Update
{
    function __construct($pluginName, $repository, $branch, $localPath, $composer)
    {
        $this->pluginName = $pluginName;
        $this->repository = $repository;
        $this->branch     = $branch;
        $this->localPath  = $localPath;
        $this->composer   = $composer;
    }

    private function download()
    {

    }

    private function overwrite()
    {

    }

    private function installDeps()
    {

    }
}