<?php
/**
 * ------------------
 * Template functions
 * ------------------
 *
 * In case you need to add some custom functions,
 * add them below.
 *
 */



/**
 * -----------------
 * Template partials
 * -----------------
 *
 * @see ../inc/partials/sections/hooks.php
 */

	/**
	 * Map Section
	 * -----------
	 */

	// Section wrapper - start
	if( ! function_exists( 'bx_ext_part__map_wrap_start' ) ) {
		function bx_ext_part__map_wrap_start() {
			?><section id="section-maps" class="sec-maps"><?php
		}
	}

	// Section wrapper - end
	if( ! function_exists( 'bx_ext_part__map_wrap_end' ) ) {
		function bx_ext_part__map_wrap_end() {
			?></section><?php
		}
	}

		/**
		 * Overlay
		 */
		if( ! function_exists( 'bx_ext_part__map_overlay' ) ) {
			function bx_ext_part__map_overlay() {
				/**
				 * Hooked:
				 * bx_ext_part__map_overlay_start   - 10
				 * bx_ext_part__map_overlay_content - 20
				 * bx_ext_part__map_overlay_end     - 999
				 */
				do_action( 'bx_ext_part__map_overlay' );
			}
		}

			// Start
			if( ! function_exists( 'bx_ext_part__map_overlay_start' ) ) {
				function bx_ext_part__map_overlay_start() {
					?><div class="sec-maps-overlay"><?php
				}
			}

			// End
			if( ! function_exists( 'bx_ext_part__map_overlay_end' ) ) {
				function bx_ext_part__map_overlay_end() {
					?></div><?php
				}
			}

				/**
				 * Overlay Content
				 */
				 if( ! function_exists( 'bx_ext_part__map_overlay_content' ) ) {
 					function bx_ext_part__map_overlay_content() {
 						/**
 						 * Hooked:
 						 * bx_ext_part__map_overlay_content_start - 10
 						 * bx_ext_part__map_overlay_content_title - 20
 						 * bx_ext_part__map_overlay_content_icon  - 30
 						 * bx_ext_part__map_overlay_content_end   - 999
 						 */
 						do_action( 'bx_ext_part__map_overlay_content' );
 					}
 				}

					// Start
					if( ! function_exists( 'bx_ext_part__map_overlay_content_start' ) ) {
	 					function bx_ext_part__map_overlay_content_start() {
	 						?><div class="smo-center"><?php
	 					}
	 				}

					// End
					if( ! function_exists( 'bx_ext_part__map_overlay_content_end' ) ) {
	 					function bx_ext_part__map_overlay_content_end() {
	 						?></div><?php
	 					}
	 				}

						// Section title
						if( ! function_exists( 'bx_ext_part__map_overlay_content_title' ) ) {
		 					function bx_ext_part__map_overlay_content_title() {
								$title       = bxext_sections_strings( 'maps', 'title' );
								$format      = '<h2 class="smo-title"><a href="#" class="smo-open-map">%s</a></h2>';

								$output = sprintf( $format, $title );
								$output = apply_filters(
									'bx_ext_part__map_overlay_content_title___filter',
									$output, $format, esc_html( $title )
								);

								if( empty( $title ) ) return;

								echo $output;
		 					}
		 				}

						// Section icon
						if( ! function_exists( 'bx_ext_part__map_overlay_content_icon' ) ) {
		 					function bx_ext_part__map_overlay_content_icon() {
								$hide   = bx_ext_tm( 'maps_section_hide_icon', 0 );
								$icon   = businessx_icon( 'map', false );
								$format = '<a href="#" class="smo-icon smo-open-map">%s</a>';

								$output = sprintf( $format, $icon );
								$output = apply_filters(
									'bx_ext_part__map_overlay_content_icon___filter',
									$output, $format, $icon
								);

								// Do nothing if hidden
								if( $hide ) return;

								echo $output;
		 					}
		 				}

		/**
		 * Map output
		 */
		if( ! function_exists( 'bx_ext_part__map_output' ) ) {
			function bx_ext_part__map_output() {
				$iframe = bx_ext_tm( 'maps_section_code', '' );
				$format = '<div class="sec-maps-iframe">%s</div>';
				$output = sprintf( $format, businessx_ext_sanitize_gmaps_iframe( $iframe ) );
				$output = apply_filters( 'bx_ext_part___map_output', $output, $format, $iframe );

				if( strpos( $output, '<iframe' ) !== false ) {
					echo $output;
				} elseif( has_shortcode( $output, 'googlemaps' ) ) {
					echo do_shortcode( $output );
				} else {
					printf( $format, esc_html_e( 'Not a valid Map code', 'businessx-extensions' ) );
				}
			}
		}
