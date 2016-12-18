<?php namespace GitUpdate;

use Utils\View;


class Admin
{
    static $key = 'git-update';

    function __construct(View $view)
    {
        $this->view = $view;
        add_action('admin_menu', [$this, 'addPluginPage']);
    }

    function addPluginPage()
    {
        add_menu_page('Git Update', 'Git Update', 'manage_options', self::$key, [$this, 'show']);
    }

    function show()
    {
        $this->view->enqueueStyle('style');
        $this->view->render('admin', [
            'plugins' => [
                ['name' => 'WooEvents', 'repository' => 'https://github.com/reinvdwoerd/woo-events.git', 'lastUpdated' => human_time_diff(strtotime('20-12-2016')), 'branches' => ['master', 'oo']],
                ['name' => 'AddToCart', 'repository' => 'https://github.com/reinvdwoerd/add-to-cart.git', 'lastUpdated' => human_time_diff(strtotime('16-12-2016')), 'branches' => ['master']]
            ]
        ]);
    }

    function save()
    {

    }

    function updateNow()
    {

    }
}