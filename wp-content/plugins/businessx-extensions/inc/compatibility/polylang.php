<?php
/**
 * Plugin compatibility with Polylang
 *
 * @see   https://polylang.pro/doc/function-reference/
 * @since 1.0.4.3
 */

if( ! function_exists( 'bxext_compt_polylang_check' ) ) {
	/**
	 * Check if Polylang is activated
	 *
	 * @since  1.0.4.3
	 * @return boolean True if it is, false if it isn't
	 */
	function bxext_compt_polylang_check() {
		return ( class_exists( 'Polylang' ) ) ? true : false;
	}
}

/**
 * Create other functions
 */
if( bxext_compt_polylang_check() ) {

	if( ! function_exists( 'bxext_compt_polylang_register' ) ) {
		/**
		 * Register Polylang strings and group theme
		 *
		 * @since  1.0.4.3
		 * @return void
		 */
		function bxext_compt_polylang_register() {
			// Do nothing if we don't have what we need
			if( ! function_exists( 'pll_register_string' ) ) return;

			// Features Section
			pll_register_string( 'Businessx Extensions', 'Features Heading', 'Features Section' );
			pll_register_string( 'Businessx Extensions', 'This is a description for the Features section. You can set it up in the Customizer where you can also add items for it.', 'Features Section', true );

			// About section
			pll_register_string( 'Businessx Extensions', 'About Us Heading', 'About Section' );
			pll_register_string( 'Businessx Extensions', 'This is a description for the About section. You can set it up in the Customizer > Front Page Sections > About Section.', 'About Section', true );
			pll_register_string( 'Businessx Extensions', 'Button Anchor Text', 'About Section' );

			// Team section
			pll_register_string( 'Businessx Extensions', 'Team Heading', 'Team Section' );
			pll_register_string( 'Businessx Extensions', 'This is a description for the Team section. You can set it up in the Customizer where you can also add items for it.', 'Team Section', true );

			// Clients section
			pll_register_string( 'Businessx Extensions', 'Clients Heading', 'Clients Section' );
			pll_register_string( 'Businessx Extensions', 'This is a description for the Clients section. You can set it up in the Customizer where you can also add items for it.', 'Clients Section', true );

			// Pricing section
			pll_register_string( 'Businessx Extensions', 'Pricing Heading', 'Pricing Section' );
			pll_register_string( 'Businessx Extensions', 'This is a description for the Pricing section. You can set it up in the Customizer where you can also add items for it.', 'Pricing Section', true );

			// Portfolio section
			pll_register_string( 'Businessx Extensions', 'Portfolio Heading', 'Portfolio Section' );
			pll_register_string( 'Businessx Extensions', 'This is a description for the Portfolio section. You can set it up in the Customizer where you can also change some options.', 'Portfolio Section', true );

			// Testimonials section
			pll_register_string( 'Businessx Extensions', 'Testimonials', 'Testimonials Section' );

			// FAQ section
			pll_register_string( 'Businessx Extensions', 'Frequently Asked Questions', 'FAQ Section' );
			pll_register_string( 'Businessx Extensions', 'This is a description for the FAQ section. You can set it up in the Customizer where you can also add items for it.', 'FAQ Section', true );

			// Hero section
			pll_register_string( 'Businessx Extensions', 'Hero section title goes here.', 'Hero Section' );
			pll_register_string( 'Businessx Extensions', 'You can edit this section by going to Customizer > Sections > Hero Section', 'Hero Section', true );
			pll_register_string( 'Businessx Extensions', 'Call to Action #1', 'Hero Section' );
			pll_register_string( 'Businessx Extensions', 'Call to Action #2', 'Hero Section' );
			pll_register_string( 'Businessx Extensions', 'Or', 'Hero Section' );

			// Blog section
			pll_register_string( 'Businessx Extensions', 'Blog Heading', 'Blog Section' );
			pll_register_string( 'Businessx Extensions', 'This is a description for the Blog section. You can set it up in the Customizer where you can also add items for it.', 'Blog Section', true );
			pll_register_string( 'Businessx Extensions', 'View More Articles', 'Blog Section' );

			// Contact section
			pll_register_string( 'Businessx Extensions', 'Contact Us', 'Contact Section' );
			pll_register_string( 'Businessx Extensions', 'This is a description for the Contact section. You can set it up in the Customizer where you can also add items for it.', 'Contact Section', true );
			pll_register_string( 'Businessx Extensions', 'Your contact form shortcode appears here...', 'Contact Section', true );

			// Maps section
			pll_register_string( 'Businessx Extensions', 'Maps Section Title', 'Maps Section' );
		}
	}

	/**
	 * Actions
	 */
	add_action( 'init', 'bxext_compt_polylang_register', 999 );

} /* END - bxext_compt_polylang_check() */
