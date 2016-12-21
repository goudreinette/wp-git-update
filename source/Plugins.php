<?php namespace GitUpdate;


class Plugins
{
    static function new()
    {
        return LastUpdate::notUpdatedYet(self::relevant());
    }

    static function updateAvailable()
    {
        return LastUpdate::filterUpdateAvailable(self::relevant());
    }

    static function excludeSelf($plugins)
    {
        return array_filter($plugins, function ($relativePath) {
            return strpos($relativePath, 'git-update') === false;
        }, ARRAY_FILTER_USE_KEY);
    }

    static function relevant()
    {
        $all                 = get_plugins();
        $activeRelativePaths = get_option('active_plugins');
        $active              = array_intersect_key($all, array_flip($activeRelativePaths));
        $withoutSelf         = self::excludeSelf($active);
        $usesGit             = Github::filterUsesGit($withoutSelf);
        return $usesGit;
    }
}