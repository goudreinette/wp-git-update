<?php namespace GitUpdate;

use Utils\Utils;

/**
 * lastUpdates: ['relativePath' => 'commitHash']
 */
class LastUpdate
{
    static $key = 'git-update-last-update';

    static function get()
    {
        return get_option(self::$key, []);
    }

    static function set($relativePath, $commitHash)
    {
        $lastUpdates                = self::get();
        $lastUpdates[$relativePath] = $commitHash;
        update_option(self::$key, $lastUpdates);
    }

    static function filterUsingLastUpdates($array, $fn)
    {
        $lastUpdates = self::get();
        return Updates::array_filter($array, function ($key, $value) use ($fn, $lastUpdates) {
            return $fn($key, $value, $lastUpdates);
        });
    }
}