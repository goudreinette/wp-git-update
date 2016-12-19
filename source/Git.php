<?php namespace GitUpdate;

use Requests;

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
        $res = Requests::get("https://api.github.com/repos/$repo[user]/$repo[repo]/commits"
            , ['Accept' => 'application/json']);

        return json_decode($res->body, true)[0]['sha'];
    }
}