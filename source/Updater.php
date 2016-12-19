<?php namespace GitUpdate;


class Updater
{
    static $key = 'git-update-last-update';

    static function check()
    {
        $plugins     = get_plugins();
        $gitPlugins  = Git::filterGit($plugins);
        $lastUpdates = self::getLastUpdates();

        foreach ($gitPlugins as $file => $data) {
            $repo       = Git::parseRepoUri($data['PluginURI']);
            $lastCommit = Git::lastCommitHash($repo);
            $lastUpdate = $lastUpdates[$file];

            if ($lastUpdate != $lastCommit) {
                self::update($repo, self::pluginDir($file));
            }
        }
    }

    static function update($repo, $dir)
    {
        $pluginsdir = wp_normalize_path(WP_PLUGIN_DIR);
        $fullpath   = "$pluginsdir/$dir";
        self::download($repo, $fullpath);
        self::unzip($fullpath);
        self::getDeps("$fullpath");
    }

    static function getDeps($fullpath)
    {
        putenv("COMPOSER_HOME=$fullpath//vendor/bin/composer");
        $input       = new ArrayInput(['command' => 'install']);
        $application = new Application();
        $application->setAutoExit(false);
        $application->run($input);
    }

    static function download($repo, $fullpath)
    {
        $plugin_dir = wp_normalize_path(WP_PLUGIN_DIR);
        $zip        = "https://github.com/$repo[user]/$repo[repo]/archive/master.zip";
        file_put_contents("$fullpath.zip", fopen($zip, 'r'));
    }

    static function unzip($fullpath)
    {
        $zip = new \ZipArchive;
        $zip->open("$fullpath.zip");
        $zip->extractTo("$fullpath-temp");
    }

    static function pluginDir($file)
    {
        return explode('/', $file)[0];
    }

    static function getLastUpdates()
    {
        get_option(self::$key, []);
    }

    static function updateLastUpdates($array)
    {
        update_option(self::$key, $array);
    }
}