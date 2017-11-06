<?php 
//Enqueue styles
function wordpress_custom_styles() {
	wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.7' );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js' , array('jquery'), '3.3.7', true);
}

add_action( 'wp_enqueue_scripts', 'wordpress_custom_styles' );

//Support post thumbnails
add_theme_support( 'post-thumbnails' ); 

function create_post_your_post() {
	register_post_type( 'your_post', //Register the post type with the id your_post
		array(
			'labels'       => array(
				'name'       => __( 'Your Post' ),
			),
			'public'       => true,
			'hierarchical' => true,
			'has_archive'  => true,
			'supports'     => array(
				'title', //Supports a title the_title()
				'editor', //Supports a editor the_content()
				'excerpt', //Supports the_excerpt()
				'thumbnail', //Supports the_post_thumbnail() / feature image
			), 
			'taxonomies'   => array( //Supports taxonomies or ways to group posts, with tags and categories.
				'post_tag',
				'category',
			)
		)
	);
	register_taxonomy_for_object_type( 'category', 'your_post' );
	register_taxonomy_for_object_type( 'post_tag', 'your_post' );
}

add_action( 'init', 'create_post_your_post' );

?>