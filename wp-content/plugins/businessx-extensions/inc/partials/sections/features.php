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
	 * Features Section
	 * ----------------
	 */

	// Section wrapper - start
	if( ! function_exists( 'bx_ext_part__features_wrap_start' ) ) {
		function bx_ext_part__features_wrap_start() {
			$mod      = 'features_bg_parallax';
			$enabled  = bx_ext_tm( $mod, false );
			$class    = $enabled ? ' bx-ext-parallax' : '';
			$parallax = bxext_section_parallax( $mod, 'features_bg_parallax_img', true );
			$format   = '<section id="section-features" class="grid-wrap sec-features%1$s"%2$s>';

			$output = sprintf( $format, $class, $parallax );
			$output = apply_filters( 'bx_ext_part___features_wrap_start', $output, $format, $class, $parallax );

			echo $output;
		}
	}

	// Section wrapper - end
	if( ! function_exists( 'bx_ext_part__features_wrap_end' ) ) {
		function bx_ext_part__features_wrap_end() {
			?></section><?php
		}
	}

		// Overlay
		if( ! function_exists( 'bx_ext_part__features_overlay' ) ) {
			function bx_ext_part__features_overlay() {
				$section = 'features';
				$show    = bx_ext_tm( 'features_bg_overlay', false );
				$output  = '<div class="grid-overlay"></div>';
				$output  = apply_filters( 'bx_ext_part___overlay', $output, $section );

				// Do nothing if hidden
				if( ! $show ) return;

				echo $output;
			}
		}

		/**
		 * Container
		 */
		if( ! function_exists( 'bx_ext_part__features_container' ) ) {
 			function bx_ext_part__features_container() {
 				/**
 				 * Hooked:
 				 * bx_ext_part__features_container_start   - 10
 				 * bx_ext_part__features_header            - 20
 				 * bx_ext_part__features_helper            - 30
 				 * bx_ext_part__features_items             - 40
 				 * bx_ext_part__features_container_end     - 999
 				 */
 				do_action( 'bx_ext_part__features_container' );
 			}
 		}

			// Container start
			if( ! function_exists( 'bx_ext_part__features_container_start' ) ) {
				function bx_ext_part__features_container_start() {
					?><div class="grid-container grid-1 clearfix"><?php
				}
			}

			// Container end
			if( ! function_exists( 'bx_ext_part__features_container_end' ) ) {
				function bx_ext_part__features_container_end() {
					?></div><?php
				}
			}

			// Header
			if( ! function_exists( 'bx_ext_part__features_header' ) ) {
				function bx_ext_part__features_header() {
					$title = bx_ext_tm( 'features_section_title', esc_html__( 'Features Heading', 'businessx-extensions' ) );
					$desc  = bx_ext_tm( 'features_section_description', esc_html__( 'This is a description for the Features section. You can set it up in the Customizer where you can also add items for it.', 'businessx-extensions' ) );

					if( $title != '' || $desc != '' ) {
						/**
						 * Hooked:
						 * bx_ext_part__features_header_start       - 10
						 * bx_ext_part__features_header_title       - 20
						 * bx_ext_part__features_header_description - 30
						 * bx_ext_part__features_header_end         - 999
						 */
						do_action( 'bx_ext_part__features_header' );
					}
				}
			}

				// Header start
				if( ! function_exists( 'bx_ext_part__features_header_start' ) ) {
					function bx_ext_part__features_header_start() {
						?><header class="section-header"><?php
					}
				}

				// Header end
				if( ! function_exists( 'bx_ext_part__features_header_end' ) ) {
					function bx_ext_part__features_header_end() {
						?></header><?php
					}
				}

				// Section title
				if( ! function_exists( 'bx_ext_part__features_header_title' ) ) {
					function bx_ext_part__features_header_title() {
						$section = 'features';
						$title   = bxext_sections_strings( $section, 'title' );
						$format  = '<h2 class="section-title hs-primary-medium hb-bottom-large %1$s">%2$s</h2>%3$s';
						$divider = '<div class="divider"></div>';
						$anim    = businessx_anim_classes( true );

						$output  = sprintf( $format, $anim, esc_html( $title ), $divider );
						$output  = apply_filters(
							'bx_ext_part___features_header_title',
							$output, $format, $anim, $title, $divider, $section
						);

						if( $title == '' ) return; // Do nothing

						echo $output;
					}
				}

				// Section description
				if( ! function_exists( 'bx_ext_part__features_header_description' ) ) {
					function bx_ext_part__features_header_description() {
						$section = 'features';
						$desc    = bxext_sections_strings( $section, 'description' );
						$format  = '<p class="section-description fs-large %1$s">%2$s</p>';
						$anim    = businessx_anim_classes( true );

						$output  = sprintf( $format, $anim, bxext_escape_content_filtered_nonp( $desc ) );
						$output  = apply_filters(
							'bx_ext_part___features_header_description',
							$output, $format, $anim, $desc, $section
						);

						if( $desc == '' ) return; // Do nothing

						echo $output;
					}
				}



			/**
			 * Items
			 */
			if( ! function_exists( 'bx_ext_part__features_items' ) ) {
				function bx_ext_part__features_items() {
					/**
					 * Hooked:
					 * bx_ext_part__features_items_start    - 10
					 * bx_ext_part__features_items_display  - 20
					 * bx_ext_part__features_items_helper  - 30
					 * bx_ext_part__features_items_end      - 999
					 */
					do_action( 'bx_ext_part__features_items' );
				}
			}

				// Items start
				if( ! function_exists( 'bx_ext_part__features_items_start' ) ) {
					function bx_ext_part__features_items_start() {
						?><div class="grid-items clearfix <?php businessx_anim_classes(); ?>"><?php
					}
				}

				// Items end
				if( ! function_exists( 'bx_ext_part__features_items_end' ) ) {
					function bx_ext_part__features_items_end() {
						?></div><?php
					}
				}

				// Items display
				if( ! function_exists( 'bx_ext_part__features_items_display' ) ) {
					function bx_ext_part__features_items_display() {
						if ( is_active_sidebar( 'section-features' ) && ! is_paged() ) {
							dynamic_sidebar( 'section-features' );
						}
					}
				}

				// Helper
				if( ! function_exists( 'bx_ext_part__features_helper' ) ) {
					function bx_ext_part__features_helper() {
						$helpers = bx_ext_tm( 'disable_helpers', false );
						$format  = '<div class="grid-col grid-4x-col ta-center">%s</div>';
						$message = __( 'You can find options for this section in: <b>Customizer > Front Page Sections > Features Section</b> and add items by clicking on <b>Add or edit features</b>. You can also disable this message from <b>Customizer > Settings > Extensions > Disable helpers/placeholders</b>.', 'businessx-extensions' );
						$output  = sprintf( $format, $message );
						$output  = apply_filters( 'bx_ext_part___features_helper', $output, $format, $message, $helpers );

						if ( ! is_active_sidebar( 'section-features' ) && ! $helpers ) {
							echo $output;
						}
					}
				}
