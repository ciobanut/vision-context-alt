<?php
/**
 * Plugin Name: Image Alt Text Generator – Context-Aware AI by VisionContext
 * Plugin URI:  https://visioncontext.cloud
 * Description: Automatically generate accurate, context-aware alt text for WordPress images. Improve accessibility and SEO with AI-powered image descriptions.
 * Version:     1.0.0
 * Author:      Ciobanu Tudor
 * Author URI:  https://ciobanut.com
 * License:     GPL2
 * Text Domain: vision-context-alt
 */


// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
} else {
    spl_autoload_register(function (string $class): void {
        $prefix = 'VisionContextAlt\\';
        $base_dir = __DIR__ . '/src/';

        if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
            return;
        }

        $relative_class = substr($class, strlen($prefix));
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

        if (file_exists($file)) {
            require_once $file;
        }
    });
}

use VisionContextAlt\Admin\AdminPage;
use VisionContextAlt\Admin\Assets;
use VisionContextAlt\Admin\Settings;
use VisionContextAlt\Api\AjaxHandler;
use VisionContextAlt\Api\ExternalApi;
use VisionContextAlt\Core\Plugin;
use VisionContextAlt\Services\AltTextQualityService;
use VisionContextAlt\Services\AltTextUpdateService;
use VisionContextAlt\Services\DataService;
use VisionContextAlt\Services\MediaQueryService;
use VisionContextAlt\Services\QueueService;

$settings = new Settings();
$admin_page = new AdminPage($settings);
$assets = new Assets($settings);
$external_api = new ExternalApi($settings);
$quality_service = new AltTextQualityService();
$media_query_service = new MediaQueryService();
$queue_service = new QueueService();
$alt_update_service = new AltTextUpdateService();
$data_service = new DataService(
    $external_api,
    $quality_service,
    $media_query_service,
    $queue_service,
    $alt_update_service
);
$ajax_handler = new AjaxHandler($data_service);

$plugin = new Plugin($admin_page, $assets, $settings, $ajax_handler);
$plugin->run();