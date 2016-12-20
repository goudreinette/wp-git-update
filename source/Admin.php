<?php namespace GitUpdate;

use Utils\View;

class Admin
{
    function __construct(View $view)
    {
        $this->view = $view;
        add_action('wp_ajax_git_update_now', self::class . '::updateNow');
    }

    function showNotice($name)
    {
        $this->view->render('notice', ['name' => $name]);
    }

    function showUpdate()
    {

    }

    function updateNow()
    {

    }
}