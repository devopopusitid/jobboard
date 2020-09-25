<?php
/**
 * A few backup functions in case Businessx isn't activated
 */

// Checkbox
if ( ! function_exists( 'businessx_sanitize_checkbox' ) ) {
	function businessx_sanitize_checkbox( $input ) {
		if ( $input == 1 ) { return 1; } else { return 0; }
	}
}

// Select
// for Customizer select options
// and non Customizer options
if ( ! function_exists( 'businessx_sanitize_select' ) ) {
	function businessx_sanitize_select( $input, $setting, $new_default = '', $incustomizer = true ) {
		global $wp_customize;

		if( $incustomizer ) {
			$control = $wp_customize->get_control( $setting->id );

			if ( array_key_exists( $input, $control->choices ) ) {
				return $input;
			} else {
				return $setting->default;
			}
		} else {
			$choices = (array) $setting;

			if ( in_array( $input, $choices, true ) ) {
				return $input;
			} else {
				return $new_default;
			}
		}
	}
}

// Sanitize HEX color
// if we can't use sanitize_hex_color()
if ( ! function_exists( 'businessx_sanitize_hex' ) ) {
	function businessx_sanitize_hex( $color ) {
		if ( '' === $color )
			return '';

		// 3 or 6 hex digits, or the empty string.
		if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
			return $color;
	}
}

// Sanitize RGBA color
if ( ! function_exists( 'businessx_sanitize_rgba' ) ) {
	function businessx_sanitize_rgba( $color ) {
		// If empty or an array return transparent
		if ( empty( $color ) || is_array( $color ) ) {
			return 'rgba(0,0,0,0)';
		}
		// If string does not start with 'rgba', then treat as hex
		// sanitize the hex color and finally convert hex to rgba
		if ( false === strpos( $color, 'rgba' ) ) {
			return businessx_sanitize_hex( $color );
		} else {
			// By now we know the string is formatted as an rgba color so we need to further sanitize it.
			$color = str_replace( ' ', '', $color );
			sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
			return 'rgba('.$red.','.$green.','.$blue.','.$alpha.')';
		}
	}
}

//  Sanitize CSS output
if ( ! function_exists( 'businessx_sanitize_css' ) ) {
	function businessx_sanitize_css( $custom_css, $format = TRUE ) {
		if ( '' === $custom_css )
			return '';

		if( $format ) {
			return preg_replace('/\s\s+/', ' ', wp_strip_all_tags( $custom_css ) ); }
		else {
			return esc_html( $custom_css ); }
	}
}

// Output content and filter HTML
if ( ! function_exists( 'businessx_content_filter' ) ) {
	function businessx_content_filter( $content = '', $allowed_tags = array(), $echo = FALSE ) {
		if( $echo ) {
			echo wp_kses( $content, $allowed_tags ); }
		else {
			return wp_kses( $content, $allowed_tags ); }
	}
}

// Sanitize an array with a sanitization function
if ( ! function_exists( 'businessx_sanitize_array_map' ) ) {
	function businessx_sanitize_array_map( $sanitize_function, $the_array ) {
		$newArr = array();

		foreach( $the_array as $key => $value ) :
			$newArr[ $key ] = ( is_array( $value ) ? businessx_sanitize_array_map( $sanitize_function, $value ) :
				( is_array( $sanitize_function ) ? call_user_func_array( $sanitize_function, $value ) :
					$sanitize_function( $value ) ) );
		endforeach;

		return $newArr;
	}
}

// Enqueue backup style
if ( ! function_exists( 'businessx_extensions_enqueue_backup' ) ) {
	function businessx_extensions_enqueue_backup() {
		global $wp_customize;
		$current_screen = get_current_screen();

		if( $current_screen->id === "widgets" || isset( $wp_customize ) ) :
			wp_enqueue_style( 'businessx-extensions-widgets-customizer', BUSINESSX_EXTS_URL . 'css/widgets-customizer.css', array(), '20160412', 'all' );
			wp_enqueue_script(
				'businessx-extensions-widgets-customizer',
				BUSINESSX_EXTS_URL . 'js/admin/widgets-customizer.js',
				array( 'jquery', 'jquery-ui-sortable', 'jquery-ui-autocomplete', 'wp-color-picker' ),
				'20160412', FALSE
			);
		endif;
	}
}

