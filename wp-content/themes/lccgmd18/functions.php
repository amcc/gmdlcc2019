<?php

/*------------------------------------*\
	Theme Support
\*------------------------------------*/
// allows an index.html file to exist
remove_filter('template_redirect', 'redirect_canonical');

// Add Menu Support
add_theme_support('menus');

// Add Thumbnail Theme Support
add_action( 'after_setup_theme', 'theme_setup' );

function theme_setup() {
  //add_theme_support('post-thumbnails');
  //add_image_size('student-thumb', 250, 250, true); // Large Thumbnail
  add_image_size('student-thumb-large', 500, 500, true); // Large Thumbnail
  add_image_size('student-admin-small', 500, 500, true); // Large Thumbnail
  // add_image_size('student-1920-1080-large', 1920, 1080); // Large Thumbnail
  //add_image_size('project-image', 850, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');
}

add_filter( 'jpeg_quality', create_function( '', 'return 90;' ) );

// disable resizing for gifs
// function disable_upload_sizes( $sizes, $metadata ) {
//
//     // Get filetype data.
//     $filetype = wp_check_filetype($metadata['file']);
//
//     // Check if is gif.
//     if($filetype['type'] == 'image/gif') {
//         // Unset sizes if file is gif.
//         $sizes = array();
//     }
//
//     // Return sizes you want to create from image (None if image is gif.)
//     return $sizes;
// }
// add_filter('intermediate_image_sizes_advanced', 'disable_upload_sizes', 10, 2);
/*------------------------------------*\
	Functions
\*------------------------------------*/

// Remove Admin bar
show_admin_bar(false);

// On Load
add_action( 'wp_enqueue_scripts', 'add_assets' );

// Add Assets
function add_assets() {

  // Functions Script
  wp_enqueue_script( 'packery', get_stylesheet_directory_uri() . '/library/js/packery.pkgd.js', array(), '', true );

  // Base Stylesheet
	wp_enqueue_style( 'base', get_stylesheet_directory_uri() . '/library/css/style.css', array(), '', 'all' );

  // Functions Script
  wp_enqueue_script( 'functions', get_stylesheet_directory_uri() . '/library/js/functions.js', array(), '', true );

  // Layzr Script
  wp_enqueue_script( 'layzr', get_stylesheet_directory_uri() . '/library/js/layzr.min.js', array(), '', true );

  // Full screen screenfull.min.js Script
  // https://github.com/sindresorhus/screenfull.js/
  wp_enqueue_script( 'isotope', get_stylesheet_directory_uri() . '/library/js/isotope.pkgd.min.js', array('jquery'), '1.12', true );

  // Base Script
  wp_enqueue_script( 'scripts', get_stylesheet_directory_uri() . '/library/js/scripts.js', array(), '', true );

}

// Add Menus
add_theme_support( 'menus' );

register_nav_menus(
  array(
    'header-nav' => __( 'Header Nav' ),   // main nav in header
    'footer-nav' => __( 'Footer Nav' ) // secondary nav in footer
  )
);

// Order by
add_filter( 'posts_orderby', function( $orderby, \WP_Query $q )
{
    if( 'wpse_last_word' === $q->get( 'orderby' ) && $get_order =  $q->get( 'order' ) )
    {
        if( in_array( strtoupper( $get_order ), ['ASC', 'DESC'] ) )
        {
            global $wpdb;
            $orderby = " SUBSTRING_INDEX( {$wpdb->posts}.post_title, ' ', -1 ) " . $get_order;
        }
    }
    return $orderby;
}, PHP_INT_MAX, 2 );

// Disable the uncategorised category
add_action('admin_head', 'my_custom_admin_css');

function my_custom_admin_css() {
  echo '<style>
      ul.categorychecklist #category-1 {
        display: none;
      }
    }
  </style>';
}

// Disable editor on pages
add_action( 'admin_init', 'hide_editor' );

function hide_editor() {
  remove_post_type_support('page', 'editor');
}

function theme_customize_register( $wp_customize ) {
  $wp_customize->add_section(
    'lcc_footer_text',
    array(
      'title'     => 'Footer Text',
      'priority'  => 200
    )
  );

  $wp_customize->add_setting(
    'lcc_footer_column1',
    array(
      'default'    =>  '',
      'transport'  =>  'refresh'
    )
  );

  $wp_customize->add_control(
    'lcc_footer_column1',
    array(
      'section'   => 'lcc_footer_text',
      'label'     => 'Column 1',
      'type'      => 'textarea'
    )
  );

  $wp_customize->add_setting(
    'lcc_footer_column2',
    array(
      'default'    =>  '',
      'transport'  =>  'refresh'
    )
  );

  $wp_customize->add_control(
    'lcc_footer_column2',
    array(
      'section'   => 'lcc_footer_text',
      'label'     => 'Column 2',
      'type'      => 'textarea'
    )
  );

  $wp_customize->add_setting(
    'lcc_footer_column3',
    array(
      'default'    =>  '',
      'transport'  =>  'refresh'
    )
  );

  $wp_customize->add_control(
    'lcc_footer_column3',
    array(
      'section'   => 'lcc_footer_text',
      'label'     => 'Column 3',
      'type'      => 'textarea'
    )
  );
}
add_action( 'customize_register', 'theme_customize_register' );

// restrict email registration
add_filter('registration_errors', 'sizeable_restrict_domains', 10, 3);
function sizeable_restrict_domains( $errors, $login, $email ) {
	$whitelist = array('arts.ac.uk', 'lcc.arts.ac.uk');
	if ( is_email($email) ) {
		$parts = explode('@', $email);
		$domain = $parts[count($parts)-1];
		if ( !in_array(strtolower($domain), $whitelist) ) {
			$errors->add('email_domain', __('ERROR: You may only register with a UAL email address.'));
		}
	}
	return $errors;
}
