<?php namespace GitUpdate;


class Plugins
{
    static function excludeSelf($plugins)
    {
        return array_filter($plugins, function ($relativePath) {
            return strpos($relativePath, 'git-update') === false;
        }, ARRAY_FILTER_USE_KEY);
    }

    static function all()
    {
        $all                 = get_plugins();
        $activeRelativePaths = get_option('active_plugins');
        $active              = array_intersect_key($all, $activeRelativePaths);
        $withoutSelf         = self::excludeSelf($active);
        $usesGit             = Github::filterUsesGit($withoutSelf);
        return $usesGit;
    }

    static function new()
    {
        return LastUpdate::notUpdatedYet(self::all());
    }

    static function updateAvailable()
    {
        return LastUpdate::filterUpdateAvailable(self::all());
    }
}