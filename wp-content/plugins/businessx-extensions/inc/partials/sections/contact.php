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
	 * Contact Section
	 * ---------------
	 */

	// Section wrapper - start
	if( ! function_exists( 'bx_ext_part__contact_wrap_start' ) ) {
		function bx_ext_part__contact_wrap_start() {
			$mod      = 'contact_bg_parallax';
			$enabled  = bx_ext_tm( $mod, false );
			$class    = $enabled ? ' bx-ext-parallax' : '';
			$parallax = bxext_section_parallax( $mod, 'contact_bg_parallax_img', true );
			$format   = '<section id="section-contact" class="grid-wrap sec-contact%1$s"%2$s>';

			$output = sprintf( $format, $class, $parallax );
			$output = apply_filters( 'bx_ext_part___contact_wrap_start', $output, $format, $class, $parallax );

			echo $output;
		}
	}

	// Section wrapper - end
	if( ! function_exists( 'bx_ext_part__contact_wrap_end' ) ) {
		function bx_ext_part__contact_wrap_end() {
			?></section><?php
		}
	}

		// Overlay
		if( ! function_exists( 'bx_ext_part__contact_overlay' ) ) {
			function bx_ext_part__contact_overlay() {
				$section = 'contact';
				$show    = bx_ext_tm( 'contact_bg_overlay', false );
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
		if( ! function_exists( 'bx_ext_part__contact_container' ) ) {
 			function bx_ext_part__contact_container() {
 				/**
 				 * Hooked:
 				 * bx_ext_part__contact_container_start   - 10
 				 * bx_ext_part__contact_items             - 20
 				 * bx_ext_part__contact_container_end     - 999
 				 */
 				do_action( 'bx_ext_part__contact_container' );
 			}
 		}

			// Container start
			if( ! function_exists( 'bx_ext_part__contact_container_start' ) ) {
				function bx_ext_part__contact_container_start() {
					?><div class="grid-container grid-1 clearfix"><?php
				}
			}

			// Container end
			if( ! function_exists( 'bx_ext_part__contact_container_end' ) ) {
				function bx_ext_part__contact_container_end() {
					?></div><?php
				}
			}

				/**
				 * Items
				 */
				if( ! function_exists( 'bx_ext_part__contact_items' ) ) {
 		 			function bx_ext_part__contact_items() {
 		 				/**
 		 				 * Hooked:
 		 				 * bx_ext_part__contact_items_start   - 10
 		 				 * bx_ext_part__contact_items_display - 20
 		 				 * bx_ext_part__contact_items_end     - 999
 		 				 */
 		 				do_action( 'bx_ext_part__contact_items' );
 		 			}
 		 		}

					// Items start
					if( ! function_exists( 'bx_ext_part__contact_items_start' ) ) {
						function bx_ext_part__contact_items_start() {
							?><div class="grid-items clearfix <?php businessx_anim_classes(); ?>"><?php
						}
					}

					// Items end
					if( ! function_exists( 'bx_ext_part__contact_items_end' ) ) {
						function bx_ext_part__contact_items_end() {
							?></div><?php
						}
					}

						/**
						 * Items display
						 */
						if( ! function_exists( 'bx_ext_part__contact_items_display' ) ) {
 		 		 			function bx_ext_part__contact_items_display() {
 		 		 				/**
 		 		 				 * Hooked:
 		 		 				 * bx_ext_part__contact_info - 10
 		 		 				 * bx_ext_part__contact_form - 20
 		 		 				 *
 		 		 				 */
 		 		 				do_action( 'bx_ext_part__contact_items_display' );
 		 		 			}
 		 		 		}

							/**
							 * Information
							 */
							if( ! function_exists( 'bx_ext_part__contact_info' ) ) {
 	 		 		 			function bx_ext_part__contact_info() {
 	 		 		 				/**
 	 		 		 				 * Hooked:
 	 		 		 				 * bx_ext_part__contact_info_start  - 10
 	 		 		 				 * bx_ext_part__contact_info_output - 20
 	 		 		 				 * bx_ext_part__contact_info_end    - 999
 	 		 		 				 */
 	 		 		 				do_action( 'bx_ext_part__contact_info' );
 	 		 		 			}
 	 		 		 		}

								// Information start
								if( ! function_exists( 'bx_ext_part__contact_info_start' ) ) {
									function bx_ext_part__contact_info_start() {
										?><div class="grid-col grid-2x-col sec-contact-box sec-contact-info"><?php
									}
								}

								// Information end
								if( ! function_exists( 'bx_ext_part__contact_info_end' ) ) {
									function bx_ext_part__contact_info_end() {
										?></div><?php
									}
								}

									/**
									 * Information output
									 */
									if( ! function_exists( 'bx_ext_part__contact_info_output' ) ) {
										function bx_ext_part__contact_info_output() {
											/**
											 * Hooked
											 * bx_ext_part__contact_info_output_title - 10
											 * bx_ext_part__contact_info_output_desc  - 20
											 * bx_ext_part__contact_info_output_btns  - 30
											 */
											do_action( 'bx_ext_part__contact_info_output' );
										}
									}

										// Section title
										if( ! function_exists( 'bx_ext_part__contact_info_output_title' ) ) {
											function bx_ext_part__contact_info_output_title() {
												$section = 'contact';
												$title   = bxext_sections_strings( $section, 'title' );
												$anim    = businessx_anim_classes( true );
												$divider = '<div class="divider"></div>';
												$format  = '<h2 class="section-title hs-primary-medium hb-bottom-large %1$s">%2$s</h2>%3$s';

												$output = sprintf( $format, $anim, esc_html( $title ), $divider );
												$output = apply_filters(
													'bx_ext_part___contact_info_output_title',
													$output, $format, $anim, $title, $divider, $section
												);

												if( $title == '' ) return; // Do nothing

												echo $output;
											}
										}

										// Section description
										if( ! function_exists( 'bx_ext_part__contact_info_output_desc' ) ) {
											function bx_ext_part__contact_info_output_desc() {
												$section = 'contact';
												$desc    = bxext_sections_strings( $section, 'description' );
												$desc    = businessx_ext_escape_content_filtered( $desc );
												$anim    = businessx_anim_classes( true );
												$format  = '<div class="section-description fs-large %1$s">%2$s</div>';

												$output = sprintf( $format, $anim, $desc );
												$output = apply_filters(
													'bx_ext_part___contact_info_output_desc',
													$output, $format, $anim, $desc, $section
												);

												if( $desc == '' ) return; // Do nothing

												echo $output;
											}
										}

										// Butons
										if( ! function_exists( 'bx_ext_part__contact_info_output_btns' ) ) {
											function bx_ext_part__contact_info_output_btns() {
												$section = 'contact';
												$btns    = bx_ext_tm( 'contact_section_social', ' ' );
												$btns    = businessx_ext_escape_content_filtered( $btns );
												$anim    = businessx_anim_classes( true );
												$format  = '<div class="sec-contact-social clearfix %1$s">%2$s</div>';

												$output = sprintf( $format, $anim, $btns );
												$output = apply_filters(
													'bx_ext_part___contact_info_output_btns',
													$output, $format, $anim, $btns, $section
												);

												if( $btns == '' ) return; // Do nothing

												echo $output;
											}
										}

							/**
							 * Form
							 */
							if( ! function_exists( 'bx_ext_part__contact_form' ) ) {
 	 		 		 			function bx_ext_part__contact_form() {
 	 		 		 				/**
 	 		 		 				 * Hooked:
 	 		 		 				 * bx_ext_part__contact_form_start  - 10
 	 		 		 				 * bx_ext_part__contact_form_output - 20
 	 		 		 				 * bx_ext_part__contact_form_end    - 999
 	 		 		 				 */
 	 		 		 				do_action( 'bx_ext_part__contact_form' );
 	 		 		 			}
 	 		 		 		}

								// Form start
								if( ! function_exists( 'bx_ext_part__contact_form_start' ) ) {
									function bx_ext_part__contact_form_start() {
										?><div class="grid-col grid-2x-col sec-contact-box sec-contact-form"><?php
									}
								}

								// Form end
								if( ! function_exists( 'bx_ext_part__contact_form_end' ) ) {
									function bx_ext_part__contact_form_end() {
										?></div><?php
									}
								}

								// Form output
								if( ! function_exists( 'bx_ext_part__contact_form_output' ) ) {
									function bx_ext_part__contact_form_output() {
										$shortcode = bxext_sections_strings( 'contact', 'shortcode' );
										$shortcode = apply_filters( 'bx_ext_part__contact_form_output___filter', $shortcode );

										echo businessx_ext_escape_content_filtered( $shortcode );
									}
								}
