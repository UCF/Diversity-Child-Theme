<?php
/**
 * Handle all theme configuration here
 **/
namespace Diversity\Theme\Includes\Config;


define( 'DIVERSITY_THEME_URL', get_stylesheet_directory_uri() );
define( 'DIVERSITY_THEME_STATIC_URL', DIVERSITY_THEME_URL . '/static' );
define( 'DIVERSITY_THEME_CSS_URL', DIVERSITY_THEME_STATIC_URL . '/css' );
define( 'DIVERSITY_THEME_JS_URL', DIVERSITY_THEME_STATIC_URL . '/js' );
define( 'DIVERSITY_THEME_IMG_URL', DIVERSITY_THEME_STATIC_URL . '/img' );


/**
 * Initialization functions to be fired early when WordPress loads the theme.
 *
 * @since 1.0.0
 * @return void
 */
function init() {
	// Adds support for Yoast-generated breadcrumbs.
	add_theme_support( 'yoast-seo-breadcrumbs' );
}

add_action( 'after_setup_theme', __NAMESPACE__ . '\init', 11 );
