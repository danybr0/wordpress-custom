<?php /* page.php is the page index */ ?>

<?php 
	/**
	 * The contents of a custom post can be put on anywhere.
	 * It was put here for testing purposes.
	 */
	$args = array(
		'post_type' => 'your_post',
	);  
	$your_loop = new WP_Query( $args ); 

	if ( $your_loop->have_posts() ) : while ( $your_loop->have_posts() ) : $your_loop->the_post(); 
		$meta = get_post_meta( $post->ID, 'your_fields', true ); ?>

		<!-- contents of Your Post -->

	<?php endwhile; endif; wp_reset_postdata(); ?>


?>