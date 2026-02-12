<?php

namespace VisionContextAlt\Api;

use VisionContextAlt\Admin\Settings;

class ExternalApi
{

    private Settings $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function request_alt_text(array $payload): string
    {
        $api_url = $this->settings->get_api_url();

        if ($api_url === '') {
            return '';
        }

        $response = wp_remote_post($api_url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->settings->get_api_key(),
                'Content-Type' => 'application/json',
            ],
            'body' => wp_json_encode($payload),
            'timeout' => 20,
        ]);

        if (is_wp_error($response)) {
            return '';
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);

        return isset($body['alt_text']) ? (string) $body['alt_text'] : '';
    }
}
