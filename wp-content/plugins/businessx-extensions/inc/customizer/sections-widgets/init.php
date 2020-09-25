<?php
/* ------------------------------------------------------------------------- *
 *  Initiate section's widgets
 *  ________________
 *
 *	This class will initiate all the available homepage sections/widgets
 *	________________
 *
/* ------------------------------------------------------------------------- */

if( ! class_exists( 'Businessx_Extensions_Sections' ) ) {
	class Businessx_Extensions_Sections {

		private static $instance;


		/*  Initiator
		/* ------------------------------------ */

		public static function init() {
			return self::$instance;
		}


		/*  Constructor
		/* ------------------------------------ */
		public function __construct() {

			// Widgets/Sections
			require_once ( BUSINESSX_EXTS_PATH . '/inc/customizer/sections-widgets/base.php' ); // Shared functions for all widgets
			require_once ( BUSINESSX_EXTS_PATH . '/inc/customizer/sections-widgets/items/features.php' ); // Features item
			require_once ( BUSINESSX_EXTS_PATH . '/inc/customizer/sections-widgets/items/faq.php' ); // FAQ item
			require_once ( BUSINESSX_EXTS_PATH . '/inc/customizer/sections-widgets/items/clients.php' ); // Clients item
			require_once ( BUSINESSX_EXTS_PATH . '/inc/customizer/sections-widgets/items/actions.php' ); // Actions item
			require_once ( BUSINESSX_EXTS_PATH . '/inc/customizer/sections-widgets/items/about.php' ); // About Us item
			require_once ( BUSINESSX_EXTS_PATH . '/inc/customizer/sections-widgets/items/testimonials.php' ); // Testimonials item
			require_once ( BUSINESSX_EXTS_PATH . '/inc/customizer/sections-widgets/items/team.php' ); // Team item
			require_once ( BUSINESSX_EXTS_PATH . '/inc/customizer/sections-widgets/items/pricing.php' ); // Pricing item
			require_once ( BUSINESSX_EXTS_PATH . '/inc/customizer/sections-widgets/items/slider.php' ); // Slider item

		}


	}
}


/* Init everything via 'widgets_init' hook
/* --------------------------------------- */
if( ! function_exists( 'businessx_extensions_sections_init' ) ) {
	function businessx_extensions_sections_init() {
		global $businessx_sections_init;
		$businessx_sections_init = new Businessx_Extensions_Sections();
		$businessx_sections_init->init();
	}
}
add_action( 'widgets_init' , 'businessx_extensions_sections_init' , 20 );
