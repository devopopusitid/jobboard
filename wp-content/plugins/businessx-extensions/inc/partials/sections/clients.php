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
	 * Clients Section
	 * ---------------
	 */

	// Section wrapper - start
	if( ! function_exists( 'bx_ext_part__clients_wrap_start' ) ) {
		function bx_ext_part__clients_wrap_start() {
			$mod      = 'clients_bg_parallax';
			$enabled  = bx_ext_tm( $mod, false );
			$class    = $enabled ? ' bx-ext-parallax' : '';
			$parallax = bxext_section_parallax( $mod, 'clients_bg_parallax_img', true );
			$format   = '<section id="section-clients" class="grid-wrap sec-clients%1$s"%2$s>';

			$output = sprintf( $format, $class, $parallax );
			$output = apply_filters( 'bx_ext_part___clients_wrap_start', $output, $format, $class, $parallax );

			echo $output;
		}
	}

	// Section wrapper - end
	if( ! function_exists( 'bx_ext_part__clients_wrap_end' ) ) {
		function bx_ext_part__clients_wrap_end() {
			?></section><?php
		}
	}

		// Overlay
		if( ! function_exists( 'bx_ext_part__clients_overlay' ) ) {
			function bx_ext_part__clients_overlay() {
				$section = 'clients';
				$show    = bx_ext_tm( 'clients_bg_overlay', false );
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
		if( ! function_exists( 'bx_ext_part__clients_container' ) ) {
 			function bx_ext_part__clients_container() {
 				/**
 				 * Hooked:
 				 * bx_ext_part__clients_container_start   - 10
 				 * bx_ext_part__clients_items             - 20
 				 * bx_ext_part__clients_container_end     - 999
 				 */
 				do_action( 'bx_ext_part__clients_container' );
 			}
 		}

			// Container start
			if( ! function_exists( 'bx_ext_part__clients_container_start' ) ) {
				function bx_ext_part__clients_container_start() {
					?><div class="grid-container grid-1 clearfix"><?php
				}
			}

			// Container end
			if( ! function_exists( 'bx_ext_part__clients_container_end' ) ) {
				function bx_ext_part__clients_container_end() {
					?></div><?php
				}
			}

			/**
			 * Items
			 */
			if( ! function_exists( 'bx_ext_part__clients_items' ) ) {
				function bx_ext_part__clients_items() {
					/**
					 * Hooked:
					 * bx_ext_part__clients_items_header  - 10
					 * bx_ext_part__clients_items_helper  - 20
					 * bx_ext_part__clients_items_display - 30
					 */
					do_action( 'bx_ext_part__clients_items' );
				}
			}

				// Items header
				if( ! function_exists( 'bx_ext_part__clients_items_header' ) ) {
					function bx_ext_part__clients_items_header() {
						/**
						 * Hooked:
						 * bx_ext_part__clients_items_header_start       - 10
						 * bx_ext_part__clients_items_header_title       - 20
						 * bx_ext_part__clients_items_header_description - 30
						 * bx_ext_part__clients_items_header_end         - 999
						 */
						do_action( 'bx_ext_part__clients_items_header' );
					}
				}

					// Header start
					if( ! function_exists( 'bx_ext_part__clients_items_header_start' ) ) {
						function bx_ext_part__clients_items_header_start() {
							?><header class="section-header"><?php
						}
					}

					// Header end
					if( ! function_exists( 'bx_ext_part__clients_items_header_end' ) ) {
						function bx_ext_part__clients_items_header_end() {
							?></header><?php
						}
					}

					// Section title
					if( ! function_exists( 'bx_ext_part__clients_items_header_title' ) ) {
						function bx_ext_part__clients_items_header_title() {
							$section = 'clients';
							$title   = bxext_sections_strings( $section, 'title' );
							$format  = '<h2 class="section-title hs-primary-medium hb-bottom-large %1$s">%2$s</h2>%3$s';
							$divider = '<div class="divider"></div>';
							$anim    = businessx_anim_classes( true );

							$output  = sprintf( $format, $anim, esc_html( $title ), $divider );
							$output  = apply_filters(
								'bx_ext_part___clients_info_output_title',
								$output, $format, $anim, $title, $divider, $section
							);

							if( $title == '' ) return; // Do nothing

							echo $output;
						}
					}

					// Section description
					if( ! function_exists( 'bx_ext_part__clients_items_header_description' ) ) {
						function bx_ext_part__clients_items_header_description() {
							$section = 'clients';
							$desc    = bxext_sections_strings( $section, 'description' );
							$format  = '<p class="section-description fs-large %1$s">%2$s</p>';
							$anim    = businessx_anim_classes( true );

							$output  = sprintf( $format, $anim, bxext_escape_content_filtered_nonp( $desc ) );
							$output  = apply_filters(
								'bx_ext_part___clients_info_output_description',
								$output, $format, $anim, $desc, $section
							);

							if( $desc == '' ) return; // Do nothing

							echo $output;
						}
					}

				// Helper
				if( ! function_exists( 'bx_ext_part__clients_items_helper' ) ) {
					function bx_ext_part__clients_items_helper() {
						$section = 'clients';
						$name    = __( 'Clients Section', 'businessx-extensions' );
						$hide    = bx_ext_tm( 'disable_helpers', false );
						$before  = '<div class="grid-col grid-4x-col ta-center">';
						$after   = '</div>';

						$helper = __( 'You can find options for this section in: <b>Customizer > Front Page Sections > %s</b> and add items by clicking on <b>Add or edit clients</b>. You can also disable this message from <b>Customizer > Settings > Extensions > Disable helpers/placeholders</b>.', 'businessx-extensions' );

						$output = $before . sprintf( $helper, esc_html( $name ) ) . $after;
						$output = apply_filters( 'bx_ext_part___helper', $output, $section, $before, $after, $helper );

						echo ( ! is_active_sidebar( 'section-clients' ) && ! $hide ) ? $output : '';
					}
				}

				// Items display
				if( ! function_exists( 'bx_ext_part__clients_items_display' ) ) {
					function bx_ext_part__clients_items_display() {
						/**
						 * Hooked:
						 * bx_ext_part__clients_items_display_start       - 10
						 * bx_ext_part__clients_items_display_carousel    - 20
						 * bx_ext_part__clients_items_display_arrows      - 30
						 * bx_ext_part__clients_items_display_end         - 999
						 */
						do_action( 'bx_ext_part__clients_items_display' );
					}
				}

					// Items display start
					if( ! function_exists( 'bx_ext_part__clients_items_display_start' ) ) {
						function bx_ext_part__clients_items_display_start() {
							?><div class="grid-col grid-4x-col"><?php
						}
					}

					// Items display end
					if( ! function_exists( 'bx_ext_part__clients_items_display_end' ) ) {
						function bx_ext_part__clients_items_display_end() {
							?></div><?php
						}
					}

					// Items display carousel
					if( ! function_exists( 'bx_ext_part__clients_items_display_carousel' ) ) {
						function bx_ext_part__clients_items_display_carousel() {
							$anim   = businessx_anim_classes( true );
							$before = '<div class="owl-carousel bx-clients-carousel ' . $anim . '">';
							$after  = '</div>';

							ob_start();
							if ( is_active_sidebar( 'section-clients' ) && ! is_paged() ) { dynamic_sidebar( 'section-clients' ); };
							$clients = ob_get_clean();

							$output  = $before . $clients . $after;
							$output  = apply_filters( 'bx_ext_part___clients_items_display_carousel', $output, $before, $after, $clients, $anim );

							echo $output;
						}
					}

					// Items display arrows
					if( ! function_exists( 'bx_ext_part__clients_items_display_arrows' ) ) {
						function bx_ext_part__clients_items_display_arrows() {
							$anim = businessx_anim_classes( true );
							$wrap = '<nav class="sec-clients-nav clearfix %1$s"><div class="sec-clients-nav-btns">%2$s</div></nav>';
							$prev = '<a href="#" class="sec-clients-nav-btn-prev">' . businessx_icon( 'angle-left', false ) . '</a>';
							$next = '<a href="#" class="sec-clients-nav-btn-next">' . businessx_icon( 'angle-right', false ) . '</a>';
							$buttons = $prev . $next;

							$output = sprintf( $wrap, $anim, $buttons );
							$output = apply_filters( 'bx_ext_part___clients_items_display_arrows', $output, $wrap, $anim, $buttons );

							echo $output;
						}
					}

		// Carousel js
		if( ! function_exists( 'bx_ext_part__clients_js' ) ) {
			function bx_ext_part__clients_js() {
				$autoscroll = bx_ext_tm( 'clients_section_autoscroll' ) == 0 ? 'false' : 'true';
				?>
				<script type='text/javascript'>
					jQuery( document ).ready( function( $ ) {

						/* Create the carousel */
						function bx_createClients() {
							var ap;
							if ( 'undefined' !== typeof wp && wp.customize  ) { ap = false; } else { ap = <?php echo esc_html( $autoscroll ) ?>; }

							$( '.bx-clients-carousel' ).owlCarousel({
								responsiveClass: true,
								nav:             false,
								dots:            false,
								loop:            false,
								autoplay:        ap,
								autoplayTimeout: 3000,
								rewind:          true,
								responsive: {
									0:{
										items: 1,
										nav:   false,
										dots:  false,
									},
									600:{
										items: 2,
										nav:   false,
										dots:  false,
									},
									1000:{
										items: 4,
										nav:   false,
										dots:  false,
									},
								},
							});
						};

						/* Navigation Arrows */
						$('.sec-clients .sec-clients-nav-btn-next').click(function(event) { event.preventDefault();  $( '.bx-clients-carousel' ).trigger('next.owl.carousel', [200]); });
						$('.sec-clients .sec-clients-nav-btn-prev').click(function(event) { event.preventDefault();  $( '.bx-clients-carousel' ).trigger('prev.owl.carousel', [200]); });

						/* Initialize */
						bx_createClients();

						<?php if( is_customize_preview() ) : ?>

						/* Destroy it */
						function bx_destroyClients() {
							var selector = '.bx-clients-carousel'
							$(selector).removeClass('owl-loaded owl-drag');
							$(selector + ' .owl-stage').children().unwrap();
							$(selector + ' .owl-stage-outer').children().unwrap();
							$(selector).find('.owl-stage').remove();
							$(selector).find('.owl-nav').remove();
							$(selector).find('.owl-dots').remove();
							$(selector + ' .sec-client-logo-wrap').each(function(index, element) {
								$(element).removeClass('owl-item').removeClass('active').removeAttr('style'); });
							$(selector).removeData();
						}

						/* Customizer Selective Refresh */
						if ( 'undefined' !== typeof wp && wp.customize  ) {
							wp.customize.selectiveRefresh.bind( 'sidebar-updated', function( sidebarPartial ) {
								if ( 'section-clients' === sidebarPartial.sidebarId ) {
									bx_destroyClients();
									bx_createClients();
								}
							});
						}

						<?php endif; ?>

					});
				</script>
				<?php
			}
		}
