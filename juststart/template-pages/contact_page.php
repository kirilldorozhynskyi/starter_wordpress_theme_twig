<?php
/**
 * Template Name: Contact page
 * File: /contact_page.php
 * Project: _juststart
 * Version: 1.0.0
 * Created Date: Saturday, June 5th 2021, 23:24:23
 * Author: Kirill Dorozhynskyi - kyrylo.dorozhynskyi@justdev.org
 * -----
 * Last Modified: Sunday, June 6th 2021 19:13:41
 * Modified By: Kirill Dorozhynskyi
 * -----
 * Copyright (c) 2021 justDev
 *
 * @package justTheme
 * @since justTheme 1.0.0
 */

$context = Timber::get_context();
$context['page'] = new Timber\Post();
$context['templates'] = 'page_templates/_contact_page.twig';

Timber::render('base.twig', $context);
