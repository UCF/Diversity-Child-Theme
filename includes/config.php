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


/**
 * Adds a custom ACF WYSIWYG toolbar called 'Inline Text' that only includes
 * simple inline text formatting tools and link insertion/deletion.
 *
 * Ported over from UCF/FinAid-Child-Theme
 *
 * @since 1.0.0
 * @author Jo Dickson: FinAid-Child-Theme
 * @param array $toolbars Array of toolbar information from ACF
 * @return array
 */
function acf_inline_text_toolbar( $toolbars ) {
	$toolbars['Inline Text'] = array();
	$toolbars['Inline Text'][1] = array( 'bold', 'italic', 'link', 'unlink', 'undo', 'redo' );
	return $toolbars;
}

add_filter( 'acf/fields/wysiwyg/toolbars', __NAMESPACE__ . '\acf_inline_text_toolbar' );


/**
 * Moves the page WYSIWYG editor to a placeholder field within the
 * Section Fields group.
 *
 * Ported over from UCF/FinAid-Child-Theme
 *
 * @since 1.0.0
 * @author Jo Dickson: FinAid-Child-Theme
 * @return void
 */
function acf_section_wysiwyg_position() {
?>
<script type="text/javascript">
	(function($) {
		$(document).ready(function(){
			// 5d9ca92819a1c = "Basic Section Content" Message field (placeholder)
			$('.acf-field-5d9ca92819a1c .acf-input').append( $('#postdivrich') );
		});
	})(jQuery);
</script>
<style type="text/css">
	.acf-field #wp-content-editor-tools {
		background: transparent;
		padding-top: 0;
	}
</style>
<?php
}

add_action( 'acf/input/admin_head', __NAMESPACE__ . '\acf_section_wysiwyg_position' );
