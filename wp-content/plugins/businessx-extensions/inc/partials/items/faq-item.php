<?php
/**
 * -------------
 * Item partials
 * -------------
 *
 * @see ../inc/partials/items-hooks.php
 */


	/**
	 * FAQ item
	 * --------
	 */

	// Title
	if( ! function_exists( 'bx_ext_item__faq_title' ) ) {
		function bx_ext_item__faq_title( $widget_options ) {
			$title        = $widget_options['title'];
			$title_output = $widget_options['title_output'];
			$format       = '<h3 class="hs-secondary-small hb-bottom-small">%s</h3>';

			$output = sprintf( $format, $title_output );
			$output = apply_filters( 'bx_ext_item___faq_title', $output, $format, $widget_options );

			if( $title == '' ) return;

			echo $output;
		}
	}

	// Excerpt
	if( ! function_exists( 'bx_ext_item__faq_excerpt' ) ) {
		function bx_ext_item__faq_excerpt( $widget_options ) {
			$excerpt      = $widget_options['excerpt'];
			$allowed_html = $widget_options['allowed_html'];

			$output = businessx_ext_escape_content_filtered( $excerpt );
			$output = apply_filters( 'bx_ext_item___faq_excerpt', $output, $widget_options );

			if( $excerpt == '' ) return;

			echo $output;
		}
	}
