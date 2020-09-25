<?php
/**
 * -------------
 * Item partials
 * -------------
 *
 * @see ../inc/partials/items-hooks.php
 */


	/**
	 * Pricing item
	 * ------------
	 */

	// Badge
	if( ! function_exists( 'bx_ext_item__pricing_badge' ) ) {
		function bx_ext_item__pricing_badge( $widget_options ) {
			$badge   = $widget_options['badge'];
			$format  = '<div class="package-badge ta-center">';
			$format .= '<strong class="badge"><span class="fs-smallest">%s</span></strong>';
			$format .= '</div>';

			$output = sprintf( $format, esc_html( $badge ) );
			$output = apply_filters( 'bx_ext_item___pricing_badge', $output, $format, $widget_options );

			if( $badge == '' ) return;

			echo $output;
		}
	}

	// Info
	if( ! function_exists( 'bx_ext_item__pricing_info' ) ) {
		function bx_ext_item__pricing_info( $widget_options ) {
			/**
			 * Hooked:
			 * bx_ext_item__pricing_info_start       - 10
			 * bx_ext_item__pricing_info_title       - 20
			 * bx_ext_item__pricing_info_pricing     - 30
			 * bx_ext_item__pricing_info_end         - 999
			 */
			do_action( 'bx_ext_item__pricing_info', $widget_options );
		}
	}

		// Info start
		if( ! function_exists( 'bx_ext_item__pricing_info_start' ) ) {
			function bx_ext_item__pricing_info_start( $widget_options ) {
				?><header class="package-info clearfix"><?php
			}
		}

		// Info end
		if( ! function_exists( 'bx_ext_item__pricing_info_end' ) ) {
			function bx_ext_item__pricing_info_end( $widget_options ) {
				?></header><?php
			}
		}

		// Title
		if( ! function_exists( 'bx_ext_item__pricing_info_title' ) ) {
			function bx_ext_item__pricing_info_title( $widget_options ) {
				$title   = $widget_options['title'];
				$format  = '<h4 class="fw-regular ls-min hb-bottom-smaller alignleft">%s</h4>';

				$output = sprintf( $format, esc_html( $title ) );
				$output = apply_filters( 'bx_ext_item___pricing_info_title', $output, $format, $widget_options );

				echo $output;
			}
		}

		// Pricing
		if( ! function_exists( 'bx_ext_item__pricing_info_pricing' ) ) {
			function bx_ext_item__pricing_info_pricing( $widget_options ) {
				// Do nothing if price is empty
				if( $widget_options['price'] == '' ) return;

				/**
				 * Hooked:
				 * bx_ext_item__pricing_info_pricing_start       - 10
				 * bx_ext_item__pricing_info_pricing_price       - 20
				 * bx_ext_item__pricing_info_pricing_period      - 30
				 * bx_ext_item__pricing_info_pricing_end         - 999
				 */
				do_action( 'bx_ext_item__pricing_info_pricing', $widget_options );
			}
		}

			// Pricing start
			if( ! function_exists( 'bx_ext_item__pricing_info_pricing_start' ) ) {
				function bx_ext_item__pricing_info_pricing_start( $widget_options ) {
					?><div class="package-pricing alignright"><?php
				}
			}

			// Pricing end
			if( ! function_exists( 'bx_ext_item__pricing_info_pricing_end' ) ) {
				function bx_ext_item__pricing_info_pricing_end( $widget_options ) {
					?></div><?php
				}
			}

			// Price
			if( ! function_exists( 'bx_ext_item__pricing_info_pricing_price' ) ) {
				function bx_ext_item__pricing_info_pricing_price( $widget_options ) {
					$price   = $widget_options['price'];
					$format  = '<span class="package-price">%s</span>';

					$output = sprintf( $format, esc_html( $price ) );
					$output = apply_filters( 'bx_ext_item___pricing_info_pricing_price', $output, $format, $widget_options );

					echo $output;
				}
			}

			// Period
			if( ! function_exists( 'bx_ext_item__pricing_info_pricing_period' ) ) {
				function bx_ext_item__pricing_info_pricing_period( $widget_options ) {
					$period   = $widget_options['period'];
					$format  = '<span class="package-period fw-regular ls-min">%s</span>';

					$output = sprintf( $format, esc_html( $period ) );
					$output = apply_filters( 'bx_ext_item___pricing_info_pricing_period', $output, $format, $widget_options );

					echo $output;
				}
			}

	// Contents
	if( ! function_exists( 'bx_ext_item__pricing_contents' ) ) {
		function bx_ext_item__pricing_contents( $widget_options ) {
			/**
			 * Hooked:
			 * bx_ext_item__pricing_contents_start       - 10
			 * bx_ext_item__pricing_contents_list        - 20
			 * bx_ext_item__pricing_contents_button      - 30
			 * bx_ext_item__pricing_contents_end         - 999
			 */
			do_action( 'bx_ext_item__pricing_contents', $widget_options );
		}
	}

		// Contents start
		if( ! function_exists( 'bx_ext_item__pricing_contents_start' ) ) {
			function bx_ext_item__pricing_contents_start( $widget_options ) {
				?><div class="package-contents"><?php
			}
		}

		// Contents end
		if( ! function_exists( 'bx_ext_item__pricing_contents_end' ) ) {
			function bx_ext_item__pricing_contents_end( $widget_options ) {
				?></div><?php
			}
		}

		// List
		if( ! function_exists( 'bx_ext_item__pricing_contents_list' ) ) {
			function bx_ext_item__pricing_contents_list( $widget_options ) {
				$list   = $widget_options['list'];
				$icos   = $widget_options['icos'];
				$output = apply_filters( 'bx_ext_item___pricing_contents_list', array(
					'before' => '<ul>',
					'after'  => '</ul>',
					'format' => '<li>%1$s%2$s</li>',
					'check'  => businessx_icon( 'check', false ) . ' ',
					'remove' => businessx_icon( 'remove', false ) . ' ',
				), $widget_options );
				$check  = $output['check'];
				$remove = $output['remove'];
				$ico    ='';

				if( $list == '') return; // Do nothing if empty

				echo $output['before'];
				foreach ( $list as $item ) {
					// Show icon
					if( $icos ) {
						$ico = ( $item[ 'status'] == 'available' ) ?  $check : $remove;
					}

					// Display the item
					if( $item[ 'item'] != '' ) {
						printf( $output['format'], $ico, esc_html( $item[ 'item' ] ) );
					}
				}
				echo $output['after'];
			}
		}

		// Button
		if( ! function_exists( 'bx_ext_item__pricing_contents_button' ) ) {
			function bx_ext_item__pricing_contents_button( $widget_options ) {
				$anchor = $widget_options['btn_anchor'];
				$url    = $widget_options['btn_url'];
				$target = $widget_options['btn_target'];
				$format = '<div class="package-btn"><a href="%1$s" target="%2$s" class="ac-btn btn-big btn-width-100">%3$s</a></div>';

				$output = sprintf( $format, esc_url( $url ), esc_attr( $target ), esc_html( $anchor ) );
				$output = apply_filters( 'bx_ext_item___pricing_contents_button',  $output, $format, $widget_options );

				if( $anchor == '' ) return;

				echo $output;
			}
		}
