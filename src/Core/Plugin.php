<?php
namespace MyPlugin\Core;

class Plugin {

    public function run() {
        $this->init_admin();
        $this->init_api();
    }

    private function init_admin() {
        new \MyPlugin\Admin\AdminPage();
        new \MyPlugin\Admin\Assets();
    }

    private function init_api() {
        new \MyPlugin\Api\AjaxHandler();
    }
}
