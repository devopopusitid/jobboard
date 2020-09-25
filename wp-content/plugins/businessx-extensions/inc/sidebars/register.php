<?php
/* ------------------------------------------------------------------------- *
 *
 *  Sidebars
 *  ________________
 *
 *	This file registers sidebars some sidebars for the theme and sections
 *
/* ------------------------------------------------------------------------- */



/*  Widgets and Sidebars Setup
/* ------------------------------------ */
if ( ! function_exists( 'businessx_extensions_sidebars_and_widgets' ) ) {
	function businessx_extensions_sidebars_and_widgets() {

		// Sections sidebars
		register_sidebar( array( // Features Section
			'name'          => __( 'Features Section', 'businessx-extensions' ),
			'id'            => 'section-features',
			'description'   => __( 'Features or Services section', 'businessx-extensions' ),
			'before_widget' => '<div id="%1$s" class="sec-item %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '',
			'after_title'   => '',
		) );

		register_sidebar( array( // FAQ Section
			'name'          => __( 'FAQ Section', 'businessx-extensions' ),
			'id'            => 'section-faq',
			'description'   => __( 'Frequently Asked Questions section', 'businessx-extensions' ),
			'before_widget' => '<div id="%1$s" class="sec-item %2$s">',
			'after_widget'  => '</div><!-- END .sec-faq-question .widget -->',
			'before_title'  => '',
			'after_title'   => '',
		) );

		register_sidebar( array( // Clients Section
			'name'          => __( 'Clients Section', 'businessx-extensions' ),
			'id'            => 'section-clients',
			'description'   => __( 'Clients section', 'businessx-extensions' ),
			'before_widget' => '<div id="%1$s" class="sec-item %2$s"><figure class="sec-client-logo">',
			'after_widget'  => '</figure></div><!-- END .sec-clients .widget -->',
			'before_title'  => '',
			'after_title'   => '',
		) );

		register_sidebar( array( // Actions Section
			'name'          => __( 'Actions Section', 'businessx-extensions' ),
			'id'            => 'section-actions',
			'description'   => __( 'Actions section', 'businessx-extensions' ),
			'before_widget' => '<section id="%1$s" class="sec-item %2$s">',
			'after_widget'  => '</section><!-- END .sec-action .widget -->',
			'before_title'  => '',
			'after_title'   => '',
		) );

		register_sidebar( array( // About us
			'name'          => __( 'About Us Section', 'businessx-extensions' ),
			'id'            => 'section-about',
			'description'   => __( 'About Us section', 'businessx-extensions' ),
			'before_widget' => '<div id="%1$s" class="sec-item %2$s">',
			'after_widget'  => '</div><!-- END .sec-about .widget -->',
			'before_title'  => '',
			'after_title'   => '',
		) );

		register_sidebar( array( // Testimonials
			'name'          => __( 'Testimonials Section', 'businessx-extensions' ),
			'id'            => 'section-testimonials',
			'description'   => __( 'Testimonials section', 'businessx-extensions' ),
			'before_widget' => '<div id="%1$s" class="sec-item %2$s">',
			'after_widget'  => '</div><!-- END .sec-testimonials .widget -->',
			'before_title'  => '',
			'after_title'   => '',
		) );

		register_sidebar( array( // Team Section
			'name'          => __( 'Team Section', 'businessx-extensions' ),
			'id'            => 'section-team',
			'description'   => __( 'Team section', 'businessx-extensions' ),
			'before_widget' => '<div id="%1$s" class="sec-item %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '',
			'after_title'   => '',
		) );

		register_sidebar( array( // Pricing Section
			'name'          => __( 'Pricing Section', 'businessx-extensions' ),
			'id'            => 'section-pricing',
			'description'   => __( 'Pricing section', 'businessx-extensions' ),
			'before_widget' => '<div id="%1$s" class="sec-item %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '',
			'after_title'   => '',
		) );

		register_sidebar( array( // Slider Section
			'name'          => __( 'Slider Section', 'businessx-extensions' ),
			'id'            => 'section-slider',
			'description'   => __( 'Slider section', 'businessx-extensions' ),
			'before_widget' => '<div id="%1$s" class="sec-item %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '',
			'after_title'   => '',
		) );

	}
}
add_action( 'widgets_init', 'businessx_extensions_sidebars_and_widgets', 30 );
