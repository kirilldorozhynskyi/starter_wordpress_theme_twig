<?php
/**
 * The Template for displaying all single posts
 *
 * @package justTheme
 * @since justTheme 1.0.0
 */

$context = Timber::get_context();
$context['post'] = new Timber\Post();
$context['templates'] = 'content/default.twig';

Timber::render('base.twig', $context);
