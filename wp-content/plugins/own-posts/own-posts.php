<?php
/*
Plugin Name: Simplify Post Edit List
Description: Show only the author's posts in the edit list
Version: 0.1
License: GPL
Author: Sarah Gooding
Author URI: http://untame.net
*/

function mypo_parse_query_useronly( $wp_query ) {
    if ( strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/edit.php' ) !== false ) {
        if ( !current_user_can( 'update_core' ) ) {
            global $current_user;
            $wp_query->set( 'author', $current_user->id );
        }
    }
}

add_filter('parse_query', 'mypo_parse_query_useronly' );

?>
