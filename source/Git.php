<?php namespace GitUpdate;

class Git
{
    static function filterGit($plugins)
    {
        return array_filter($plugins, function ($plugin) {
            return strpos($plugin['PluginURI'], 'github') !== false;
        });
    }

    static function parseRepoUri($repo)
    {
        $exploded = array_reverse(explode('/', $repo));
        return [
            'user' => $exploded[1],
            'repo' => $exploded[0]
        ];
    }

    static function lastCommitHash($repo)
    {
        $commits = file_get_contents("https://api.github.com/repos/$repo[user]/$repo[repo]/commits");
        return json_decode($commits)[0];
    }
}