<?php
/**
 * Functions related to the display of single posts.
 */
namespace Diversity\Theme\Includes\Posts;

/**
 * Returns an image to display at the top of a
 * post, depending on meta field settings.
 *
 * @since 1.0.0
 * @author Cadie Stockman
 * @param object $post WP_Post object
 * @return string HTML markup for the header media
 */
function get_post_header_media( $post ) {
	$media = '';

	$img = get_field( 'post_header_image', $post );
	$thumb_size  = get_page_template_slug( $post ) === '' ? 'large' : 'medium_large';
	$img_html    = '';
	$min_width   = 730;  // Minimum acceptable, non-fluid width of a <figure>.
							// Loosely based on maximum size of post content column in default and two-col templates.
							// Should be a width that comfortably fits one or more lines of an image caption.
	$max_width   = 1140; // Default max-width value for <figure>
	$thumb_width = 0;    // Default calculated width of the thumbnail at $thumb_size.
	$caption     = '';

	if ( $img ) {
		$img_html  = ucfwp_get_attachment_image( $img['ID'], $thumb_size, false, array(
			'class' => 'img-fluid post-header-image'
		) );

		// Calculate a max-width for the <figure> here so that
		// an included image caption doesn't exceed the width
		// of the image.
		//
		// Allow larger images (those above the $min_width threshold)
		// to be centered in the story without a visible gray
		// background.
		// For smaller images, display them centered within a
		// full-width div with a gray bg.
		if ( isset( $img['sizes'][$thumb_size . '-width'] ) ) {
			$thumb_width = intval( $img['sizes'][$thumb_size . '-width'] );
		}
		if ( $thumb_width >= $min_width ) {
			$max_width = $thumb_width;
		}
	}

	if ( $img_html ) {
		ob_start();
		$caption = wptexturize( $img['caption'] );
?>
		<figure class="figure d-block mb-4 mb-md-5 mx-auto" style="max-width: <?php echo $max_width; ?>px;">
			<div class="bg-faded text-center">
				<?php echo $img_html; ?>
			</div>

			<?php if ( $caption ): ?>
			<figcaption class="figure-caption mt-2">
				<?php echo $caption; ?>
			</figcaption>
			<?php endif; ?>
		</figure>
<?php
		$media = ob_get_clean();
	}

	return $media;
}
