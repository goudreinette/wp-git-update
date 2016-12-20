<?php namespace GitUpdate;

/**
 * lastUpdates array is 'relativePath' => 'commitHash'
 */
class LastUpdate
{
    static function ofPlugin($relativePath)
    {
        return self::getLastUpdates()[$relativePath];
    }

    static function all()
    {
        get_option(Updates::$key, []);
    }

    static function updateAll($array)
    {
        update_option(Updates::$key, $array);
    }

    static function newPlugins()
    {
        $lastUpdates = self::all();
        $all         = get_plugins();
        return array_filter($all, function ($relativePath) use ($lastUpdates) {
            return !in_array($relativePath, array_keys($lastUpdates));
        }, ARRAY_FILTER_USE_KEY);
    }
}