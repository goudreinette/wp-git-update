<?php namespace GitUpdate;

/**
 * All paths are absolute.
 */
class Files
{
    static function pluginDirname($relativePath)
    {
        return explode('/', $relativePath)[0];
    }

    static function pluginsDir()
    {
        return wp_normalize_path(WP_PLUGIN_DIR);
    }

    static function pluginAbsDir($relativePath)
    {
        return self::pluginsDir() . '/' . self::pluginDirname($relativePath);
    }


    static function extract($fullpath)
    {
        $zip = new \ZipArchive;
        $zip->open("$fullpath.zip");
        $zip->extractTo("$fullpath-temp");
    }
}