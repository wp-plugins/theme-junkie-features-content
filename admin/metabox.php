<?php
/**
 * Meta boxes functions for the plugin.
 *
 * @package    Theme_Junkie_Features_Content
 * @since      0.1.0
 * @author     Theme Junkie
 * @copyright  Copyright (c) 2014, Theme Junkie
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */

/* Register meta boxes. */
add_action( 'add_meta_boxes', 'tjfc_add_meta_boxes' );

/* Save meta boxes. */
add_action( 'save_post', 'tjfc_meta_boxes_save', 10, 2 );

/**
 * Registers new meta boxes for the 'feature' post editing screen in the admin.
 *
 * @since  0.1.0
 * @access public
 * @link   http://codex.wordpress.org/Function_Reference/add_meta_box
 */
function tjfc_add_meta_boxes() {

	/* Check if current screen is feature page. */
	if ( 'feature' != get_current_screen()->post_type )
		return;

	add_meta_box( 
		'tjfc-metaboxes-feature',
		__( 'Feature Settings', 'tjfc' ),
		'tjfc_metaboxes_display',
		'feature',
		'normal',
		'high'
	);

}

/**
 * Displays the content of the meta boxes.
 *
 * @param  object  $post
 * @since  0.1.0
 * @access public
 */
function tjfc_metaboxes_display( $post ) {

	wp_nonce_field( basename( __FILE__ ), 'tjfc-metaboxes-feature-nonce' ); ?>

	<div id="tjfc-block">

		<div class="tjfc-label">
			<label for="tjfc-feature-icon">
				<strong><?php _e( 'Feature Icon', 'tjfc' ); ?></strong><br />
				<span class="description"><?php _e( 'Upload or insert feature icon.', 'tjfc' ); ?></span>
			</label>
		</div>

		<div class="tjfc-input">
			<input type="text" name="tjfc-feature-icon" id="tjfc-feature-icon" value="<?php echo esc_url( get_post_meta( $post->ID, 'tj_feature_icon', true ) ); ?>" size="30" style="width: 83%;" placeholder="<?php echo esc_attr( 'http://' ) ?>" />
			<a href="#" class="tjfc-open-media button" title="<?php esc_attr_e( 'Add Icon', 'tjfc' ); ?>"><?php _e( 'Add Icon', 'tjfc' ); ?></a>
		</div>

	</div><!-- #tjfc-block -->

	<div id="tjfc-block">

		<div class="tjfc-label">
			<label for="tjfc-feature-more-link">
				<strong><?php _e( 'Read More Link', 'tjfc' ); ?></strong><br />
				<span class="description"><?php _e( 'The feature link.', 'tjfc' ); ?></span>
			</label>
		</div>

		<div class="tjfc-input">
			<input type="text" name="tjfc-feature-more-link" id="tjfc-feature-more-link" value="<?php echo sanitize_text_field( get_post_meta( $post->ID, 'tj_feature_more_link', true ) ); ?>" size="30" style="width: 99%;" placeholder="<?php echo esc_attr( 'http://' ) ?>" />
		</div>

	</div><!-- #tjfc-block -->

	<?php
}

/**
 * Saves the metadata for the feature item info meta box.
 *
 * @param  int     $post_id
 * @param  object  $post
 * @since  0.1.0
 * @access public
 */
function tjfc_meta_boxes_save( $post_id, $post ) {

	if ( ! isset( $_POST['tjfc-metaboxes-feature-nonce'] ) || ! wp_verify_nonce( $_POST['tjfc-metaboxes-feature-nonce'], basename( __FILE__ ) ) )
		return;

	if ( ! current_user_can( 'edit_post', $post_id ) )
		return;

	$meta = array(
		'tj_feature_icon'      => esc_url( $_POST['tjfc-feature-icon'] ),
		'tj_feature_more_link' => esc_url( $_POST['tjfc-feature-more-link'] )
	);

	foreach ( $meta as $meta_key => $new_meta_value ) {

		/* Get the meta value of the custom field key. */
		$meta_value = get_post_meta( $post_id, $meta_key, true );

		/* If there is no new meta value but an old value exists, delete it. */
		if ( current_user_can( 'delete_post_meta', $post_id, $meta_key ) && '' == $new_meta_value && $meta_value )
			delete_post_meta( $post_id, $meta_key, $meta_value );

		/* If a new meta value was added and there was no previous value, add it. */
		elseif ( current_user_can( 'add_post_meta', $post_id, $meta_key ) && $new_meta_value && '' == $meta_value )
			add_post_meta( $post_id, $meta_key, $new_meta_value, true );

		/* If the new meta value does not match the old value, update it. */
		elseif ( current_user_can( 'edit_post_meta', $post_id, $meta_key ) && $new_meta_value && $new_meta_value != $meta_value )
			update_post_meta( $post_id, $meta_key, $new_meta_value );
	}

}