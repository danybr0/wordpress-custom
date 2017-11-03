<?php /* index.php is the blog index */ ?>
<?php get_header(); ?>
<div class="row">

  <div class="col-sm-8 blog-main">
    <?php
        //The main loop. 
        if (have_posts() ) : 
          while (have_posts()) : 
            the_post(); 
            get_template_part('content', get_post_format()); 
          endwhile;
          ?>
          <nav>
            <ul class="pager">
              <li><?php next_posts_link( 'Anterior' ); ?></li>
              <li><?php previous_posts_link( 'Próximo' ); ?></li>
            </ul>
          </nav>
          <?php
        endif;
          
    ?>
  </div><!-- /.blog-main -->
  <?php get_sidebar(); ?>

</div><!-- /.row -->

<?php get_footer(); ?>
