<?php
function wordpress_custom_styles() {
    wp_enqueue_style( 'style', get_template_directory_uri() . '/css/style.css' );
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.7' );
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js' , array('jquery'), '3.3.7', true);
}
add_action( 'wp_enqueue_scripts', 'wordpress_custom_styles' );
?>