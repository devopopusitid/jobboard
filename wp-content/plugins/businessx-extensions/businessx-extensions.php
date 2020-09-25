<?php
/*
Plugin Name: Businessx Extensions
Plugin URI: http://www.acosmin.com/themes/businessx/
Description: Adds front page sections and other extensions to Businessx WordPress theme.
Version: 1.0.6
Author: Acosmin
Author URI: http://www.acosmin.com/
Text Domain: businessx-extensions
Domain Path: /languages
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! function_exists( 'add_action' ) ) {
	die( 'Nothing to do...' );
}

/* Some constants */
if( ! defined( 'BUSINESSX_EXTS_VERSION' ) ) {
	define( 'BUSINESSX_EXTS_VERSION', '1.0.6' ); }

if( ! defined( 'BUSINESSX_EXTS_THEME_NAME' ) ) {
	define( 'BUSINESSX_EXTS_THEME_NAME', 'Businessx' ); }

if( ! defined( 'BUSINESSX_EXTS_THEME_URL' ) ) {
	define( 'BUSINESSX_EXTS_THEME_URL', '//www.acosmin.com/theme/businessx/' ); }

if( ! defined( 'USINESSX_EXTS_THEME_DOCS' ) ) {
	define( 'BUSINESSX_EXTS_THEME_DOCS', '//www.acosmin.com/documentation/businessx/' ); }

if( ! defined( 'BUSINESSX_EXTS_URL' ) ) {
	define( 'BUSINESSX_EXTS_URL', plugin_dir_url( __FILE__ ) ); }

if( ! defined( 'BUSINESSX_EXTS_PATH' ) ) {
	define( 'BUSINESSX_EXTS_PATH', plugin_dir_path( __FILE__ ) ); }



/* Theme names */
if( ! function_exists( 'businessx_extensions_theme' ) ) {
	/**
	 * Get current theme name
	 *
	 * @since  1.0.0
	 * @param  boolean $parent Return child name if false
	 * @return string          Current theme name
	 */
	function businessx_extensions_theme( $parent = false ) {
		$theme = wp_get_theme();
		if( ! $parent ) {
			return $theme->name;
		} else {
			return $theme->parent_theme;
		}
	}
}



