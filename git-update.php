<?php namespace GitUpdate;

/*
Plugin Name: GitUpdate
Plugin URI: https://github.com/reinvdwoerd/git-update
Description:
Version: 1.0
Author: reinvdwoerd
Author URI: reinvdwoerd.herokuapp.com
License: -
Text Domain: git-update
*/

/**
 * Directory
 */
$root = plugin_dir_url(__FILE__);
$path = plugin_dir_path(__FILE__);


/**
 * Autoload
 */
require __DIR__ . '/vendor/autoload.php';


/**
 * View
 */
use Utils\View;

$view = new View($root);
new Admin($view);


/**
 * Run on init
 */
add_action('init', function () {

});

add_action('admin_init', function () use ($view) {
});

/**
 * Translations
 */
add_action('plugins_loaded', function () {
    load_plugin_textdomain('git-update', false, dirname(plugin_basename(__FILE__)));
});
