<?php
class AjaxHandler {

    public function __construct() {
        add_action('wp_ajax_my_plugin_fetch', [$this, 'handle_fetch']);
    }

    public function handle_fetch() {
        check_ajax_referer('my_plugin_nonce', 'nonce');

        $api = new ExternalApi();
        $data = $api->fetch_data();

        wp_send_json_success($data);
    }
}
