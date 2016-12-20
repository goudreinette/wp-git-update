<?php namespace GitUpdate;


class Admin
{
    static function init()
    {
        add_action('wp_ajax_git_update_now', self::class . '::updateNow');
    }

    static function showNotice()
    {

    }

    static function showUpdate()
    {

    }

    static function updateNow()
    {

    }
}