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
        $plugin_file = dirname(__DIR__, 2) . '/vision-context-alt.php';
        $icon_url = plugin_dir_url($plugin_file) . 'assets/img/logo.svg';

        add_menu_page(
            __('VisionContext Alt', 'visioncontext-alt'),
            __('VisionContext Alt', 'visioncontext-alt'),
            'manage_options',
            'visioncontext-alt',
            [$this, 'render'],
            esc_url($icon_url)
        );
    }

    public function render(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        $api_key = $this->settings->get_api_key();
        ?>
        <div class="wrap">
            <h1><?= esc_html__('VisionContext Alt Text', 'visioncontext-alt') ?></h1>
            <p><?= esc_html__('Configure the API and run the generator.', 'visioncontext-alt') ?></p>
            <form method="post" action="options.php">
                <?php settings_fields('visioncontext-alt'); ?>
                <table class="form-table" role="presentation">
                    <tr>
                        <th scope="row">
                            <label for="vc-api-key"><?= esc_html__('API Key', 'visioncontext-alt') ?></label>
                        </th>
                        <td>
                            <input type="text" id="vc-api-key" name="visioncontext_alt_settings[api_key]" class="regular-text"
                                value="<?= esc_attr($api_key) ?>" />
                            <p class="description">
                                <?= esc_html__('Paste your API key and save changes.', 'visioncontext-alt') ?>
                            </p>
                        </td>
                    </tr>
                </table>
                <?php submit_button(__('Save Settings', 'visioncontext-alt')); ?>
            </form>
            <p>
                <button class="button" id="vc-api-key-check">
                    <?= esc_html__('Check API Key', 'visioncontext-alt') ?>
                </button>
                <button class="button button-primary" id="vc-alt-generate">
                    <?= esc_html__('Generate Alt Text', 'visioncontext-alt') ?>
                </button>
            </p>
        </div>
        <?php
    }
}
