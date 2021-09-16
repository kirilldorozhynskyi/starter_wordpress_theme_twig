[![GitHub release](https://img.shields.io/github/release/Naereen/StrapDown.js.svg)](https://github.com/kirilldorozhynskyi/starter_wordpress_theme_twig/releases)

# WordPress TWIG Starter

## Overview
This is WordPress theme with custom identity

## Features
- Dependency management with [Composer](https://getcomposer.org)

## Requirements

- PHP >= 7.1
- Composer - [Install](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)

## Installation

1. Create a new WordPress theme. In your /wp-content/themes/
   ```sh
   $ composer create-project justdev/jdwptheme theme-name
   ```
2. Open your WP admin and activate your new theme

## To use this theme you need to install:

 1. ACF or ACF PRO

For content development in this theme
[Download ACF](https://wordpress.org/plugins/advanced-custom-fields/)

 2. Timber

For timber development in this theme

[Download Timber](https://wordpress.org/plugins/timber-library/)

 3. Customize Web

For customize this theme in Theme Settings

localhost/wp-admin/customize.php

In the theme settings you can

- Disable gutenberg and all its styles and scripts

- Remove all standard styles and scripts

- Connect a custom frontend with such capabilities
	- Only assets (use css/js/images/icons from frontend)
	- Only templates (use twig templates from frontend)
	- Mix (use full frontend)

 4. FrontEnd

For use external frontend you need put in 'theme_name/frontend' you frontend from https://github.com/kirilldorozhynskyi/starter_frontend_twig
Or custom frontend developed by [starter_frontend_twig](https://github.com/kirilldorozhynskyi/starter_frontend_twig)

[Download FrontEnd](https://github.com/kirilldorozhynskyi/starter_frontend_twig)
And setup by instruction in git

After installing the theme, you can start developing your project