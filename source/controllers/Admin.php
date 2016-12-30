<?php namespace GitUpdate;

use Utils\PluginContext;

class Admin
{
    /**
     * @var PluginContext
     */
    public $context;
    /**
     * @var \Utils\View
     */
    public $view;

    function __construct()
    {
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
        $this->context->controllers->updates->update($_POST['repoUri'], $_POST['relativePath']);
        wp_redirect(admin_url());
    }
}