/*  Opacity options
/*  Used by Businessx Extensions
/* ------------------------------------ */
if ( ! function_exists( 'businessx_opacity_options' ) ) {
	function businessx_opacity_options( $multi = false, $simple = false ) {
		$options = array();

		if( ! $simple ) {
			if( $multi ) {
				$options = apply_filters( 'businessx_opacity_options___select_multi', $options = array(
					array(
						'value' 	=> "0",
						'title'		=> esc_html_x( 'Transparent', 'background opacity option', 'businessx' ),
						'disabled'	=> false
					),
					array(
						'value' 	=> '0.1',
						'title'		=> esc_html_x( '10%', 'background opacity option', 'businessx' ),
						'disabled'	=> false
					),
					array(
						'value' 	=> '0.2',
						'title'		=> esc_html_x( '20%', 'background opacity option', 'businessx' ),
						'disabled'	=> false
					),
					array(
						'value' 	=> '0.3',
						'title'		=> esc_html_x( '30%', 'background opacity option', 'businessx' ),
						'disabled'	=> false
					),
					array(
						'value' 	=> '0.4',
						'title'		=> esc_html_x( '40%', 'background opacity option', 'businessx' ),
						'disabled'	=> false
					),
					array(
						'value' 	=> '0.5',
						'title'		=> esc_html_x( '50%', 'background opacity option', 'businessx' ),
						'disabled'	=> false
					),
					array(
						'value' 	=> '0.6',
						'title'		=> esc_html_x( '60%', 'background opacity option', 'businessx' ),
						'disabled'	=> false
					),
					array(
						'value' 	=> '0.7',
						'title'		=> esc_html_x( '70%', 'background opacity option', 'businessx' ),
						'disabled'	=> false
					),
					array(
						'value' 	=> '0.8',
						'title'		=> esc_html_x( '80%', 'background opacity option', 'businessx' ),
						'disabled'	=> false
					),
					array(
						'value' 	=> '0.9',
						'title'		=> esc_html_x( '90%', 'background opacity option', 'businessx' ),
						'disabled'	=> false
					),
					array(
						'value' 	=> "1",
						'title'		=> esc_html_x( '100%', 'background opacity option', 'businessx' ),
						'disabled'	=> false
					),
				) );
			} else {
				$options = apply_filters( 'businessx_opacity_options___select', $options = array(
					'.0'		=> esc_html_x( 'Transparent', 'background opacity option', 'businessx' ),
					'0.1'		=> esc_html_x( '10%', 'background opacity option', 'businessx' ),
					'0.2'		=> esc_html_x( '20%', 'background opacity option', 'businessx' ),
					'0.3'		=> esc_html_x( '30%', 'background opacity option', 'businessx' ),
					'0.4'		=> esc_html_x( '40%', 'background opacity option', 'businessx' ),
					'0.5'		=> esc_html_x( '50%', 'background opacity option', 'businessx' ),
					'0.6'		=> esc_html_x( '60%', 'background opacity option', 'businessx' ),
					'0.7'		=> esc_html_x( '70%', 'background opacity option', 'businessx' ),
					'0.8'		=> esc_html_x( '80%', 'background opacity option', 'businessx' ),
					'0.9'		=> esc_html_x( '90%', 'background opacity option', 'businessx' ),
					'1'			=> esc_html_x( '100%', 'background opacity option', 'businessx' ),
				) );
			}
		} else {
			$options = apply_filters( 'businessx_opacity_options___select_simple', array( "0", '0.1', '0.2', '0.3', '0.4', '0.5', '0.6', '0.7', '0.8', '0.9', "1" ) );
		}

		return $options;
	}
}
