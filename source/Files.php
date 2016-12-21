<?php namespace GitUpdate;

use Utils\Utils;

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


    static function extract($absolutePath)
    {
        $zip = new \ZipArchive;
        $zip->open("$absolutePath.zip");
        $zip->extractTo(self::pluginsDir());
        unlink("$absolutePath.zip");
    }

    static function cleanup($absolutePath)
    {
        self::removeDirectory($absolutePath);
        rename("$absolutePath-master", $absolutePath);
    }


    /**
     *TODO: Packagist?
     */
    static function removeDirectory($path)
    {
        if (is_link($path) || is_file($path)) {
            unlink($path);
        } else if (is_dir($path)) {
            $files = glob($path . '/*');
            foreach ($files as $file) {
                self::removeDirectory($file);
            }
            rmdir($path);
        }
    }
}