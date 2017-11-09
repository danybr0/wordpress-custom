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


function add_your_fields_meta_box() {
	add_meta_box(
		'your_fields_meta_box', // $id
		'Your Fields', // $title
		'show_your_fields_meta_box', // $callback
		'your_post', // $screen (or page). Where the meta box will be added. In this case, the custom post.  
		'normal', // $context
		'high' // $priority
	);
}

add_action( 'add_meta_boxes', 'add_your_fields_meta_box' );

/**
 * Display all your custom fields.
 */

function show_your_fields_meta_box() {
	global $post;  
		$meta = get_post_meta( $post->ID, 'your_fields', true ); ?>

	<input type="hidden" name="your_meta_box_nonce" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>">

    <!-- All fields will go here -->


<?php }

function save_your_fields_meta( $post_id ) {   
	// verify nonce that are wordpress security tokens (number used once)
	if ( !wp_verify_nonce( $_POST['your_fields'], basename(__FILE__) ) ) {
		return $post_id; 
	}
	// check autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}
	// check permissions
	if ( 'page' === $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		} elseif ( !current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}  
	}
	
	$old = get_post_meta( $post_id, 'your_fields', true );
	$new = $_POST['your_fields'];

	if ( $new && $new !== $old ) {
		update_post_meta( $post_id, 'your_fields', $new );
	} elseif ( '' === $new && $old ) {
		delete_post_meta( $post_id, 'your_fields', $old );
	}
}
add_action( 'save_post', 'save_your_fields_meta' );

?>
