<?php
/**
 * _juststart: Timber settings
 *
 * @link https://timber.github.io/docs/
 *
 * @package justTheme
 * @since justTheme 1.0.0
 */

/**
 * Get WordPress Theme Settings
 */
$custom_frontend = get_theme_mod('wp_custom_frontend');

/**
 * Setup Timber
 */
if ($custom_frontend) {
    $template_paath = ['templates', 'frontend/src/template/elements', 'frontend/src/template/page_templates'];
} else {
    $template_paath = ['templates'];
}

Timber::$dirname = $template_paath;

/**
 * APPLICATION_VERSION for debug
 */
$the_theme = wp_get_theme();
$theme_version = $the_theme->get('Version');
define('APPLICATION_VERSION', $theme_version);

/**
 * Timber context
 */
function jd_timber_context($context)
{
    $context['WP_ENV'] = WP_ENV;
    $context['menu'] = new \Timber\Menu('main');
    $context['home'] = get_home_url();
    $context['current_permalink'] = get_permalink();

    // ACF enable
    if (!class_exists('ACF')) {
        $context['options'] = get_fields('option');
    }
    // FrontEnd enable
    $custom_frontend = get_theme_mod('wp_custom_frontend');

    if ($custom_frontend) {
        $context['sprite'] = get_template_directory_uri() . '/frontend/dist';
        $context['assetsImg'] = '/frontend/dist/images';
        $context['assets'] = '/frontend/dist/assets';
    }

    return $context;
}
add_filter('timber_context', 'jd_timber_context');

/**
 * Change Timber's cache folder.
 * We want to use wp-content/cache/timber
 */
function jd_change_twig_cache_dir()
{
    return WP_CONTENT_DIR . '/cache/timber';
}
add_filter('timber/cache/location', 'jd_change_twig_cache_dir');

if (WP_ENV == 'prod') {
    $cache_mode = Timber\Loader::CACHE_USE_DEFAULT;
    $expires = 600;
    Timber::$cache = true;
} else {
    $cache_mode = Timber\Loader::CACHE_NONE;
    $expires = 0;
    Timber::$cache = false;
}

/**
 * Timber's custom functions.
 */
add_filter('timber/twig', 'add_to_twig');
function add_to_twig($twig)
{
    // Adding a function.
    $twig->addFunction(new Timber\Twig_Function('example', 'example'));
    return $twig;
}

/**
 * Example
 *
 * @param $text
 * @return string
 */
function example($text = null)
{
    return $text;
}
