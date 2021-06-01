<?php
/**
 * _juststart: functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package justTheme
 * @since justTheme 1.0.0
 */

if (!defined('ABSPATH')) {
    exit(); // Exit if accessed directly.
}

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
if (!class_exists('Timber') or !class_exists('ACF')) {
    if (!class_exists('Timber')) {
        add_action('admin_notices', function () {
            echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin <a href="https://wordpress.org/plugins/timber-library/">Timber</a></p></div>';
        });
    }

    if (!class_exists('ACF')) {
        add_action('admin_notices', function () {
            echo '<div class="error"><p>ACF or ACF PRO not activated. Make sure you activate the plugin <a href="https://wordpress.org/plugins/advanced-custom-fields/">ACF</a></p></div>';
        });
    }

    add_filter('template_include', function ($template) {
        return get_stylesheet_directory() . '/static/no-timber.html';
    });
    return;
}

$jd_includes = ['/timber-settings.php', '/theme-settings.php', '/enqueue.php', '/customize.php', '/acf-settings.php', '/custom-posts.php'];

foreach ($jd_includes as $file) {
    $filepath = locate_template('inc' . $file);
    if ($filepath) {
        require_once $filepath;
    } else {
        echo nl2br('Error locating /inc' . $file . " for inclusion \n");
    }
}
