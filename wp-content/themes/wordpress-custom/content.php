<div class="blog-post">
	<h2 class="blog-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	<p class="blog-post-meta"><?php the_date(); ?> by <a href="#"><?php the_author(); ?></a>
		&bull;
		<a href="<?php comments_link(); ?>">
			<?php
			/**
			 * Show how many comments are or link to the comments on the main page.
			 */
				printf( _nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comments title', 'textdomain' ), number_format_i18n( get_comments_number() ) ); ?>
		</a>
	</p>


	<?php 
	 	/**
	 	 * Excerpt only shows the first 55 characters.
	 	 */
 		the_excerpt(); 
 	?>

</div><!-- /.blog-post -->