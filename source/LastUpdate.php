<?php namespace GitUpdate;

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
        return array_filter($array, function ($value, $key) use ($fn, $lastUpdates) {
            return $fn($key, $value, $lastUpdates);
        }, ARRAY_FILTER_USE_BOTH);
    }
}