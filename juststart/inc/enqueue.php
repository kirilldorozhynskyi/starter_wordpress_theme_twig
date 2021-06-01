<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package justTheme
 * @since justTheme 1.0.0
 */

/**
 * Enqueue scripts and styles.
 */
function jd_style()
{
    $custom_frontend = get_theme_mod('wp_custom_frontend');

    if ($custom_frontend) {
        $frontend = '/frontend/dist/assets/css/main.css';
        $file = get_template_directory() . $frontend;
        if (file_exists($file)) {
            $the_theme = wp_get_theme();
            $theme_version = $the_theme->get('Version');
            $css_version = $theme_version . '.' . filemtime($file);
            wp_enqueue_style('jd-styles', get_stylesheet_directory_uri() . $frontend, [], $css_version);
        }
    }
}
add_action('wp_enqueue_scripts', 'jd_style');

function jd_scripts()
{
    $custom_frontend = get_theme_mod('wp_custom_frontend');
    if ($custom_frontend) {
        $frontend = '/frontend/dist/assets/js/main.js';
        $file = get_template_directory() . $frontend;
        if (file_exists($file)) {
            $the_theme = wp_get_theme();
            $theme_version = $the_theme->get('Version');
            $js_version = $theme_version . '.' . filemtime($file);
            wp_enqueue_script('jd-script', get_stylesheet_directory_uri() . $frontend, [], $js_version);
        }
    }
}
add_action('wp_footer', 'jd_scripts');
