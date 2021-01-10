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

	$img = get_post_thumbnail_id( $post );
	$thumb_size  = get_page_template_slug( $post ) === '' ? 'large' : 'medium_large';
	$img_html    = '';
	$caption     = '';

	if ( $img ) {
		$img_html  = ucfwp_get_attachment_image( $img, $thumb_size, false, array(
			'class' => 'img-fluid post-header-image'
		) );
	}

	if ( $img_html ) {
		ob_start();
		$caption = get_the_post_thumbnail_caption( $post );
?>
		<figure class="figure d-block mb-4 mb-md-5 mx-auto">
			<div class="bg-faded text-center">
				<?php echo $img_html; ?>
			</div>

			<?php if ( $caption ) : ?>
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


/**
 * Returns a stylized list of recent posts.
 *
 * @since 1.0.0
 * @author Cadie Stockman
 * @param object $post WP_Post object
 * @return string HTML for the related posts list
 */
function get_post_recent( $post ) {

	$posts = get_posts( array(
		'numberposts'  => 3,
		'post__not_in' => array( $post->ID )
	) );

	ob_start();
	if ( $posts ):
?>
	<h2 class="text-center h5 text-uppercase mb-4 mb-md-5">Recent News</h2>

	<div class="row">
	<?php foreach ( $posts as $p ) :
		$title     = wptexturize( $p->post_title );
		$permalink = get_permalink( $p );
		$date      = date( 'M j, Y', strtotime( $p->post_date ) );
	?>
		<div class="col-lg-4">
			<article class="mb-4" aria-label="<?php echo esc_attr( $title ); ?>">
				<a href="<?php echo $permalink; ?>" class="text-secondary">
					<h3 class="h6"><?php echo $title; ?></h3>
					<span class="d-block small text-default-aw"><?php echo $date; ?></span>
				</a>
			</article>
		</div>
	<?php endforeach; ?>
	</div>
<?php
	endif;
	return ob_get_clean();
}

