<?php
/**
 * -------------
 * Item partials
 * -------------
 *
 * @see ../inc/partials/items-hooks.php
 */


	/**
	 * Cliens item
	 * -----------
	 */

	// Client
	if( ! function_exists( 'bx_ext_item__client' ) ) {
		function bx_ext_item__client( $widget_options ) {
			$title  = $widget_options['title'];
			$logo   = $widget_options['logo'];
			$url    = $widget_options['url'];
			$target = $widget_options['target'] ? '_blank' : '_self';
			$before = $url != '' ? '<a class="sec-client-logo-url" target="' . $target . '" href="' . esc_url( $url ) . '">' : '';
			$after  = $url != '' ? '</a>' : '';
			$format = '%1$s<img src="%2$s" alt="%3$s" />%4$s';

			$output = sprintf( $format, $before, esc_url( $logo ), esc_attr( $title ), $after );
			$output = apply_filters( 'bx_ext_item___client', $output, $format, $widget_options );

			if( $logo == '' ) return;

			echo $output;
		}
	}
