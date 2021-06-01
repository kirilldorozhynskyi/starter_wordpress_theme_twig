<?php
/**
 * The search template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package justTheme
 * @since justTheme 1.0.0
 */

$context = Timber::get_context();
$context['post'] = new Timber\Post();
$context['templates'] = 'content/default.twig';

Timber::render('base.twig', $context);
