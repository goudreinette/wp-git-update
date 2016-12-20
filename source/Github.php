<?php namespace GitUpdate;

use Requests;

class Github
{
    static function filterUsesGit($plugins)
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

    static function lastCommitsUri($user, $repo)
    {
        return "https://github.com/$user/$repo/archive/master.zip";
    }

    static function archiveUri($user, $repo)
    {
        return "https://api.github.com/repos/$user/$repo/commits";
    }

    static function lastCommitHash($repo)
    {
        $res = Requests::get(self::archiveUri($repo['user'], $repo['repo']), ['Accept' => 'application/json']);
        return json_decode($res->body, true)[0]['sha'];
    }

    static function downloadArchive($repo, $path)
    {
        file_put_contents("$path.zip", fopen(self::archiveUri($repo['user'], $repo['repo']), 'r'));
    }
}