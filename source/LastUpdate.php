<?php namespace GitUpdate;

/**
 * lastUpdates: ['relativePath' => 'commitHash']
 */
class LastUpdate
{
    static $key = 'git-update-last-update';

    static function ofPlugin($relativePath)
    {
        return self::all()[$relativePath];
    }

    static function all()
    {
        return get_option(self::$key, []);
    }

    static function updateAll($lastUpdates)
    {
        update_option(self::$key, $lastUpdates);
    }

    static function withoutUpdate($plugins)
    {
        $lastUpdates = self::all();
        return array_filter($plugins, function ($relativePath) use ($lastUpdates) {
            return !in_array($relativePath, array_keys($lastUpdates));
        }, ARRAY_FILTER_USE_KEY);
    }

    static function set($relativePath, $commitHash)
    {
        $lastUpdates                = self::all();
        $lastUpdates[$relativePath] = $commitHash;
        self::updateAll($lastUpdates);
    }
}