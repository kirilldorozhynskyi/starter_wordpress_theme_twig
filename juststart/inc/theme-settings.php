<?php
/**
 * _juststart: Theme settings
 *
 * @link https://timber.github.io/docs/
 *
 * @package justTheme
 * @since justTheme 1.0.0
 */

/**
 * Get WordPress Theme Settings
 */
$wp_gutenberg = get_theme_mod('wp_gutenberg');
$wp_optimize = get_theme_mod('wp_optimize');

/**
 * Remove Gutenberg Block Library CSS from loading on the frontend
 */
if ($wp_gutenberg) {
    add_filter('use_block_editor_for_post', '__return_false');
    function jd_remove_wp_block_library_css()
    {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-block-style'); // Remove WooCommerce block CSS
    }
    add_action('wp_enqueue_scripts', 'jd_remove_wp_block_library_css', 100);
}

/**
 * Add svg support
 */
function jd_svg_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'jd_svg_types');

/**
 * Add title support
 */
function jd_setup_theme()
{
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'jd_setup_theme');

/**
 * Optimize WP
 */
if ($wp_optimize) {
    function disable_emojis()
    {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
        add_filter('wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2);
    }
    add_action('init', 'disable_emojis');

    function disable_emojis_tinymce($plugins)
    {
        if (is_array($plugins)) {
            return array_diff($plugins, ['wpemoji']);
        } else {
            return [];
        }
    }

    function disable_emojis_remove_dns_prefetch($urls, $relation_type)
    {
        if ('dns-prefetch' == $relation_type) {
            /** This filter is documented in wp-includes/formatting.php */
            $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');

            $urls = array_diff($urls, [$emoji_svg_url]);
        }
        return $urls;
    }

    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'wp_resource_hints', 2);
    remove_action('wp_head', 'rest_output_link_wp_head', 10);

    function jd_remove_version()
    {
        return '';
    }
    add_filter('the_generator', 'jd_remove_version');

    function jd_deregister_scripts()
    {
        wp_deregister_script('wp-embed');
    }
    add_action('wp_footer', 'jd_deregister_scripts');
}

/**
 * WordPress translate
 */
function jd_load_theme_textdomain()
{
    load_theme_textdomain('_juststart', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'jd_load_theme_textdomain');

/**
 * Thumbnail support
 */
function jd_post_thumbnails()
{
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'jd_post_thumbnails');

/**
 * Remove the main menu item together with the subpages /submenus
 */
if (WP_ENV == 'prod' or WP_ENV == 'staging') {
    add_action('admin_menu', 'remove_admin_menu_items', 999);

    function remove_admin_menu_items()
    {
        remove_menu_page('edit.php');
        remove_menu_page('edit-comments.php');
        remove_submenu_page('themes.php', 'customize.php?return=' . urlencode(str_replace(get_bloginfo('url'), '', get_admin_url())) . 'themes.php');
        remove_submenu_page('themes.php', 'customize.php?return=%2Fwp-admin%2Findex.php');
        remove_submenu_page('themes.php', 'theme-editor.php');
        remove_submenu_page('themes.php', 'customize.php');
    }
    add_filter('acf/settings/show_admin', '__return_false');

    add_action('current_screen', 'jd_restrict_admin_pages');
    function tcd_restrict_admin_pages()
    {
        $current_screen_id = get_current_screen()->id;

        $restricted_screens = ['edit-post', 'customize', 'theme-editor', 'edit-comments', 'edit-acf-field-group'];
        foreach ($restricted_screens as $restricted_screen) {
            if ($current_screen_id === $restricted_screen) {
                wp_die(__('You are not allowed to access this page.', 'tcd'));
            }
        }
    }
}
