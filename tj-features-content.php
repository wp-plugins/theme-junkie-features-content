<?php
/**
 * Plugin Name:  Theme Junkie Features Content
 * Plugin URI:   http://www.theme-junkie.com/
 * Description:  Enable features post type to your WordPress website.
 * Version:      0.1.0
 * Author:       Theme Junkie
 * Author URI:   http://www.theme-junkie.com/
 * Author Email: satrya@theme-junkie.com
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License as published by the Free Software Foundation; either version 2 of the License, 
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write 
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package    Theme_Junkie_Features_Content
 * @since      0.1.0
 * @author     Theme Junkie
 * @copyright  Copyright (c) 2014, Theme Junkie
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class Tj_Features_Content {

	/**
	 * PHP5 constructor method.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function __construct() {

		/* Set constant path to the plugin directory. */
		add_action( 'plugins_loaded', array( &$this, 'constants' ), 1 );

		/* Internationalize the text strings used. */
		add_action( 'plugins_loaded', array( &$this, 'i18n' ), 2 );

		/* Load the admin functions files. */
		add_action( 'plugins_loaded', array( &$this, 'admin' ), 3 );

		/* Load the plugin functions files. */
		add_action( 'plugins_loaded', array( &$this, 'includes' ), 4 );

		/* Loads the admin styles and scripts. */
		add_action( 'admin_enqueue_scripts', array( &$this, 'admin_scripts' ) );

		/* Register activation hook. */
		register_activation_hook( __FILE__, 'activation' );

	}

	/**
	 * Defines constants used by the plugin.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function constants() {

		/* Set constant path to the plugin directory. */
		define( 'TJFC_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

		/* Set the constant path to the plugin directory URI. */
		define( 'TJFC_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

		/* Set the constant path to the admin directory. */
		define( 'TJFC_ADMIN', TJFC_DIR . trailingslashit( 'admin' ) );

		/* Set the constant path to the inc directory. */
		define( 'TJFC_INC', TJFC_DIR . trailingslashit( 'inc' ) );

		/* Set the constant path to the assets directory. */
		define( 'TJFC_ASSETS', TJFC_URI . trailingslashit( 'assets' ) );

	}

	/**
	 * Loads the translation files.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function i18n() {
		load_plugin_textdomain( 'tjfc', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Loads the admin functions.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function admin() {
		require_once( TJFC_ADMIN . 'admin.php' );
		require_once( TJFC_ADMIN . 'metabox.php' );
	}

	/**
	 * Loads the initial files needed by the plugin.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	public function includes() {
		require_once( TJFC_INC . 'post-type.php' );
		require_once( TJFC_INC . 'messages.php' );
	}

	/**
	 * Loads the admin styles and scripts.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	function admin_scripts() {

		/* Check if current screen is Portfolio page. */
		if ( 'feature' != get_current_screen()->post_type )
			return;

		/* Loads the meta boxes style. */
		wp_enqueue_style( 'tjfc-metaboxes-style', trailingslashit( TJFC_ASSETS ) . 'css/tjfc-admin.css', null, null );

		/* Loads required media files for the media manager. */
		wp_enqueue_media();

		/* Custom image uploader. */
		wp_enqueue_script( 'tjfc-media', trailingslashit( TJFC_ASSETS ) . 'js/media.js', array( 'jquery' ), null, true );

		/* Localize custom JS. */
		wp_localize_script( 'tjfc-media', 'tjfc_media',
			array(
				'title'  => __( 'Upload or Choose Icon', 'tjfc' ),
				'button' => __( 'Add Icon', 'tjfc' )
			)
		);
		
	}

	/**
	 * Method that runs only when the plugin is activated.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	function activation() {

		/* Flushing rewrite. */
		flush_rewrite_rules();

	}

}

new Tj_Features_Content;