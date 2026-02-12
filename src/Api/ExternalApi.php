<?php
class ExternalApi {

    public function fetch_data() {
        $response = wp_remote_get('https://api.example.com');

        if (is_wp_error($response)) {
            return false;
        }

        return json_decode(wp_remote_retrieve_body($response), true);
    }
}
