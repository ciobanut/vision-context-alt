<?php

namespace VisionContextAlt\Admin;

class Assets
{

    private Settings $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function register(): void
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_menu_icon_styles']);
    }

    public function enqueue_assets(string $hook_suffix): void
    {
        if ($hook_suffix !== 'toplevel_page_visioncontext-alt') {
            return;
        }

        $handle = 'visioncontext-alt-admin';
        $plugin_file = dirname(__DIR__, 2) . '/vision-context-alt.php';
        $base_url = plugin_dir_url($plugin_file);
        $script_url = $base_url . 'assets/js/admin.js';
        $style_url = $base_url . 'assets/css/admin.css';

        wp_enqueue_style($handle, $style_url, [], '1.0.0');
        wp_enqueue_script($handle, $script_url, ['jquery'], '1.0.0', true);

        wp_localize_script($handle, 'VisionContextAlt', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('visioncontext-alt'),
        ]);
    }

    public function enqueue_menu_icon_styles(): void
    {
        $handle = 'visioncontext-alt-menu';
        $plugin_file = dirname(__DIR__, 2) . '/vision-context-alt.php';
        $icon_url = plugin_dir_url($plugin_file) . 'assets/img/logo.svg';
        $icon_url = esc_url($icon_url);
        $css = '#toplevel_page_visioncontext-alt .wp-menu-image img{display:none;}
            #toplevel_page_visioncontext-alt .wp-menu-image{
                background-color: currentColor;
                -webkit-mask: url(' . $icon_url . ') no-repeat center / 20px 20px;
                mask: url(' . $icon_url . ') no-repeat center / 20px 20px;
            }';

        wp_register_style($handle, false, [], '1.0.0');
        wp_enqueue_style($handle);
        wp_add_inline_style($handle, $css);
    }
}
