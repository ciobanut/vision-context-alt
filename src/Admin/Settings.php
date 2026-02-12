<?php

namespace VisionContextAlt\Admin;

class Settings
{

    private string $option_name = 'visioncontext_alt_settings';

    public function register(): void
    {
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function register_settings(): void
    {
        register_setting(
            'visioncontext-alt',
            $this->option_name,
            [$this, 'sanitize']
        );
    }

    public function sanitize(array $input): array
    {
        $sanitized = [];
        $sanitized['api_key'] = isset($input['api_key']) ? sanitize_text_field($input['api_key']) : '';
        $sanitized['api_url'] = isset($input['api_url']) ? esc_url_raw($input['api_url']) : '';

        return $sanitized;
    }

    public function get_api_key(): string
    {
        $options = get_option($this->option_name, []);

        return isset($options['api_key']) ? (string) $options['api_key'] : '';
    }

    public function get_api_url(): string
    {
        $options = get_option($this->option_name, []);

        return isset($options['api_url']) ? (string) $options['api_url'] : '';
    }
}
