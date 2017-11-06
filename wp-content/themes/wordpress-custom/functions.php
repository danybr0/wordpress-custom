<?php
//Enqueue styles
function wordpress_custom_styles() {
	wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.7' );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js' , array('jquery'), '3.3.7', true);
}

add_action( 'wp_enqueue_scripts', 'wordpress_custom_styles' );

// Add Google Fonts
function wordpress_custom_google_fonts() {
	wp_register_style('OpenSans', 'http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800');
	wp_enqueue_style( 'OpenSans');
}

add_action('wp_print_styles', 'wordpress_custom_google_fonts');

//Wordpress titles
//Show the title of the article first, and also include a reference to the main site title.
add_theme_support( 'title-tag');

// Custom settings
function custom_settings_add_menu() {
	add_menu_page( 'Custom Settings', 'Custom Settings', 'manage_options', 'custom-settings', 'custom_settings_page', null, 99 );
}
add_action( 'admin_menu', 'custom_settings_add_menu' );

// Create Custom Global Settings basic page
function custom_settings_page() { ?>
<div class="wrap">
	<h1>Custom Settings</h1>
	<form method="post" action="options.php">
		<?php
		settings_fields( 'section' );
		do_settings_sections( 'theme-options' );      
		submit_button(); 
		?>          
	</form>
</div>
<?php }

// Input field for Twitter
function setting_twitter() { ?>
<input type="text" name="twitter" id="twitter" value="<?php echo get_option( 'twitter' ); ?>" />
<?php }

//Input field for GitHub
function setting_github() { ?>
<input type="text" name="github" id="github" value="<?php echo get_option('github'); ?>" />
<?php }

//Show, accept and save the options fields
//These options are showed in sidebar.php
function custom_settings_page_setup() {
	add_settings_section( 'section', 'All Settings', null, 'theme-options' );
	add_settings_field( 'twitter', 'Twitter URL', 'setting_twitter', 'theme-options', 'section' );
	add_settings_field( 'github', 'GitHub URL', 'setting_github', 'theme-options', 'section' );
	
	register_setting( 'section', 'twitter' );
	register_setting( 'section', 'github' );
}

add_action( 'admin_init', 'custom_settings_page_setup' );

// Support Featured Images
add_theme_support( 'post-thumbnails' );

// Custom Post Type
/**
 * If the original URL was example.com, then, the custom post type would appear 
 * at example.com/my-custom-post
 */
function create_my_custom_post() {
	register_post_type( 'my-custom-post',
		array(
			'labels' => array(
				'name' => __( 'My Custom Post' ),
				'singular_name' => __( 'My Custom Post' ),
			),
			'public' => true,
			'has_archive' => true,
			'supports' => array(
				'title', //Is the field called with <?php the_title( );
				'editor', //is the content editing area that are called with <?php the_content( );
				'thumbnail', //Feature image <?php the_post_thumbnail( )
				'custom-fields' 
			)
		));
}
add_action( 'init', 'create_my_custom_post' );

?>