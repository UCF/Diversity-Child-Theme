<?php
/**
 * Header Related Functions
 **/


 /**
 * Modifies what header content type is returned for a given object.
 *
 * @since 1.0.0
 * @param string $content_type The determined header content type
 * @param mixed $obj A queried object (e.g. WP_Post, WP_Term), or null
 * @return string The determined header content type
 */
function diversity_get_header_content_type( $content_type, $obj ) {
	if ( $obj instanceof WP_Post ) {
		$post_type = $obj->post_type;

		if ( $post_type === 'post' ) {
			$content_type = 'post';
		}
	}

	return $content_type;
}

add_filter( 'ucfwp_get_header_content_type', 'diversity_get_header_content_type', 11, 2 );
