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
	//Reaches into 'your_fiels' table in database and retrives the information.
	$meta = get_post_meta( $post->ID, 'your_fields', true ); ?>

	<input type="hidden" name="your_meta_box_nonce" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>">

	<p>
		<label for="your_fields[text]">Input Text</label>
		<br>
		<input type="text" name="your_fields[text]" id="your_fields[text]" class="regular-text" 
		value="<?php if (is_array($meta) && isset($meta['text'])) {	echo $meta['text'];	} //Fix 4 ?>"> 
	</p>

	<p>
		<label for="your_fields[textarea]">Textarea</label>
		<br>
		<textarea name="your_fields[textarea]" id="your_fields[textarea]" rows="5" cols="30" style="width:500px;"><?php if (is_array($meta) && isset($meta['textarea'])){echo $meta['textarea'];} //Fix 5 ?></textarea>
	</p>

	<p>
		<label for="your_fields[checkbox]">Checkbox
			<input type="checkbox" name="your_fields[checkbox]" value="checkbox" 
			<?php
			if (is_array($meta) && isset($meta['checkbox'])) { //Fix 6
				if ( $meta['checkbox'] === 'checkbox')
					echo 'checked'; 
			}
			?>>
		</label>
	</p>

	<p>
		<label for="your_fields[select]">Select Menu</label>
		<br>
		<select name="your_fields[select]" id="your_fields[select]">
			<option value="option-one" <?php if (is_array($meta) && isset($meta['select'])) { selected( $meta['select'], 'option-one' ); }?>>Option One</option>
			<option value="option-two" <?php if (is_array($meta) && isset($meta['select'])) {selected( $meta['select'], 'option-two' ); } ?>>Option Two</option>
		</select>
	</p>

	<p>
		<label for="your_fields[image]">Image Upload</label><br>
		<input type="text" name="your_fields[image]" id="your_fields[image]" class="meta-image regular-text" value="<?php if (is_array($meta) && isset($meta['image'])) { echo $meta['image']; } ?>">
		<input type="button" class="button image-upload" value="Browse">
	</p>
	<div class="image-preview"><img src="<?php if (is_array($meta) && isset($meta['checkbox'])) { echo $meta['image']; } ?>" style="max-width: 250px;"></div>

	<script>
    jQuery(document).ready(function ($) {
      // Instantiates the variable that holds the media library frame.
      var meta_image_frame;
      // Runs when the image button is clicked.
      $('.image-upload').click(function (e) {
        // Get preview pane
        var meta_image_preview = $(this).parent().parent().children('.image-preview');
        // Prevents the default action from occuring.
        e.preventDefault();
        var meta_image = $(this).parent().children('.meta-image');
        // If the frame already exists, re-open it.
        if (meta_image_frame) {
          meta_image_frame.open();
          return;
        }
        // Sets up the media library frame
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
          title: meta_image.title,
          button: {
            text: meta_image.button
          }
        });
        // Runs when an image is selected.
        meta_image_frame.on('select', function () {
          // Grabs the attachment selection and creates a JSON representation of the model.
          var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
          // Sends the attachment URL to our custom image input field.
          meta_image.val(media_attachment.url);
          meta_image_preview.children('img').attr('src', media_attachment.url);
        });
        // Opens the media library frame.
        meta_image_frame.open();
      });
    });
  </script>

	<?php }
//Save your field to database.
	function save_your_fields_meta( $post_id ) {   
	// verify nonce that are wordpress security tokens (number used once)
		if ( isset($_POST['your_meta_box_nonce']) //Fix 1
			&& !wp_verify_nonce( $_POST['your_meta_box_nonce'], basename(__FILE__) ) ) {
			return $post_id; 
		}
	// check autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
	// check permissions
		if (isset($_POST['post_type'])) { //Fix 2
			if ( 'page' === $_POST['post_type'] ) {
				if ( !current_user_can( 'edit_page', $post_id ) ) {
					return $post_id;
				} elseif ( !current_user_can( 'edit_post', $post_id ) ) {
					return $post_id;
				}  
			}
		}

		$old = get_post_meta( $post_id, 'your_fields', true );
		if (isset($_POST['your_fields'])) { //Fix 3
			$new = $_POST['your_fields'];

			if ( $new && $new !== $old ) {
				update_post_meta( $post_id, 'your_fields', $new );
			} elseif ( '' === $new && $old ) {
				delete_post_meta( $post_id, 'your_fields', $old );
			}
		}
	}
	add_action( 'save_post', 'save_your_fields_meta' );

	?>
