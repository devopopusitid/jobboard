<?php
/**
 * -------------
 * Item partials
 * -------------
 *
 * @see ../inc/partials/items-hooks.php
 */


	/**
	 * Features item
	 * -------------
	 */

	// Figure
	if( ! function_exists( 'bx_ext_item__features_figure' ) ) {
		function bx_ext_item__features_figure( $widget_options ) {
			$show  = $widget_options['show_figure'];
			$type  = $widget_options['figure_type'];
			$icon  = $widget_options['figure_icon'];
			$image = $widget_options['figure_image'];
			$title = $widget_options['title'];
			$format = $output = '';

			switch ( $type ) {
				case 'ft-icon':
					$format = ( $icon != '' ) ? '<figure class="sec-feature-figure">%s</figure>' : '';
					$output = ( $format != '' ) ? sprintf( $format, businessx_icon( $icon, FALSE, FALSE ) ) : '';
					break;
				case 'ft-image':
					$format = ( $image != '' ) ? '<figure class="sec-feature-figure-img"><img src="%s" alt="image" /></figure>' : '';
					$output = ( $format != '' ) ? sprintf( $format, esc_url( $image ) ) : '';
					break;
			}

			$output = apply_filters( 'bx_ext_item___features_figure', $output, $widget_options );

			if( $show ) {
				echo $output;
			}
		}
	}

	// Contents
	if( ! function_exists( 'bx_ext_item__features_contents' ) ) {
		function bx_ext_item__features_contents( $widget_options ) {
			/**
			 * Hooked:
			 * bx_ext_item__features_contents_start       - 10
			 * bx_ext_item__features_contents_title       - 20
			 * bx_ext_item__features_contents_excerpt     - 30
			 * bx_ext_item__features_contents_button      - 40
			 * bx_ext_item__features_contents_end         - 999
			 */
			do_action( 'bx_ext_item__features_contents', $widget_options );
		}
	}

		// Contents start
		if( ! function_exists( 'bx_ext_item__features_contents_start' ) ) {
			function bx_ext_item__features_contents_start( $widget_options ) {
				?><div class="contents-wrap clearfix"><?php
			}
		}

		// Contents end
		if( ! function_exists( 'bx_ext_item__features_contents_end' ) ) {
			function bx_ext_item__features_contents_end( $widget_options ) {
				?></div><!-- END .grid-container --><?php
			}
		}

		// Title
		if( ! function_exists( 'bx_ext_item__features_contents_title' ) ) {
			function bx_ext_item__features_contents_title( $widget_options ) {
				$title        = $widget_options['title'];
				$title_output = $widget_options['title_output'];
				$format       = '<h3 class="hs-secondary-small">%s</h3>';

				$output = sprintf( $format, $title_output );
				$output = apply_filters( 'bx_ext_item___features_contents_title', $output, $format, $widget_options );

				if( $title == '' ) return;

				echo $output;
			}
		}

		// Excerpt
		if( ! function_exists( 'bx_ext_item__features_contents_excerpt' ) ) {
			function bx_ext_item__features_contents_excerpt( $widget_options ) {
				$excerpt  = $widget_options['excerpt'];
				$allowed  = $widget_options['allowed_html'];
				$format   = '<p>%s</p>';

				$output = sprintf( $format, businessx_content_filter( $excerpt, $allowed ) );
				$output = apply_filters( 'bx_ext_item___features_contents_excerpt', $output, $format, $widget_options );

				if( $excerpt == '' ) return;

				echo $output;
			}
		}

		// Button
		if( ! function_exists( 'bx_ext_item__features_contents_button' ) ) {
			function bx_ext_item__features_contents_button( $widget_options ) {
				$anchor = $widget_options['btn_anchor'];
				$url    = $widget_options['btn_url'];
				$target = $widget_options['btn_target'];
				$format = '<a href="%1$s" target="%2$s" class="ac-btn-alt fw-bolder">%3$s</a>';

				$output = sprintf( $format, esc_url( $url ), esc_attr( $target ), esc_html( $anchor ) );
				$output = apply_filters( 'bx_ext_item___features_contents_button', $output, $format, $widget_options );

				if( $anchor == '' ) return;

				echo $output;
			}
		}
