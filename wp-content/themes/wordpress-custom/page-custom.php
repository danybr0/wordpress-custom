<?php 
	/**
 	* Acording to the WordPress template hierarchy, a page-name.php will override page.php
 	* The page Custom was created in admin
 	*/
	get_header(); 
?>
	<div class="row">
		<div class="col-sm-12">
			<?php 
				$args =  array( 
					'post_type' => 'my-custom-post',
					'orderby' => 'menu_order',
					'order' => 'ASC'
				);
				 $custom_query = new WP_Query( $args );
            	while ($custom_query->have_posts()) : $custom_query->the_post(); ?>

				<div class="blog-post">
					<h2 class="blog-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php the_excerpt(); ?>
				</div>

				<?php endwhile; ?>
		</div> <!-- /.col -->
	</div> <!-- /.row -->

	<?php get_footer(); ?>