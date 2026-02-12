<?php

namespace VisionContextAlt\Admin;

class AdminPage
{

    private Settings $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function register(): void
    {
        add_action('admin_menu', [$this, 'add_menu_page']);
    }

    public function add_menu_page(): void
    {
        add_menu_page(
            __('VisionContext Alt Text', 'visioncontext-alt'),
            __('VisionContext Alt Text', 'visioncontext-alt'),
            'manage_options',
            'visioncontext-alt',
            [$this, 'render'],
            'dashicons-welcome-view-site'
        );
    }

    public function render(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        echo '<div class="wrap">';
        echo '<h1>' . esc_html__('VisionContext Alt Text', 'visioncontext-alt') . '</h1>';
        echo '<p>' . esc_html__('Configure the API and run the generator.', 'visioncontext-alt') . '</p>';
        echo '<button class="button button-primary" id="vc-alt-generate">' . esc_html__('Generate Alt Text', 'visioncontext-alt') . '</button>';
        echo '</div>';
    }
}
