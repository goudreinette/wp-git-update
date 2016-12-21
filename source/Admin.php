<?php namespace GitUpdate;

use Utils\View;

class Admin
{
    /**
     * @var Updates
     */
    private $updates;

    function connect($updates)
    {
        $this->updates = $updates;
    }

    function __construct(View $view)
    {
        $this->view = $view;
        add_action('admin_post_git_update', [$this, 'updateNow']);
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

    function showSuccess()
    {

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