<?php
/**
 * _juststart: Customize settings
 *
 * @link https://www.advancedcustomfields.com/resources/
 *
 * @package justTheme
 * @since justTheme 1.0.0
 */

/**
 * Saving explained
 */
add_filter('acf/settings/save_json', 'jd_acf_json_save_point');

function jd_acf_json_save_point($path)
{
    // update path
    $path = get_stylesheet_directory() . '/acf_json';

    // return
    return $path;
}

/**
 * Loading Explained
 */

add_filter('acf/settings/load_json', 'jd_acf_json_load_point');

function jd_acf_json_load_point($paths)
{
    // remove original path (optional)
    unset($paths[0]);

    // append path
    $paths[] = get_stylesheet_directory() . '/acf_json';

    // return
    return $paths;
}

// Add acf page setings
add_action('acf/init', 'jd_acf_init');

function jd_acf_init()
{
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page([
            'page_title' => __('Theme General Settings', '_juststart'),
            'menu_title' => __('Theme Settings', '_juststart'),
            'menu_slug' => 'theme-general-settings',
            'post_id' => 'options',
            'capability' => 'edit_posts',
            'redirect' => 'false',
        ]);
        acf_add_options_sub_page([
            'page_title' => __('Default Settings', '_juststart'),
            'menu_title' => __('Default', '_juststart'),
            'menu_slug' => 'theme-default-settings',
            'parent_slug' => 'theme-general-settings',
        ]);
    }
}