/* Load text domain */
if( ! function_exists( 'businessx_extensions_textdomain' ) ) {
	/**
	 * Load text domain
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function businessx_extensions_textdomain() {
		load_plugin_textdomain( 'businessx-extensions', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}
}
add_action( 'plugins_loaded', 'businessx_extensions_textdomain' );



/* Add front page sections */
if( ! function_exists( 'businessx_extensions_sections' ) ) {
	/**
	 * A list of all the default & supported sections
	 *
	 * Use the `businessx_extensions_sections___filter` to add yours
	 *
	 * @since  1.0.0
	 * @return array An array with unique, non duplicate sections names
	 */
	function businessx_extensions_sections() {
		$sections = apply_filters( 'businessx_extensions_sections___filter', array(
			'slider',
			'features',
			'about',
			'team',
			'clients',
			'portfolio',
			'actions',
			'testimonials',
			'pricing',
			'faq',
			'hero',
			'blog',
			'contact',
			'maps'
		) );

		return array_map( 'sanitize_key', array_unique( $sections ) );
	}
}



if( ! function_exists( 'businessx_extensions_sections_items' ) ) {
	/**
	 * Returns an array with names of sections
	 * that can add items
	 *
	 * @since  1.0.4.3
	 * @return array
	 */
	function businessx_extensions_sections_items() {
		$sections = apply_filters( 'businessx_extensions_sections_items___filter', array(
			'slider',
			'features',
			'about',
			'team',
			'clients',
			'actions',
			'testimonials',
			'pricing',
			'faq',
		) );

		return array_map( 'sanitize_key', array_unique( $sections ) );
	}
}



if( ! function_exists( 'businessx_extensions_add_sections' ) ) {
	/**
	 * Adds the sections saved in your theme mod
	 * 
	 * The theme will not handle this part anymore, it's deprecated in
	 * functions.php:L115-126
	 *
	 * @todo   Do some checks on `$positions` in case it's not JSON.
	 * @since  1.0.6
	 * @return void
	 */
	function businessx_extensions_add_sections() {
		$mod       = 'businessx_sections_position';
		$sections  = businessx_extensions_sections();
		$positions = get_theme_mod( $mod );

		/* 
		 * Checks if no sections are saved in a theme_mod and if we 
		 * have at least one default sections 
		 */
		if( empty( $positions ) && ! empty( $sections ) ) {
			$new = array();

			/* Use the prefix for backwards compatibility */
			foreach( $sections as $key => $value ) {
				$new[] = 'businessx_section__' . sanitize_key( $value );
			}

			/* Add the default sections if it's the first time. */
			set_theme_mod( $mod, json_encode( $new ) );
		}

		if( is_array( $positions ) ) {
			/* Pre version 1.0.6, convert them to JSON. */
			set_theme_mod( $mod, json_encode( $positions ) );
		}
	}
}
add_action( 'after_setup_theme', 'businessx_extensions_add_sections', 15 );



if( ! function_exists( 'businessx_extensions_add_new_sections' ) ) {
	/**
	 * Checks if new sections are added and adds them
	 * to the end of `businessx_sections_position`
	 *
	 * @since  1.0.4.3
	 * @return array
	 */
	function businessx_extensions_add_new_sections() {
		$prefix   = 'businessx_section__';
		$sections = $new_sections = array();
		$defaults = businessx_extensions_sections();
		$saved    = get_theme_mod( 'businessx_sections_position' );

		/* Return if no theme mods are saved */
		if( $saved === false ) return;

		/* Check if it's an array, pre v1.0.6 */
		if( ! is_array( $saved ) ) {
			$saved = json_decode( $saved );
		}

		/**
		 * Create an array of all the sections and prefix
		 * them with `businessx_section__`
		 */
		foreach ( $defaults as $section ) {
			$sections[] = $prefix . $section;
		}

		/**
		 * Check if any new sections were added
		 * @var array
		 */
		$diff = array_diff( $sections, $saved );

		/* If not, do nothing */
		if( empty( $diff ) ) return;

		/* Add all the new sections at the end of the array */
		foreach( $diff as $new_section ) {
			array_push( $saved, $new_section );
		}

		/* JSON encode the new array and set the theme mod with the new values */
		$saved = wp_json_encode( array_map( 'sanitize_key', array_unique( $saved ) ) );

		/* Update the theme mod with the new sections and positions */
		set_theme_mod( 'businessx_sections_position', $saved );

	}
}
add_action( 'plugins_loaded', 'businessx_extensions_add_new_sections' );



/**
 * Needed functions
 * ----------------
 * Sanitization functions are included in the theme. (../acosmin/function/sanitization.php)
 * Icons function are included in the theme. (../acosmin/function/icons.php)
 * Some other used functions (../acosmin/function/helpers.php)
 */

/* No requirements */
require_once ( dirname( __FILE__ ) . '/inc/sidebars/register.php' );
require_once ( dirname( __FILE__ ) . '/inc/functions/helpers.php' );
require_once ( dirname( __FILE__ ) . '/inc/functions/backup-functions.php' );
require_once ( dirname( __FILE__ ) . '/inc/customizer/sections-widgets/init.php' );

/* Required Businessx or a child theme of it to be the current theme */
if ( ( 'Businessx' == businessx_extensions_theme() ) || ( 'Businessx' == businessx_extensions_theme( true ) ) ) {
	require_once ( dirname( __FILE__ ) . '/inc/compatibility/polylang.php' );
	require_once ( dirname( __FILE__ ) . '/inc/functions/shortcodes.php' );
	require_once ( dirname( __FILE__ ) . '/inc/templating.php' );
	require_once ( dirname( __FILE__ ) . '/inc/scripts/scripts.php' );
	require_once ( dirname( __FILE__ ) . '/inc/icons/icons.php' );
	require_once ( dirname( __FILE__ ) . '/inc/customizer/customizer.php' );
	require_once ( dirname( __FILE__ ) . '/inc/customizer/setup/front-page.php' );
	require_once ( dirname( __FILE__ ) . '/inc/customizer/sections-widgets/styles.php' );
	require_once ( dirname( __FILE__ ) . '/inc/partials/partials.php' );
	require_once ( dirname( __FILE__ ) . '/inc/partials/hooks.php' );
	require_once ( dirname( __FILE__ ) . '/inc/partials/items-hooks.php' );
} else {
	add_action( 'admin_enqueue_scripts', 'businessx_extensions_enqueue_backup' );
}
