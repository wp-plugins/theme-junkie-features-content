<?php
/**
 * Customizing the post type messages.
 * 
 * @package    Theme_Junkie_Features_Content
 * @since      0.1.0
 * @author     Theme Junkie
 * @copyright  Copyright (c) 2014, Theme Junkie
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */

/* Filter messages. */
add_filter( 'post_updated_messages', 'tjfc_updated_messages' );

/**
 * Portfolio update messages.
 *
 * @param  array  $messages Existing post update messages.
 * @since  0.1.0
 * @access public
 * @return array  Amended post update messages with new CPT update messages.
 */
function tjfc_updated_messages( $messages ) {
	global $post, $post_ID;

	$messages['feature'] = array(
		0 => '',
		1 => sprintf( __( 'Feature updated. <a href="%s">View Feature</a>', 'tjfc' ), esc_url( get_permalink( $post_ID ) ) ),
		2 => __( 'Custom field updated.', 'tjfc' ),
		3 => __( 'Custom field deleted.', 'tjfc' ),
		4 => __( 'Feature updated.', 'tjfc' ),
		5 => isset( $_GET['revision'] ) ? sprintf( __( 'Feature restored to revision from %s', 'tjfc' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __( 'Feature published. <a href="%s">View It</a>', 'tjfc' ), esc_url( get_permalink( $post_ID ) ) ),
		7 => __( 'Feature saved.', 'tjfc' ),
		8 => sprintf( __( 'Feature submitted. <a target="_blank" href="%s">Preview Feature</a>', 'tjfc' ), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __( 'Feature scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Feature</a>', 'tjfc' ),
		  // translators: Publish box date format, see http://php.net/date
		  date_i18n( __( 'M j, Y @ G:i', 'tjfc' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
		10 => sprintf( __( 'Feature draft updated. <a target="_blank" href="%s">Preview Feature</a>', 'tjfc' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
	);

	return $messages;
}