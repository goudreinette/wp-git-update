<?php namespace GitUpdate;

/*
Plugin Name: GitUpdate
Plugin URI: https://github.com/reinvdwoerd/wp-git-update
Description:
Version: 1.0
Author: reinvdwoerd
Author URI: reinvdwoerd.herokuapp.com
License: -
Text Domain: git-update
*/

/**
 * Autoload
 *  if (!is_ajax()) {
 * $admin   = new Admin($view);
 * $updates = new Updates($admin);
 * }
 */

require __DIR__ . '/vendor/autoload.php';

use Utils\PluginContext;

class GitUpdate extends PluginContext
{
    public $base = 'git-update';
}

new GitUpdate();