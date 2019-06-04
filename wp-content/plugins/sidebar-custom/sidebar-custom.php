<?php
/*
Plugin Name: Custom Sidebar
Description: Disables unnamed pages & renames post
Version: 0.1
License: GPL
Author: Ben Leonard
Author URI: http://benleonard.co.uk
*/

function remove_menu_items() {
  remove_menu_page( 'edit-comments.php' );
  remove_menu_page( 'profile.php' );
  //remove_menu_page( 'upload.php' );

  if( !current_user_can('administrator') ) {
    remove_menu_page( 'tools.php' );
  }
}

add_action( 'admin_menu', 'remove_menu_items' );

function revcon_change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Portfolios';
    $submenu['edit.php'][5][0] = 'Portfolios';
    $submenu['edit.php'][10][0] = 'Add Portfolio';
    $submenu['edit.php'][16][0] = 'Portfolio Tags';
    echo '';
}
function revcon_change_post_object() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Portfolios';
    $labels->singular_name = 'Portfolio';
    $labels->add_new = 'Add Portfolio';
    $labels->add_new_item = 'Add Portfolio';
    $labels->edit_item = 'Edit Portfolio';
    $labels->new_item = 'Portfolio';
    $labels->view_item = 'View Portfolio';
    $labels->search_items = 'Search Portfolios';
    $labels->not_found = 'No Porfolios found';
    $labels->not_found_in_trash = 'No Portfolios found in Trash';
    $labels->all_items = 'All Portfolios';
    $labels->menu_name = 'Portfolios';
    $labels->name_admin_bar = 'Portfolios';
}

add_action( 'admin_menu', 'revcon_change_post_label' );
add_action( 'init', 'revcon_change_post_object' );

// REMOVE POST META BOXES
function remove_my_post_metaboxes() {
  remove_meta_box( 'tagsdiv-post_tag','post','normal' ); // Tags Metabox
}

function remove_thumbnail_box() {
  remove_meta_box( 'postimagediv','post','side' );
  remove_meta_box( 'formatdiv','post','side' );
}

add_action('admin_menu','remove_my_post_metaboxes');
add_action('do_meta_boxes', 'remove_thumbnail_box');

function remove_box()
{
	 remove_post_type_support('post', 'title');
         remove_post_type_support('post', 'editor');
}
add_action("admin_init", "remove_box");

function person_update_title( $value, $post_id, $field ) {

  if( $value ) {
    $new_title = $value;
    $new_slug = sanitize_title( $new_title );
  } else {
    $new_title = 'Edit Me';
    $new_slug = sanitize_title( $new_title );
  }

	// update post
	$person_postdata = array(
		'ID'          => $post_id,
		'post_title'  => $new_title,
		'post_name'   => $new_slug,
	);

	if ( ! wp_is_post_revision( $post_id ) ){
		// unhook this function so it doesn't loop infinitely
		remove_action('save_post', 'person_update_title');
		// update the post, which calls save_post again
		wp_update_post( $person_postdata );
		// re-hook this function
		add_action('save_post', 'person_update_title');
	}

	return $value;
}

add_filter('acf/update_value/name=display_name', 'person_update_title', 10, 3);

add_filter( 'upload_size_limit', 'wpse_70754_change_upload_size' );

function wpse_70754_change_upload_size()
{
  return 5000 * 1024;
}

?>
