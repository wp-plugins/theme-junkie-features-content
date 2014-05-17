<?php
/**
 * Admin functions for the plugin.
 *
 * @package    Theme_Junkie_Features_Content
 * @since      0.1.0
 * @author     Theme Junkie
 * @copyright  Copyright (c) 2014, Theme Junkie
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */

/* Set up the admin functionality. */
add_action( 'admin_menu', 'tjfc_admin_setup' );

/**
 * Plugin's admin functionality.
 *
 * @since  0.1.0
 * @access public
 */
function tjfc_admin_setup() {

	/* Filter the 'enter title here' placeholder. */
	add_filter( 'enter_title_here', 'tjfc_title_placeholder', 10 );

	/* Custom columns on the edit feature screen. */
	add_filter( 'manage_edit-feature_columns', 'tjfc_edit_feature_columns' );
	add_action( 'manage_feature_posts_custom_column', 'tjfc_manage_feature_columns', 10, 2 );
	add_filter( 'manage_edit-feature_sortable_columns', 'tjfc_column_sortable' );

}

/**
 * Filter the 'enter title here' placeholder.
 *
 * @param  string  $title
 * @since  0.1.0
 * @access public
 * @return string
 */
function tjfc_title_placeholder( $title ) {

	if ( 'feature' == get_current_screen()->post_type )
		$title = esc_attr__( 'Enter feature title here', 'tjfc' );
	
	return $title;
}

/**
 * Sets up custom columns on the feature edit screen.
 *
 * @param  array  $columns
 * @since  0.1.0
 * @access public
 * @return array
 */
function tjfc_edit_feature_columns( $columns ) {
	global $post;

	unset( $columns['title'] );

	$new_columns = array(
		'cb'    => '<input type="checkbox" />',
		'title' => __( 'Title', 'tjfc' )
	);

	$new_columns['image'] = __( 'Icon', 'tjfc' );
	$new_columns['menu_order'] = __( 'Order', 'tjfc' );

	return array_merge( $new_columns, $columns );
}

/**
 * Displays the content of custom feature columns on the edit screen.
 *
 * @param  string  $column
 * @param  int     $post_id
 * @since  0.1.0
 * @access public
 */
function tjfc_manage_feature_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		case 'image' :

			if ( get_post_meta( $post->ID, 'tj_feature_icon', true ) )
				echo '<img src="' . esc_url( get_post_meta( $post->ID, 'tj_feature_icon', true ) ) . '" style="width: 75px; height: 75px;" />';

			break;

		case 'menu_order':

		    $order = $post->menu_order;
		    echo $order;

		    break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}

/**
 * Make Order column sortable.
 * 
 * @since  0.1.0
 * @access public
 * @return object
 */
function tjfc_column_sortable( $columns ) {
	$columns['menu_order'] = 'menu_order';
	return $columns;
}