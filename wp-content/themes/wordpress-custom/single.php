<?php /* This page is a copy of page.php, but this is an individual post page. */ ?>

<?php get_header(); ?>

	<div class="row">
		<div class="col-sm-12">

			<?php 
				if ( have_posts() ) : while ( have_posts() ) : the_post();

  					/**
  					 * Load content-single.php
  					 */
					get_template_part( 'content-single', get_post_format() );
  
				endwhile; 
				endif; 
			?>

		</div> <!-- /.col -->
	</div> <!-- /.row -->

<?php get_footer(); ?>

