<?php namespace GitUpdate;

use Utils\View;

class Admin
{
    /**
     * @var Updates
     */
    private $updates;

    function __construct(View $view)
    {
        $this->view = $view;
        add_action('admin_post_git_update', [$this, 'updateNow']);
    }

    function connect($updates)
    {
        $this->updates = $updates;
    }

    function showNotice($relativePath, $pluginData)
    {
        $this->view->render('notice', [
            'postUrl'      => admin_url('admin-post.php'),
            'relativePath' => $relativePath,
            'name'         => $pluginData['Name'],
            'repoUri'      => $pluginData['PluginURI']
        ]);
    }

    /**
     * TODO: Mooie plek om een exception te vangen en tonen.
     */
    function updateNow()
    {
        $this->updates->update($_POST['repoUri'], $_POST['relativePath']);
        wp_redirect(admin_url());
    }
}