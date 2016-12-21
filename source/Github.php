<?php namespace GitUpdate;

use Requests;

class Github
{
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
        $lastCommitsUri = "https://api.github.com/repos/$repo[user]/$repo[repo]/commits";
        $res            = Requests::get($lastCommitsUri, ['Accept' => 'application/json']);
        return json_decode($res->body, true)[0]['sha'];
    }

    static function downloadArchive($repo, $absolutePath)
    {
        $archiveUri = "https://github.com/$repo[user]/$repo[repo]/archive/master.zip";
        file_put_contents("$absolutePath.zip", fopen($archiveUri, 'r'));
    }
}