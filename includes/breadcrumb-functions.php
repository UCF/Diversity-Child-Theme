<?php
/**
 * Functions that define and add breadcrumb markup to pages
 */
namespace Diversity\Theme\Includes\Breadcrumb;


/**
 * Filters editable Yoast breadcrumb options
 *
 * Adapted from FinAid-Child-Theme.
 *
 * @since 1.0.0
 * @param array $options Array of `wpseo_titles` options + values
 * @return array Modified array of options + values
 */
function filter_yoast_options_breadcrumbs( $options ) {
	// Force breadcrumb separator value to always be empty
	$options['breadcrumbs-sep'] = '';
	// Force bolding on last breadcrumb items (consistent with Athena Framework
	// styling; generated markup is modified in `breadcrumb_single_link`)
	$options['breadcrumbs-boldlast'] = true;
	// Force "Taxonomy to show in breadcrumbs for content types"
	// for FAQs to always be set to "None" (this site manages all
	// FAQ archives manually using pages)
	$options['post_types-faq-maintax'] = 0;

	return $options;
}


/**
 * Returns the desired top-level wrapper element
 * for breadcrumbs generated by Yoast.
 *
 * Adapted from FinAid-Child-Theme.
 *
 * @since 1.0.0
 * @param string $element HTML element name
 * @return string HTML element name
 */
function breadcrumb_output_wrapper( $element ) {
	return 'ol';
}


/**
 * Returns the desired HTML classes to apply to the top-level
 * wrapper element for breadcrumbs generated by Yoast.
 *
 * Adapted from FinAid-Child-Theme.
 *
 * @since 1.0.0
 * @param string $element HTML class name
 * @return string HTML class name
 */
function breadcrumb_output_class( $class ) {
	return 'breadcrumb mb-0';
}


/**
 * Returns the desired wrapper element for individual links
 * in breadcrumbs generated by Yoast.
 *
 * Adapted from FinAid-Child-Theme.
 *
 * @since 1.0.0
 * @param string $element HTML element name
 * @return string HTML element name
 */
function breadcrumb_single_link_wrapper( $element ) {
	return 'li';
}


/**
 * Returns the desired breadcrumb separator in breadcrumbs
 * generated by Yoast.
 *
 * Adapted from FinAid-Child-Theme.
 *
 * @since 1.0.0
 * @param string $separator Provided separator value
 * @return string Modified separator value
 */
function breadcrumb_separator( $separator ) {
	return '';
}


/**
 * Modifies generated markup for a single list item in a Yoast breadcrumb.
 *
 * Adapted from FinAid-Child-Theme.
 *
 * @since 1.0.0
 * @param string $html Generated list item HTML
 * @param array $link Single link data
 * @return string Modified list item HTML
 */
function breadcrumb_single_link( $html, $link ) {
	// Add breadcrumb-item class to individual list items
	$html = str_replace( '<li>', '<li class="breadcrumb-item">', $html );
	// Disable <strong> tag usage around last breadcrumb item
	$html = str_replace( '<strong', '<li', $html );
	$html = str_replace( '</strong>', '</li>', $html );

	return $html;
}


/**
 * Modifies generated markup for breadcrumbs generated by Yoast.
 *
 * Adapted from FinAid-Child-Theme.
 *
 * @since 1.0.0
 * @param string $html Generated breadcrumb HTML
 * @return string Modified breadcrumb HTML
 */
function breadcrumb_output( $output ) {
	// Replace the 'last' class provided by Yoast with Athena classes
	$output = str_replace( 'breadcrumb_last', 'breadcrumb-item active', $output );
	return $output;
}


/**
 * Register all filters if Yoast breadcrumb logic is available.
 */
if ( function_exists( 'yoast_breadcrumb' ) ) {
	add_filter( 'option_wpseo_titles', __NAMESPACE__ . '\filter_yoast_options_breadcrumbs' );
	add_filter( 'wpseo_breadcrumb_output_wrapper', __NAMESPACE__ . '\breadcrumb_output_wrapper' );
	add_filter( 'wpseo_breadcrumb_output_class', __NAMESPACE__ . '\breadcrumb_output_class' );
	add_filter( 'wpseo_breadcrumb_single_link_wrapper', __NAMESPACE__ . '\breadcrumb_single_link_wrapper' );
	add_filter( 'wpseo_breadcrumb_separator', __NAMESPACE__ . '\breadcrumb_separator' );
	add_filter( 'wpseo_breadcrumb_single_link', __NAMESPACE__ . '\breadcrumb_single_link', 10, 2 );
	add_filter( 'wpseo_breadcrumb_output', __NAMESPACE__ . '\breadcrumb_output' );
}


/**
 * Returns breadcrumb markup if Yoast breadcrumb logic is available.
 *
 * Adapted from FinAid-Child-Theme.
 *
 * @since 1.0.0
 * @return string HTML markup for the breadcrumbs and wrapper container
 */
function get_breadcrumb_markup() {
	$markup = '';

	if ( ! is_home() && ! is_front_page() ) {
		if ( function_exists( 'yoast_breadcrumb' ) ) {
			ob_start();
		?>
		<nav class="site-breadcrumb bg-faded mb-0 py-3" aria-label="Breadcrumb">
			<div class="container">
				<?php echo yoast_breadcrumb( '', '', false ); ?>
			</div>
		</nav>
		<?php
			$markup = trim( ob_get_clean() );
		}
	}

	return $markup;
}
