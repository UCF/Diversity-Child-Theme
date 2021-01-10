<?php
use Diversity\Theme\Includes\Posts;

get_header(); the_post(); ?>

<?php
$header_media = Posts\get_post_header_media( $post );
$social = ( shortcode_exists( 'ucf-social-links' ) ) ? do_shortcode( '[ucf-social-links]' ) : '';
?>

<article class="<?php echo $post->post_status; ?> post-list-item" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
	<div class="container mt-3 mt-sm-4">
		<div class="row">
			<div class="col-xl-10 offset-xl-1">
				<?php echo $header_media; ?>
			</div>
		</div>
	</div>
	<div class="container mb-5 pb-sm-4">
		<div class="row mb-4">
			<div class="col-lg-10 offset-lg-1 px-lg-5 col-xl-8 offset-xl-2 px-xl-3">
				<div class="post-content">
					<?php the_content(); ?>
				</div>

				<?php if ( $social ) : ?>
				<div class="text-right">
					<?php echo $social; ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</article>

<?php get_footer(); ?>
