<div class="blog-post">
  <h2 class="blog-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
  <p class="blog-post-meta"><?php the_date(); ?> by <a href="#"><?php the_author(); ?></a></p>

 <?php 
 	/**
 	 * Excerpt only shows the first 55 characters.
 	 */
 	the_excerpt(); 
 ?>

</div><!-- /.blog-post -->