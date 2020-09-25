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
	 * FAQ Section
	 * -----------
	 */

	// Section wrapper - start
	if( ! function_exists( 'bx_ext_part__faq_wrap_start' ) ) {
		function bx_ext_part__faq_wrap_start() {
			$mod      = 'faq_bg_parallax';
			$enabled  = bx_ext_tm( $mod, false );
			$class    = $enabled ? ' bx-ext-parallax' : '';
			$parallax = bxext_section_parallax( $mod, 'faq_bg_parallax_img', true );
			$format   = '<section id="section-faq" class="grid-wrap sec-faq%1$s"%2$s>';

			$output = sprintf( $format, $class, $parallax );
			$output = apply_filters( 'bx_ext_part___faq_wrap_start', $output, $format, $class, $parallax );

			echo $output;
		}
	}

	// Section wrapper - end
	if( ! function_exists( 'bx_ext_part__faq_wrap_end' ) ) {
		function bx_ext_part__faq_wrap_end() {
			?></section><?php
		}
	}

		// Overlay
		if( ! function_exists( 'bx_ext_part__faq_overlay' ) ) {
			function bx_ext_part__faq_overlay() {
				$section = 'faq';
				$show    = bx_ext_tm( 'faq_bg_overlay', false );
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
		if( ! function_exists( 'bx_ext_part__faq_container' ) ) {
 			function bx_ext_part__faq_container() {
 				/**
 				 * Hooked:
 				 * bx_ext_part__faq_container_start   - 10
 				 * bx_ext_part__faq_header            - 20
 				 * bx_ext_part__faq_helper            - 30
 				 * bx_ext_part__faq_items             - 40
 				 * bx_ext_part__faq_container_end     - 999
 				 */
 				do_action( 'bx_ext_part__faq_container' );
 			}
 		}

			// Container start
			if( ! function_exists( 'bx_ext_part__faq_container_start' ) ) {
				function bx_ext_part__faq_container_start() {
					?><div class="grid-container grid-1 clearfix"><?php
				}
			}

			// Container end
			if( ! function_exists( 'bx_ext_part__faq_container_end' ) ) {
				function bx_ext_part__faq_container_end() {
					?></div><?php
				}
			}

			// Header
			if( ! function_exists( 'bx_ext_part__faq_header' ) ) {
				function bx_ext_part__faq_header() {
					$title = bx_ext_tm( 'faq_section_title', esc_html__( 'Frequently Asked Questions', 'businessx-extensions' ) );
					$desc  = bx_ext_tm( 'faq_section_description', esc_html__( 'This is a description for the FAQ section. You can set it up in the Customizer where you can also add items for it.', 'businessx-extensions' ) );

					if( $title != '' || $desc != '' ) {
						/**
						 * Hooked:
						 * bx_ext_part__faq_header_start       - 10
						 * bx_ext_part__faq_header_title       - 20
						 * bx_ext_part__faq_header_description - 30
						 * bx_ext_part__faq_header_end         - 999
						 */
						do_action( 'bx_ext_part__faq_header' );
					}
				}
			}

				// Header start
				if( ! function_exists( 'bx_ext_part__faq_header_start' ) ) {
					function bx_ext_part__faq_header_start() {
						?><header class="section-header"><?php
					}
				}

				// Header end
				if( ! function_exists( 'bx_ext_part__faq_header_end' ) ) {
					function bx_ext_part__faq_header_end() {
						?></header><?php
					}
				}

				// Section title
				if( ! function_exists( 'bx_ext_part__faq_header_title' ) ) {
					function bx_ext_part__faq_header_title() {
						$section = 'faq';
						$title   = bxext_sections_strings( $section, 'title' );
						$format  = '<h2 class="section-title hs-primary-medium hb-bottom-large %1$s">%2$s</h2>%3$s';
						$divider = '<div class="divider"></div>';
						$anim    = businessx_anim_classes( true );

						$output  = sprintf( $format, $anim, esc_html( $title ), $divider );
						$output  = apply_filters(
							'bx_ext_part___faq_header_title',
							$output, $format, $anim, $title, $divider, $section
						);

						if( $title == '' ) return; // Do nothing

						echo $output;
					}
				}

				// Section description
				if( ! function_exists( 'bx_ext_part__faq_header_description' ) ) {
					function bx_ext_part__faq_header_description() {
						$section = 'faq';
						$desc    = bxext_sections_strings( $section, 'description' );
						$format  = '<p class="section-description fs-large %1$s">%2$s</p>';
						$anim    = businessx_anim_classes( true );

						$output  = sprintf( $format, $anim, bxext_escape_content_filtered_nonp( $desc ) );
						$output  = apply_filters(
							'bx_ext_part___faq_header_description',
							$output, $format, $anim, $desc, $section
						);

						if( $desc == '' ) return; // Do nothing

						echo $output;
					}
				}

			// Helper
			if( ! function_exists( 'bx_ext_part__faq_helper' ) ) {
				function bx_ext_part__faq_helper() {
					$helpers = bx_ext_tm( 'disable_helpers', false );
					$format  = '<div class="grid-col grid-4x-col ta-center">%s</div>';
					$message = __( 'You can find options for this section in: <b>Customizer > Front Page Sections > FAQ Section</b> and add items by clicking on <b>Add or edit questions</b>. You can also disable this message from <b>Customizer > Settings > Extensions > Disable helpers/placeholders</b>.', 'businessx-extensions' );
					$output  = sprintf( $format, $message );
					$output  = apply_filters( 'bx_ext_part___faq_helper', $output, $format, $message, $helpers );

					if ( ! is_active_sidebar( 'section-faq' ) && ! $helpers ) {
						echo $output;
					}
				}
			}

			/**
			 * Items
			 */
			if( ! function_exists( 'bx_ext_part__faq_items' ) ) {
				function bx_ext_part__faq_items() {
					/**
					 * Hooked:
					 * bx_ext_part__faq_items_start    - 10
					 * bx_ext_part__faq_items_sizer    - 20
					 * bx_ext_part__faq_items_display  - 30
					 * bx_ext_part__faq_items_end      - 999
					 */
					do_action( 'bx_ext_part__faq_items' );
				}
			}

				// Items start
				if( ! function_exists( 'bx_ext_part__faq_items_start' ) ) {
					function bx_ext_part__faq_items_start() {
						?><div id="sec-faq-items" class="js-masonry grid-masonry-wrap grid-items clearfix <?php businessx_anim_classes(); ?>"
				        	data-masonry-options='{ "columnWidth": ".sec-faq-grid-sizer", "gutter": ".sec-faq-gutter-sizer", "percentPosition": true, "itemSelector": ".grid-col" }'><?php
					}
				}

				// Items end
				if( ! function_exists( 'bx_ext_part__faq_items_end' ) ) {
					function bx_ext_part__faq_items_end() {
						?></div><?php
					}
				}

				// Items sizer
				if( ! function_exists( 'bx_ext_part__faq_items_sizer' ) ) {
					function bx_ext_part__faq_items_sizer() {
						?>
						<div class="sec-faq-grid-sizer"></div>
			            <div class="sec-faq-gutter-sizer"></div>
						<?php
					}
				}

				// Items display
				if( ! function_exists( 'bx_ext_part__faq_items_display' ) ) {
					function bx_ext_part__faq_items_display() {
						if ( is_active_sidebar( 'section-faq' ) && ! is_paged() ) {
							dynamic_sidebar( 'section-faq' );
						}
					}
				}

		// Javascript
		if( ! function_exists( 'bx_ext_part__faq_js' ) ) {
			function bx_ext_part__faq_js() {
				if( is_customize_preview() ) {
				?>
				<script type='text/javascript'>
					jQuery( document ).ready( function( $ ) {
						$('#sec-faq-items').masonry();
						if ( 'undefined' !== typeof wp && wp.customize && wp.customize.selectiveRefresh  ) {
							wp.customize.selectiveRefresh.bind( 'sidebar-updated', function( sidebarPartial ) {
								if ( 'section-faq' === sidebarPartial.sidebarId ) {
									$('#sec-faq-items').masonry( 'reloadItems' );
									$('#sec-faq-items').masonry( 'layout' );
								}
							} );
						}
					});
				</script>
				<?php
				}
			}
		}
