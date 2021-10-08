<?php
/**
 * Header content template for Posts
 */
?>

<?php
global $post;

$title     = wptexturize( $post->post_title );
$post_date = date( 'F j, Y', strtotime( $post->post_date ) );
?>

<?php if ( $title ) : ?>
<div class="container mt-4 mt-md-5">
	<div class="row">
		<div class="col-xl-10 offset-xl-1">

			<h1 class="mb-3">
				<?php echo $title; ?>
			</h1>

			<?php if ( $post_date ) : ?>
			<span class="text-default-aw d-block mb-3"><?php echo $post_date; ?></span>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php endif; ?>
