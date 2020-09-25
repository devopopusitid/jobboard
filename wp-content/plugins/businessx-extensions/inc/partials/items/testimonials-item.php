<?php
/**
 * -------------
 * Item partials
 * -------------
 *
 * @see ../inc/partials/items-hooks.php
 */


	/**
	 * Testimonials item
	 * -----------------
	 */

	// Avatar
	if( ! function_exists( 'bx_ext_item__testimonials_avatar' ) ) {
		function bx_ext_item__testimonials_avatar( $widget_options ) {
			$title  = $widget_options['title'];
			$avatar = $widget_options['avatar'];
			$format = '<figure class="client-avatar"><img src="%1$s" alt="%2$s" /></figure>';

			$output = sprintf( $format, esc_url( $avatar ), esc_attr( $title ) );
			$output = apply_filters( 'bx_ext_item___testimonials_avatar', $output, $format, $widget_options );

			if( $avatar == '' ) return;

			echo $output;
		}
	}

	// Contents
	if( ! function_exists( 'bx_ext_item__testimonials_contents' ) ) {
		function bx_ext_item__testimonials_contents( $widget_options ) {
			/**
			 * Hooked:
			 * bx_ext_item__testimonials_contents_start       - 10
			 * bx_ext_item__testimonials_contents_title       - 20
			 * bx_ext_item__testimonials_contents_testimonial - 30
			 * bx_ext_item__testimonials_contents_button      - 40
			 * bx_ext_item__testimonials_contents_end         - 999
			 */
			do_action( 'bx_ext_item__testimonials_contents', $widget_options );
		}
	}

		// Contents start
		if( ! function_exists( 'bx_ext_item__testimonials_contents_start' ) ) {
			function bx_ext_item__testimonials_contents_start( $widget_options ) {
				?><div class="testimonial-contents ta-center clearfix"><?php
			}
		}

		// Contents end
		if( ! function_exists( 'bx_ext_item__testimonials_contents_end' ) ) {
			function bx_ext_item__testimonials_contents_end( $widget_options) {
				?></div><?php
			}
		}

		// Title
		if( ! function_exists( 'bx_ext_item__testimonials_contents_title' ) ) {
			function bx_ext_item__testimonials_contents_title( $widget_options ) {
				$title  = $widget_options['title'];
				$format = '<h3 class="hs-secondary-small">%s</h3>';

				$output = sprintf( $format, esc_html( $title ) );
				$output = apply_filters( 'bx_ext_item___testimonials_contents_title', $output, $format, $widget_options );

				echo $output;
			}
		}

		// Testimonial
		if( ! function_exists( 'bx_ext_item__testimonials_contents_testimonial' ) ) {
			function bx_ext_item__testimonials_contents_testimonial( $widget_options ) {
				$testimonial  = $widget_options['testimonial'];
				$format       = '<p class="testimonial-excerpt">%s</p>';

				$output = sprintf( $format, esc_html( $testimonial ) );
				$output = apply_filters( 'bx_ext_item___testimonials_contents_testimonial', $output, $format, $widget_options );

				echo $output;
			}
		}

		// Testimonial
		if( ! function_exists( 'bx_ext_item__testimonials_contents_button' ) ) {
			function bx_ext_item__testimonials_contents_button( $widget_options ) {
				$target = $widget_options['target'];
				$url    = $widget_options['btn_url'];
				$text   = $widget_options['btn_text'];
				$format = '<a target="%1$s" href="%2$s" class="ac-btn btn-small fw-regular">%3$s</a>';
				$before = '<div class="testimonial-button">';
				$after  = '</div>';

				$output = $before . sprintf( $format, esc_attr( $target ), esc_url( $url ), esc_html( $text ) ) . $after;
				$output = apply_filters( 'bx_ext_item___testimonials_contents_button', $output, $format, $before, $after, $widget_options );

				echo $output;
			}
		}
