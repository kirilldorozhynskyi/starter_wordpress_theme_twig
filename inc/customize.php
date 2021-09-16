<?php
/**
 * _juststart: Customize settings
 *
 * @package justTheme
 * @since justTheme 1.0.0
 */

// Theme settings
if (!function_exists('jd_customize_register')) {
	function jd_customize_register($wp_customize)
	{
		$pages = get_pages();
		foreach ($pages as $page) {
			$values_for_select[$page->ID] = $page->post_title;
		}
		// Add and manipulate theme images to be used.
		$wp_customize->add_section('jd_theme_options', [
			'title' => __('Theme Settings', '_juststart'),
			'priority' => 168,
		]);

		// Guttenberg
		$wp_customize->add_setting('wp_gutenberg', [
			'capability' => 'edit_theme_options',
			'type' => 'theme_mod',
			'sanitize_callback' => 'jd_sanitize_checkbox',
		]);
		$wp_customize->add_control(
			new WP_Customize_Control($wp_customize, 'wp_gutenberg', [
				'label' => __('Disable Gutenberg', '_juststart'),
				'description' => __('Enable / disable WordPress gutenberg editor.', '_juststart'),
				'section' => 'jd_theme_options',
				'type' => 'checkbox',
				'settings' => 'wp_gutenberg',
			])
		);

		// Theme optimize
		$wp_customize->add_setting('wp_optimize', [
			'capability' => 'edit_theme_options',
			'type' => 'theme_mod',
			'sanitize_callback' => 'jd_sanitize_checkbox',
		]);
		$wp_customize->add_control(
			new WP_Customize_Control($wp_customize, 'wp_optimize', [
				'label' => __('Remove standart js/css', '_juststart'),
				'section' => 'jd_theme_options',
				'type' => 'checkbox',
				'settings' => 'wp_optimize',
			])
		);

		// Connect custom frontend
		$wp_customize->add_setting('wp_custom_frontend[theme_enable_frontend]', [
			'capability' => 'edit_theme_options',
			'type' => 'theme_mod',
			'sanitize_callback' => 'jd_sanitize_checkbox',
		]);
		$wp_customize->add_control(
			new WP_Customize_Control($wp_customize, 'wp_custom_frontend', [
				'label' => __('Theme use custom Front-End?', '_juststart'),
				'description' => __('Enable / disable custom frontend from theme_name/frontend', '_juststart'),
				'section' => 'jd_theme_options',
				'type' => 'checkbox',
				'settings' => 'wp_custom_frontend[theme_enable_frontend]',
			])
		);

		// Theme optimize
		$wp_customize->add_setting('wp_custom_frontend_type', [
			'capability' => 'edit_theme_options',
			'type' => 'theme_mod',
		]);
		$wp_customize->add_control(
			new WP_Customize_Control($wp_customize, 'wp_custom_frontend_type', [
				'label' => __('Select your Front-End type', '_juststart'),
				'description' => __('Select what kind of frontend do you whant use', '_juststart'),
				'section' => 'jd_theme_options',
				'type' => 'select',
				'active_callback' => 'jd_frontend_enabled',
				'choices' => [
					'assets' => __('Only assets', '_juststart'),
					'templates' => __('Only templates', '_juststart'),
					'mix' => __('Mix', '_juststart'),
				],
				'settings' => 'wp_custom_frontend_type',
			])
		);
	}
}

add_action('customize_register', 'jd_customize_register');

if (!function_exists('jd_sanitize_checkbox')) {
	/**
	 * Sanitize checbox
	 * @param type $value
	 * @return type
	 */
	function jd_sanitize_checkbox($value)
	{
		return isset($value) && true == $value ? true : false;
	}
}

function jd_frontend_enabled()
{
	$blueplanet_options = get_theme_mod('wp_custom_frontend');
	if (empty($blueplanet_options['theme_enable_frontend'])) {
		return false;
	}
	return true;
}
