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
	 * Testimonials Section
	 * --------------------
	 */

	// Section wrapper - start
	if( ! function_exists( 'bx_ext_part__testimonials_wrap_start' ) ) {
		function bx_ext_part__testimonials_wrap_start() {
			$mod      = 'testimonials_bg_parallax';
			$enabled  = bx_ext_tm( $mod, false );
			$class    = $enabled ? ' bx-ext-parallax' : '';
			$parallax = bxext_section_parallax( $mod, 'testimonials_bg_parallax_img', true );
			$format   = '<section id="section-testimonials" class="grid-wrap sec-testimonials%1$s"%2$s>';

			$output = sprintf( $format, $class, $parallax );
			$output = apply_filters( 'bx_ext_part___testimonials_wrap_start', $output, $format, $class, $parallax );

			echo $output;
		}
	}

	// Section wrapper - end
	if( ! function_exists( 'bx_ext_part__testimonials_wrap_end' ) ) {
		function bx_ext_part__testimonials_wrap_end() {
			?></section><?php
		}
	}

		// Overlay
		if( ! function_exists( 'bx_ext_part__testimonials_overlay' ) ) {
			function bx_ext_part__testimonials_overlay() {
				$section = 'testimonials';
				$show    = bx_ext_tm( 'testimonials_bg_overlay', false );
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
		if( ! function_exists( 'bx_ext_part__testimonials_container' ) ) {
 			function bx_ext_part__testimonials_container() {
 				/**
 				 * Hooked:
 				 * bx_ext_part__testimonials_container_start   - 10
 				 * bx_ext_part__testimonials_header            - 20
 				 * bx_ext_part__testimonials_container_end     - 999
 				 */
 				do_action( 'bx_ext_part__testimonials_container' );
 			}
 		}

			// Container start
			if( ! function_exists( 'bx_ext_part__testimonials_container_start' ) ) {
				function bx_ext_part__testimonials_container_start() {
					?><div class="grid-container grid-1 clearfix"><?php
				}
			}

			// Container end
			if( ! function_exists( 'bx_ext_part__testimonials_container_end' ) ) {
				function bx_ext_part__testimonials_container_end() {
					?></div><?php
				}
			}

				// Header
				if( ! function_exists( 'bx_ext_part__testimonials_header' ) ) {
					function bx_ext_part__testimonials_header() {
						/**
						 * Hooked:
						 * bx_ext_part__testimonials_header_start       - 10
						 * bx_ext_part__testimonials_header_title       - 20
						 * bx_ext_part__testimonials_header_end         - 999
						 */
						do_action( 'bx_ext_part__testimonials_header' );
					}
				}

					// Header start
					if( ! function_exists( 'bx_ext_part__testimonials_header_start' ) ) {
						function bx_ext_part__testimonials_header_start() {
							?><header class="section-header"><?php
						}
					}

					// Header end
					if( ! function_exists( 'bx_ext_part__testimonials_header_end' ) ) {
						function bx_ext_part__testimonials_header_end() {
							?></header><?php
						}
					}

					// Section title
					if( ! function_exists( 'bx_ext_part__testimonials_header_title' ) ) {
						function bx_ext_part__testimonials_header_title() {
							$section = 'testimonials';
							$title   = bxext_sections_strings( $section, 'title' );
							$format  = '<h2 class="section-title hs-primary-medium hb-bottom-large %1$s">%2$s</h2>';
							$anim    = businessx_anim_classes( true );

							$output  = sprintf( $format, $anim, esc_html( $title ) );
							$output  = apply_filters(
								'bx_ext_part___testimonials_header_title',
								$output, $format, $anim, $title, $section
							);

							if( $title == '' ) return; // Do nothing

							echo $output;
						}
					}

		// Helper
		if( ! function_exists( 'bx_ext_part__testimonials_helper' ) ) {
			function bx_ext_part__testimonials_helper() {
				$helper  = bx_ext_tm( 'disable_helpers', false );
				$message = __( 'You can find options for this section in: <b>Customizer > Sections > Testimonials Section</b> and add items by clicking on <b>Add or edit testimonials</b>. You can also disable this message from <b>Customizer > Settings > Extensions > Disable helpers/placeholders</b>.', 'businessx-extensions' );
				$format  = '<div class="grid-container grid-1 clearfix"><div class="grid-col grid-4x-col ta-center">%s</div></div>';
				$output  = sprintf( $format, $message );
				$output  = apply_filters( 'bx_ext_part___testimonials_helper', $output, $format, $message );

				if( ! is_active_sidebar( 'section-testimonials' ) ) {
					if ( ! $helper ) {
						echo $output;
					}
				}
			}
		}

		/**
		 * Items
		 */
		if( ! function_exists( 'bx_ext_part__testimonials_items' ) ) {
			function bx_ext_part__testimonials_items() {
				/**
				 * Hooked:
				 * bx_ext_part__testimonials_items_start    - 10
				 * bx_ext_part__testimonials_items_display  - 20
				 * bx_ext_part__testimonials_items_end      - 999
				 */
				do_action( 'bx_ext_part__testimonials_items' );
			}
		}

			// Items start
			if( ! function_exists( 'bx_ext_part__testimonials_items_start' ) ) {
				function bx_ext_part__testimonials_items_start() {
					$anim = businessx_anim_classes( true );
					?><div class="owl-carousel bx-testimonials-carousel <?php echo $anim; ?>"><?php
				}
			}

			// Items end
			if( ! function_exists( 'bx_ext_part__testimonials_items_end' ) ) {
				function bx_ext_part__testimonials_items_end() {
					?></div><?php
				}
			}

			// Items display
			if( ! function_exists( 'bx_ext_part__testimonials_items_display' ) ) {
				function bx_ext_part__testimonials_items_display() {
					if ( is_active_sidebar( 'section-testimonials' ) && ! is_paged() ) {
						dynamic_sidebar( 'section-testimonials' );
					};
				}
			}

		/**
		 * Navigation
		 */
		if( ! function_exists( 'bx_ext_part__testimonials_nav' ) ) {
			function bx_ext_part__testimonials_nav() {
				/**
				 * Hooked:
				 * bx_ext_part__testimonials_nav_start    - 10
				 * bx_ext_part__testimonials_nav_prev     - 20
				 * bx_ext_part__testimonials_nav_next     - 30
				 * bx_ext_part__testimonials_nav_end      - 999
				 */
				do_action( 'bx_ext_part__testimonials_nav' );
			}
		}

			// Navigation start
			if( ! function_exists( 'bx_ext_part__testimonials_nav_start' ) ) {
				function bx_ext_part__testimonials_nav_start() {
					$anim = businessx_anim_classes( true );
					?>
					<nav class="sec-testimonials-nav clearfix <?php echo $anim; ?>">
						<div class="sec-testimonials-nav-btns">
					<?php
				}
			}

			// Navigation end
			if( ! function_exists( 'bx_ext_part__testimonials_nav_end' ) ) {
				function bx_ext_part__testimonials_nav_end() {
					?>
						</div>
					</nav>
					<?php
				}
			}

				// Navigation previous
				if( ! function_exists( 'bx_ext_part__testimonials_nav_prev' ) ) {
					function bx_ext_part__testimonials_nav_prev() {
						$icon   = businessx_icon( 'angle-left', false );
						$format = '<a href="#" class="sec-testimonials-nav-btn-prev">%s</a>';
						$output = sprintf( $format, $icon );
						$output = apply_filters( 'bx_ext_part___testimonials_nav_prev', $output, $format, $icon );

						echo $output;
					}
				}

				// Navigation next
				if( ! function_exists( 'bx_ext_part__testimonials_nav_next' ) ) {
					function bx_ext_part__testimonials_nav_next() {
						$icon   = businessx_icon( 'angle-right', false );
						$format = '<a href="#" class="sec-testimonials-nav-btn-next">%s</a>';
						$output = sprintf( $format, $icon );
						$output = apply_filters( 'bx_ext_part___testimonials_nav_next', $output, $format, $icon );

						echo $output;
					}
				}

		// Javascript
		if( ! function_exists( 'bx_ext_part__testimonials_js' ) ) {
			function bx_ext_part__testimonials_js() {
				?>
				<script type='text/javascript'>
					jQuery( document ).ready( function( $ ) {

						/* Create Testimonials */
						function bx_createTestimonials() {
							$( '.bx-testimonials-carousel' ).owlCarousel({
								responsiveClass: true,
								center:          true,
								items:           2,
								nav:             false,
								dots:            false,
								loop:            false,
								margin:          50,
								responsive: {
									200: {
										items: 1
									},
									765: {
										items: 2
									},
								},
							});
						};

						/* Navigation Arrows */
						$('.sec-testimonials .sec-testimonials-nav-btn-next').click(function(event) { event.preventDefault();  $( '.bx-testimonials-carousel' ).trigger('next.owl.carousel', [200]); });
						$('.sec-testimonials .sec-testimonials-nav-btn-prev').click(function(event) { event.preventDefault();  $( '.bx-testimonials-carousel' ).trigger('prev.owl.carousel', [200]); });

						/* Initialize */
						bx_createTestimonials();

						<?php if( is_customize_preview() ) : ?>

						/* Destroy it */
						function bx_destroyTestimonials() {
							var selector = '.bx-testimonials-carousel'
							$(selector).removeClass('owl-loaded owl-drag');
							$(selector + ' .owl-stage').children().unwrap();
							$(selector + ' .owl-stage-outer').children().unwrap();
							$(selector).find('.owl-stage').remove();
							$(selector).find('.owl-nav').remove();
							$(selector).find('.owl-dots').remove();
							$(selector + ' .sec-testimonial-wrap').each(function(index, element) {
			                    $(element).removeClass('owl-item').removeClass('active').removeClass('center').removeClass('cloned').removeAttr('style'); });
							$(selector).removeData();
						}

						/* Customizer Selective Refresh */
						if ( 'undefined' !== typeof wp && wp.customize  ) {
							wp.customize.selectiveRefresh.bind( 'sidebar-updated', function( sidebarPartial ) {
								if ( 'section-testimonials' === sidebarPartial.sidebarId ) {
									bx_destroyTestimonials();
									bx_createTestimonials();
								}
							});
						}

						<?php endif; ?>

					});
				</script>
				<?php
			}
		}
