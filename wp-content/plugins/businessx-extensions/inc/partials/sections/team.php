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
	 * Team Section
	 * ---------------
	 */

	// Section wrapper - start
	if( ! function_exists( 'bx_ext_part__team_wrap_start' ) ) {
		function bx_ext_part__team_wrap_start() {
			$mod      = 'team_bg_parallax';
			$enabled  = bx_ext_tm( $mod, false );
			$class    = $enabled ? ' bx-ext-parallax' : '';
			$parallax = bxext_section_parallax( $mod, 'team_bg_parallax_img', true );
			$format   = '<section id="section-team" class="grid-wrap sec-team%1$s"%2$s>';

			$output = sprintf( $format, $class, $parallax );
			$output = apply_filters( 'bx_ext_part___team_wrap_start', $output, $format, $class, $parallax );

			echo $output;
		}
	}

	// Section wrapper - end
	if( ! function_exists( 'bx_ext_part__team_wrap_end' ) ) {
		function bx_ext_part__team_wrap_end() {
			?></section><?php
		}
	}

		// Overlay
		if( ! function_exists( 'bx_ext_part__team_overlay' ) ) {
			function bx_ext_part__team_overlay() {
				$section = 'team';
				$show    = bx_ext_tm( 'team_bg_overlay', false );
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
		if( ! function_exists( 'bx_ext_part__team_container' ) ) {
 			function bx_ext_part__team_container() {
 				/**
 				 * Hooked:
 				 * bx_ext_part__team_container_start   - 10
 				 * bx_ext_part__team_items             - 20
 				 * bx_ext_part__team_container_end     - 999
 				 */
 				do_action( 'bx_ext_part__team_container' );
 			}
 		}

			// Container start
			if( ! function_exists( 'bx_ext_part__team_container_start' ) ) {
				function bx_ext_part__team_container_start() {
					?><div class="grid-container grid-1 clearfix"><?php
				}
			}

			// Container end
			if( ! function_exists( 'bx_ext_part__team_container_end' ) ) {
				function bx_ext_part__team_container_end() {
					?></div><?php
				}
			}

			/**
			 * Items
			 */
			if( ! function_exists( 'bx_ext_part__team_items' ) ) {
				function bx_ext_part__team_items() {
					/**
					 * Hooked:
					 * bx_ext_part__team_items_header    - 10
					 * bx_ext_part__blog_items_members   - 20
					 */
					do_action( 'bx_ext_part__team_items' );
				}
			}

				// Items header
				if( ! function_exists( 'bx_ext_part__team_items_header' ) ) {
					function bx_ext_part__team_items_header() {
						/**
						 * Hooked:
						 * bx_ext_part__team_items_header_start       - 10
						 * bx_ext_part__team_items_header_title       - 20
						 * bx_ext_part__team_items_header_description - 30
						 * bx_ext_part__team_items_header_end         - 999
						 */
						do_action( 'bx_ext_part__team_items_header' );
					}
				}

					// Header start
					if( ! function_exists( 'bx_ext_part__team_items_header_start' ) ) {
						function bx_ext_part__team_items_header_start() {
							?><header class="section-header"><?php
						}
					}

					// Header end
					if( ! function_exists( 'bx_ext_part__team_items_header_end' ) ) {
						function bx_ext_part__team_items_header_end() {
							?></header><?php
						}
					}

					// Section title
					if( ! function_exists( 'bx_ext_part__team_items_header_title' ) ) {
						function bx_ext_part__team_items_header_title() {
							$section = 'team';
							$title   = bxext_sections_strings( $section, 'title' );
							$format  = '<h2 class="section-title hs-primary-medium hb-bottom-large %1$s">%2$s</h2>%3$s';
							$divider = '<div class="divider"></div>';
							$anim    = businessx_anim_classes( true );

							$output  = sprintf( $format, $anim, esc_html( $title ), $divider );
							$output  = apply_filters(
								'bx_ext_part___team_info_output_title',
								$output, $format, $anim, $title, $divider, $section
							);

							if( $title == '' ) return; // Do nothing

							echo $output;
						}
					}

					// Section description
					if( ! function_exists( 'bx_ext_part__team_items_header_description' ) ) {
						function bx_ext_part__team_items_header_description() {
							$section = 'team';
							$desc    = bxext_sections_strings( $section, 'description' );
							$format  = '<p class="section-description fs-large %1$s">%2$s</p>';
							$anim    = businessx_anim_classes( true );

							$output  = sprintf( $format, $anim, bxext_escape_content_filtered_nonp( $desc ) );
							$output  = apply_filters(
								'bx_ext_part___team_info_output_description',
								$output, $format, $anim, $desc, $section
							);

							if( $desc == '' ) return; // Do nothing

							echo $output;
						}
					}

				// Items members
				if( ! function_exists( 'bx_ext_part__team_items_members' ) ) {
					function bx_ext_part__team_items_members() {
						/**
						 * Hooked:
						 * bx_ext_part__team_items_members_start   - 10
						 * bx_ext_part__team_items_members_display - 20
						 * bx_ext_part__team_items_members_end     - 999
						 */
						do_action( 'bx_ext_part__team_items_members' );
					}
				}

					// Members start
					if( ! function_exists( 'bx_ext_part__team_items_members_start' ) ) {
						function bx_ext_part__team_items_members_start() {
							?><div class="grid-items clearfix <?php businessx_anim_classes(); ?>"><?php
						}
					}

					// Members end
					if( ! function_exists( 'bx_ext_part__team_items_members_end' ) ) {
						function bx_ext_part__team_items_members_end() {
							?></div><?php
						}
					}

					// Members display
					if( ! function_exists( 'bx_ext_part__team_items_members_display' ) ) {
						function bx_ext_part__team_items_members_display() {
							$helpers = bx_ext_tm( 'disable_helpers', false );

							if ( is_active_sidebar( 'section-team' ) && ! is_paged() ) :
								/* Display all memebers */
								dynamic_sidebar( 'section-team' );
							else :
								/* If no members are added */
								if ( ! $helpers ) {
									echo apply_filters(
										'bx_ext_part___team_items_members_display_none',
										'<div class="grid-col grid-4x-col ta-center">' . __( 'You can find options for this section in: <b>Customizer > Front Page Sections > Team Section</b> and add items by clicking on <b>Add or edit members</b>. You can also disable this message from <b>Customizer > Settings > Extensions > Disable helpers/placeholders</b>.', 'businessx-extensions' ) . '</div>'
									);
								}
							endif;
						}
					}
