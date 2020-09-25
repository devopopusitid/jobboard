<?php
/**
 * ----------
 * Shortcodes
 * ----------
 */

/**
 * SECTION - Contact
 */

// Social button
if( ! function_exists( 'businessx_ext_sc_contact_social_btn' ) ) {
	/**
	 * Social button shortcode
	 *
	 * @since  1.0.4.3
	 * @param  array   $atts Shortcode attributes
	 * @return string        Button HTML
	 */
	function businessx_ext_sc_contact_social_btn( $atts ) {
		$args = shortcode_atts( array(
			'icon'  => 'link',
			'class' => 'sec-contact-social-btn',
			'link'  => '#',
		), $atts );

		$format = '<a target="_blank" href="%1$s" class="%2$s">%3$s</a>';
		$output = sprintf( $format, esc_url( $args[ 'link' ] ), esc_attr( $args[ 'class' ] ), businessx_icon( $args[ 'icon' ], false ) );
		$output = apply_filters( 'businessx_ext_sc_contact_social_btn___output', $output, $format, $args );

	    return $output;
	}
}
add_shortcode( 'bx_contact_social', 'businessx_ext_sc_contact_social_btn' );

// Phone number
if( ! function_exists( 'businessx_ext_sc_contact_phone_btn' ) ) {
	/**
	 * Phone number shortcode
	 *
	 * @since  1.0.4.3
	 * @param  array   $atts Shortcode attributes
	 * @return string        Button HTML
	 */
	function businessx_ext_sc_contact_phone_btn( $atts ) {
		$args = shortcode_atts( array(
			'icon'   => 'phone',
			'class'  => 'sec-contact-social-btn scsb-with-span',
			'number' => '#',
			'text'   => ''
		), $atts );

		$text   = ( $args[ 'text' ] !== '' ) ? ' ' . $args[ 'text' ] : '';
		$format = '<a target="_blank" href="%1$s" class="%2$s">%3$s%4$s</a>';

		$output = sprintf(
			$format,
			esc_url( $args[ 'number' ] ),
			esc_attr( $args[ 'class' ] ),
			businessx_icon( $args[ 'icon' ], false ),
			esc_html( $text )
		);
		$output = apply_filters( 'businessx_ext_sc_contact_phone_btn___output', $output, $format, $args, $text );

		return $output;
	}
}
add_shortcode( 'bx_contact_phone', 'businessx_ext_sc_contact_phone_btn' );

// Get section
if( ! function_exists( 'businessx_ext_sc_get_section' ) ) {
	/**
	 * Returns a section
	 *
	 * @since  1.0.4.3
	 * @param  array $atts Shortcode attributes
	 * @return mixed       Returns a section template with all its items
	 */
	function businessx_ext_sc_get_section( $atts ) {
		/* Args */
		$args = shortcode_atts( array(
			'name'  => ''
		), $atts );

		$section = sanitize_key( $args[ 'name' ] );

		/* If we can't get the template part, do nothing */
		if( ! function_exists( 'businessx_extensions_get_template_part' ) ) return;

		/* Get a list of all the sections */
		$sections = (array) businessx_extensions_sections();

		/* If the section doesn't exist, do nothing */
		if( ! in_array( $section, $sections ) ) return;

		/* Display the template part even if it's set to hidden in the Customizer */
		set_query_var( $section . '_sec__shortcode', 1 );

		/* Get the template part if it exists */
		businessx_extensions_get_template_part( 'sections/section', $section );
	}
}
add_shortcode( 'bx_section', 'businessx_ext_sc_get_section' );
