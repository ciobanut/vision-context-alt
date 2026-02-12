<?php
namespace VisionContextAlt\Core;

use VisionContextAlt\Admin\AdminPage;
use VisionContextAlt\Admin\Assets;
use VisionContextAlt\Admin\Settings;
use VisionContextAlt\Api\AjaxHandler;

class Plugin
{

    private AdminPage $admin_page;
    private Assets $assets;
    private Settings $settings;
    private AjaxHandler $ajax_handler;

    public function __construct(
        AdminPage $admin_page,
        Assets $assets,
        Settings $settings,
        AjaxHandler $ajax_handler
    ) {
        $this->admin_page = $admin_page;
        $this->assets = $assets;
        $this->settings = $settings;
        $this->ajax_handler = $ajax_handler;
    }

    public function run()
    {
        $this->settings->register();
        $this->admin_page->register();
        $this->assets->register();
        $this->ajax_handler->register();
    }
}
