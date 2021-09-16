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
$custom_frontend_type = get_theme_mod('wp_custom_frontend_type');

/**
 * Setup Timber
 */
if ($custom_frontend) {
	if ($custom_frontend_type == 'assets') {
		$template_path = ['templates', 'templates/elements'];
	} else {
		$template_path = ['templates', 'frontend/src/template/elements', 'frontend/src/template/page_templates'];
	}
} else {
	$template_path = ['templates', 'templates/elements'];
}

Timber::$dirname = $template_path;

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
	$context['cms'] = true;
	$context['environment'] = WP_ENV;
	$context['menu'] = new \Timber\Menu('main');
	$context['home'] = get_home_url();
	$context['current_permalink'] = get_permalink();

	// ACF enable
	if (class_exists('ACF')) {
		$context['options'] = get_fields('option');
	}
	// FrontEnd enable
	$custom_frontend = get_theme_mod('wp_custom_frontend');
	$custom_frontend_type = get_theme_mod('wp_custom_frontend_type');

	if ($custom_frontend) {
		$context['sprite'] = get_template_directory_uri() . '/frontend/dist';
		$context['frontend'] = get_template_directory_uri() . '/frontend/dist';

		$context['assets'] = '/frontend/dist/assets';

		$context['assetsImg'] = '/frontend/dist/images/';

		if ($custom_frontend_type === 'templates') {
			// Connect templates
			$context['connector'] = '/frontend/src/template/partials/';
		} elseif ($custom_frontend_type === 'mix') {
			// Connect templates
			$context['connector'] = '/frontend/src/template/partials/';
		} else {
			// Connect templates
			$context['connector'] = 'partials/';
		}
	} else {
		// Connect templates
		$context['connector'] = 'partials/';
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
	$twig->addFunction(new Timber\Twig_Function('sprite', 'sprite'));
	$twig->addFunction(new Timber\Twig_Function('renderCE', 'renderCE'));

	return $twig;
}

/**
 * Example
 *
 * @param $icon
 * @param $class
 * @return string
 */
function sprite($icon = null, $class = null)
{
	$sprite =
		"<svg class='sprite" .
		$icon .
		"'><use xlink:href='" .
		get_template_directory_uri() .
		'/frontend/dist/assets/img/symbol-sprite.svg#' .
		$icon .
		"'></use></svg>";

	return $sprite;
}

/**
 * Render Content Elements
 *
 * @param $elements
 * @param $gridEl
 * @return string
 */
function renderCE($elements)
{
	$custom_frontend = get_theme_mod('wp_custom_frontend');
	$custom_frontend_type = get_theme_mod('wp_custom_frontend_type');
	if ($custom_frontend) {
		if ($custom_frontend_type == 'templates') {
			$template_path = 'frontend/src/template/elements/';
		} elseif ($custom_frontend_type == 'mix') {
			$template_path = 'frontend/src/template/elements/';
		} else {
			$template_path = 'templates/elements/';
		}
	} else {
		$template_path = 'templates/elements/';
	}

	$elements = get_field($elements);

	if (!$elements || !is_array($elements) || !count($elements)) {
		return false;
	}

	$context = Timber::get_context();
	$post = Timber::get_post();
	$render = '';

	foreach ($elements as $key => $fields) {
		$context['ce'] = [
			'id' => $post->ID . $key,
		];

		foreach ($fields as $name => $value) {
			$context['ce'][$name] = $value;
		}

		$render .= Timber::compile($template_path . $fields['acf_fc_layout'] . '/_' . $fields['acf_fc_layout'] . '.twig', $context);
	}
	return $render;
}
