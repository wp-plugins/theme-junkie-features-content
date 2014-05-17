<?php
/**
 * File for registering post type.
 *
 * @package    Theme_Junkie_Features_Content
 * @since      0.1.0
 * @author     Theme Junkie
 * @copyright  Copyright (c) 2014, Theme Junkie
 * @link       http://codex.wordpress.org/Function_Reference/register_post_type
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */

/* Register custom post type on the 'init' hook. */
add_action( 'init', 'tjfc_register_post_type' );

/**
 * Registers post type needed by the plugin.
 *
 * @since  0.1.0
 * @access public
 */
function tjfc_register_post_type() {

	$labels = array(
	    'name'               => __( 'Features', 'tjfc' ),
	    'singular_name'      => __( 'Feature', 'tjfc' ),
    	'menu_name'          => __( 'Features', 'tjfc' ),
    	'name_admin_bar'     => __( 'Feature', 'tjfc' ),
		'all_items'          => __( 'Features', 'tjfc' ),
	    'add_new'            => __( 'Add New', 'tjfc' ),
		'add_new_item'       => __( 'Add New Feature', 'tjfc' ),
		'edit_item'          => __( 'Edit Feature', 'tjfc' ),
		'new_item'           => __( 'New Feature', 'tjfc' ),
		'view_item'          => __( 'View Feature', 'tjfc' ),
		'search_items'       => __( 'Search Features', 'tjfc' ),
		'not_found'          => __( 'No Features found', 'tjfc' ),
		'not_found_in_trash' => __( 'No Features found in trash', 'tjfc' ),
		'parent_item_colon'  => '',
	);

	$defaults = array(	
		'labels'              => apply_filters( 'tjfc_features_labels', $labels ),
		'public'              => true,
		'exclude_from_search' => true,
		'menu_position'       => 58,
		'menu_icon'           => 'dashicons-megaphone',
		'supports'            => array( 'title', 'editor', 'revisions', 'page-attributes' ),
		'rewrite'             => array( 'slug' => 'features', 'with_front' => false ),
		'has_archive'         => true
	);

	$args = apply_filters( 'tjfc_features_args', $defaults );

	register_post_type( 'feature', $args );

}