<?php

namespace VisionContextAlt\Api;

use VisionContextAlt\Services\DataService;

class AjaxHandler
{

    private DataService $data_service;

    public function __construct(DataService $data_service)
    {
        $this->data_service = $data_service;
    }

    public function register(): void
    {
        add_action('wp_ajax_visioncontext_alt_generate', [$this, 'handle_generate']);
    }

    public function handle_generate(): void
    {
        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => 'Insufficient permissions.'], 403);
        }

        check_ajax_referer('visioncontext-alt', 'nonce');

        $result = $this->data_service->process_next();

        wp_send_json_success($result);
    }
}
