<?php namespace GitUpdate;

/**
 * All paths are absolute.
 */
class Files
{
    static function pluginRelativeDir($file)
    {
        return explode('/', $file)[0];
    }

    static function pluginsDir()
    {
        return wp_normalize_path(WP_PLUGIN_DIR);
    }

    static function pluginAbsDir($pluginMainFile)
    {
        return self::pluginsDir() . self::pluginRelativeDir($pluginMainFile);
    }

    static function extract($fullpath)
    {
        $zip = new \ZipArchive;
        $zip->open("$fullpath.zip");
        $zip->extractTo("$fullpath-temp");
    }
}