<?php
/**
 * -------------
 * Item partials
 * -------------
 *
 * @see ../inc/partials/items-hooks.php
 */


	/**
	 * Actions item
	 * ------------
	 */

	// Overlay
	if( ! function_exists( 'bx_ext_item__actions_overlay' ) ) {
		function bx_ext_item__actions_overlay( $widget_options ) {
			$overlay  = $widget_options['overlay'];
			$opacity  = $widget_options['opacity'];
			$overopa  = $opacity != '0' ? ' style="opacity: ' . $opacity . '"' : '';
			$format   = '<div class="grid-overlay"%s></div>';
			$output   = sprintf( $format, $overopa );
			$output   = apply_filters( 'bx_ext_item___actions_overlay', $output, $format, $widget_options );

			if( $overlay && $opacity != '0' ) {
				echo $output;
			}
		}
	}

	// Container
	if( ! function_exists( 'bx_ext_item__actions_container' ) ) {
		function bx_ext_item__actions_container( $widget_options ) {
			/**
			 * Hooked:
			 * bx_ext_item__actions_container_start       - 10
			 * bx_ext_item__actions_container_image       - 20
			 * bx_ext_item__actions_container_meta        - 30
			 * bx_ext_item__actions_container_end         - 999
			 */
			do_action( 'bx_ext_item__actions_container', $widget_options );
		}
	}

		// Container start
		if( ! function_exists( 'bx_ext_item__actions_container_start' ) ) {
			function bx_ext_item__actions_container_start( $widget_options ) {
				?><div class="grid-container grid-1 clearfix <?php businessx_anim_classes(); ?>"><?php
			}
		}

		// Container end
		if( ! function_exists( 'bx_ext_item__actions_container_end' ) ) {
			function bx_ext_item__actions_container_end( $widget_options ) {
				?></div><!-- END .grid-container --><?php
			}
		}

		// Image
		if( ! function_exists( 'bx_ext_item__actions_container_image' ) ) {
			function bx_ext_item__actions_container_image( $widget_options ) {
				$image     = $widget_options['image'];
				$alignment = $widget_options['alignment'];
				$align     = ( $alignment == 'left' ) ? '' : ' style="float:right; margin-right: 0;"';
				$format    = '<div class="grid-col grid-2x-col elements-thumb" %1$s>';
				$format   .= '<img class="sec-ribbon-item-tmb" src="%2$s" alt="image" />';
				$format   .= '</div><!-- END .elements-thumb -->';

				$output = sprintf( $format, $align, esc_url( $image ) );
				$output = apply_filters( 'bx_ext_item___actions_container_image', $output, $format, $widget_options );

				if( $image == '' ) return;

				echo $output;
			}
		}

		// Meta
		if( ! function_exists( 'bx_ext_item__actions_container_meta' ) ) {
			function bx_ext_item__actions_container_meta( $widget_options ) {
				/**
				 * Hooked:
				 * bx_ext_item__actions_container_meta_start       - 10
				 * bx_ext_item__actions_container_meta_title       - 20
				 * bx_ext_item__actions_container_meta_excerpt     - 30
				 * bx_ext_item__actions_container_meta_buttons     - 40
				 * bx_ext_item__actions_container_meta_end         - 999
				 */
				do_action( 'bx_ext_item__actions_container_meta', $widget_options );
			}
		}

			// Meta start
			if( ! function_exists( 'bx_ext_item__actions_container_meta_start' ) ) {
				function bx_ext_item__actions_container_meta_start( $widget_options ) {
					$image   = $widget_options['image'];
					$classes = ( $image != '' ) ? 'grid-2x-col' : 'grid-4x-col ta-center';
					$format  = '<div class="grid-col %s elements-meta last-col">';

					$output  = sprintf( $format, $classes );
					$output  = apply_filters( 'bx_ext_item___actions_container_meta_start', $output, $format, $classes, $widget_options );

					echo $output;
				}
			}

			// Meta end
			if( ! function_exists( 'bx_ext_item__actions_container_meta_end' ) ) {
				function bx_ext_item__actions_container_meta_end( $widget_options ) {
					?></div><!-- END .elements-meta --><?php
				}
			}

			// Title
			if( ! function_exists( 'bx_ext_item__actions_container_meta_title' ) ) {
				function bx_ext_item__actions_container_meta_title( $widget_options ) {
					$title  = $widget_options['title'];
					$format = '<h2 class="hs-primary-medium">%s</h2>';

					$output = sprintf( $format, esc_html( $title ) );
					$output = apply_filters( 'bx_ext_item___actions_container_meta_title', $output, $format, $widget_options );

					echo $output;
				}
			}

			// Excerpt
			if( ! function_exists( 'bx_ext_item__actions_container_meta_excerpt' ) ) {
				function bx_ext_item__actions_container_meta_excerpt( $widget_options ) {
					$excerpt  = $widget_options['excerpt'];
					$allowed  = $widget_options['allowed_html'];
					$format   = '<div class="elements-excerpt fs-large">%s</div>';

					$output = sprintf( $format, businessx_ext_escape_content_filtered( $excerpt ) );
					$output = apply_filters( 'bx_ext_item___actions_container_meta_excerpt', $output, $format, $widget_options );

					if( $excerpt == '' ) return;

					echo $output;
				}
			}

			// Buttons
			if( ! function_exists( 'bx_ext_item__actions_container_meta_buttons' ) ) {
				function bx_ext_item__actions_container_meta_buttons( $widget_options ) {
					$excerpt         = $widget_options['excerpt'];
					$allowed         = $widget_options['allowed_html'];
					$show_btn_1      = $widget_options['show_btn_1'];
					$show_btn_2      = $widget_options['show_btn_2'];
					$btn_1_title     = $widget_options['btn_1_title'];
					$btn_2_title     = $widget_options['btn_2_title'];
					$btn_1_url       = $widget_options['btn_1_url'];
					$btn_2_url       = $widget_options['btn_2_url'];
					$button_1_target = $widget_options['btn_1_target'] ? '_blank' : '_self';
					$button_2_target = $widget_options['btn_2_target'] ? '_blank' : '_self';
					$or              = $widget_options['or'];

					$before = '<div class="elements-buttons">';
					$after  = '</div>';
					$or_btn = $show_btn_1 ? '<span class="ac-btns-or fw-bolder">' . esc_html( $or ) . '</span>' : '';
					$btn1   = ( $show_btn_1 && $btn_1_title != '' ) ? '<a href="' . esc_url( $btn_1_url ) . '" target="' . $button_1_target . '" class="ac-btn btn-big btn-1">' . esc_html( $btn_1_title ) . '</a>' : '';
					$btn2   = ( $show_btn_2 && $btn_2_title != '' ) ? $or_btn . '<a href="' . esc_url( $btn_2_url ) . '" target="' . $button_2_target . '" class="ac-btn btn-big btn-2">' . esc_html( $btn_2_title ) . '</a>' : '';

					$output = $before . $btn1 . $btn2 . $after;
					$output = apply_filters( 'bx_ext_item___actions_container_meta_buttons', $output, $widget_options );

					if( $show_btn_1 || $show_btn_2 ) {
						echo $output;
					}
				}
			}
