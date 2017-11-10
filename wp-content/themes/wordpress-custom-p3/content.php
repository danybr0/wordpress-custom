<?php //index.php is pulling in this file ?>
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
		//split the page if a thumbnail is present 
		if ( has_post_thumbnail() ) { 
	?>
	<div class="row">
		<div class="col-md-4">
			<?php the_post_thumbnail('thumbnail'); ?>
		</div>
		<div class="col-md-6">
			<?php the_excerpt(); ?>
		</div>
	</div>
	<?php } else { ?>
	<?php 
		/**
	 	 * Excerpt only shows the first 55 characters.
	 	 */
	 	the_excerpt(); 
	 ?>
	<?php } ?>

</div><!-- /.blog-post -->