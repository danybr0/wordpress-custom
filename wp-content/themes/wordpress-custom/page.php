<?php /* page.php is the page index */ ?>

<?php get_header(); ?>

	<div class="row">
		<div class="col-sm-12">

			<?php 
				if ( have_posts() ) : while ( have_posts() ) : the_post();

  					/**
  					 * Load content.php
  					 */
					get_template_part( 'content', get_post_format() );
  
				endwhile; 
				endif; 
			?>

		</div> <!-- /.col -->
	</div> <!-- /.row -->

<?php get_footer(); ?>

