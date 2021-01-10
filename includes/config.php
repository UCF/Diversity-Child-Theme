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
 * Hides the featured image metabox for standard posts in the WordPress admin.
 *
 * @since 1.0.0
 */
function remove_post_thumbnail_box() {
    remove_meta_box( 'postimagediv', 'post', 'side' );
}

add_action( 'do_meta_boxes', __NAMESPACE__ . '\remove_post_thumbnail_box' );
