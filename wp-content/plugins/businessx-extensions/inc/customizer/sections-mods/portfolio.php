<?php
/* ------------------------------------------------------------------------- *
 *  ______
 *
 *  Portfolio Section
 *  ________________
 *
 *	Settings and controls options
 *	_____________________________
 *
 *	All the "businessx_controller_*" are located in the theme:
 *	../acosmin/customizer/customizer.php
 *
 *	They use $wp_customize->add_setting and $wp_customize->add_control to
 *	add settings and controls, all sanitized.
 *
/* ------------------------------------------------------------------------- */



	/*  Add section
	/* ------------------------------------ */
	$wp_customize->add_section( new BXEXT_Section_FrontPage( $wp_customize, 'businessx_section__portfolio', array(
		'title'				=> esc_html__( 'Portfolio Section', 'businessx-extensions' ),
		'panel'				=> 'businessx_panel__sections',
		'priority'			=> absint( businessx_extensions_sec_prio( 'businessx_section__portfolio' ) ),
	) ) );



		/*  Portfolio Section options
		/* ------------------------------------ */

		// Hide section
		businessx_controller_checkbox(
			'portfolio_section_hide',
			'businessx_section__portfolio',
			esc_html__( 'Hide this section', 'businessx-extensions' ) );
		/*=====*/

		// Section title
		businessx_controller_txt(
			'portfolio_section_title',
			'businessx_section__portfolio',
			esc_html__( 'Section title', 'businessx-extensions' ),
			esc_html__( 'Set a title for this section.', 'businessx-extensions' ),
			esc_html__( 'Portfolio Heading', 'businessx-extensions' ),
			'.sec-portfolio .section-title' );
		/*=====*/

		// Section description
		businessx_controller_txt_area(
			'portfolio_section_description',
			'businessx_section__portfolio',
			esc_html__( 'Section description', 'businessx-extensions' ),
			esc_html__( 'Set a description for this section.', 'businessx-extensions' ),
			esc_html__( 'This is a description for the Portfolio section. You can set it up in the Customizer where you can also change some options.', 'businessx-extensions' ),
			'.sec-portfolio .section-description', true, 'businessx_ext_sanitize_content_filtered' );
		/*=====*/

		// Number of posts
		businessx_controller_txt(
			'portfolio_section_nr_posts',
			'businessx_section__portfolio',
			esc_html__( 'Number of posts', 'businessx-extensions' ),
			esc_html__( 'How many items should we display. Integers only.', 'businessx-extensions' ),
			4,
			'', false, false, 'absint' );
		/*=====*/

		// Show action button
		bx_ext_controller_simple( array(
			'type' => 'checkbox',
			'setting_id' => 'portfolio_action_btn_show',
			'section_id' => 'businessx_section__portfolio',
			'label' => esc_html__( 'Show "More Projects" button?', 'businessx-extensions' ),
			'default' => false,
			'transport' => false,
		) );

		// Action button
		bx_ext_controller_simple( array(
			'setting_id' => 'portfolio_action_btn',
			'section_id' => 'businessx_section__portfolio',
			'label' => esc_html__( 'More Projects label:', 'businessx-extensions' ),
			'default' => esc_html__( 'View More Projects', 'businessx-extensions' ),
			'sanitize' => 'sanitize_text_field',
			'selector' => '.portfolio-action-btn',
			'escape'   => 'esc_html',
		) );

		// Action button url
		bx_ext_controller_simple( array(
			'setting_id' => 'portfolio_action_btn_url',
			'section_id' => 'businessx_section__portfolio',
			'label' => esc_html__( 'More projects URL:', 'businessx-extensions' ),
			'default' => '#',
			'sanitize' => 'esc_url_raw',
			'postmsg' => true,
		) );
		/*=====*/

		// Section tabs
		$wp_customize->add_setting( 'portfolio-sectiontabs', array() );

		$wp_customize->add_control( new BXEXT_Control_Tabs( $wp_customize, 'portfolio-sectiontabs', array(
			'section'          => 'businessx_section__portfolio',
			'type'             => 'section-tabs',
			'title_colors'     => __( 'Colors', 'businessx-extensions' ),
			'title_background' => __( 'Background', 'businessx-extensions' )
		) ) );

		// Section colors
		businessx_controller_color_picker(
			'portfolio_color_background',
			'businessx_section__portfolio',
			esc_html__( 'Section background color:', 'businessx-extensions' ),
			esc_html__( 'In case you do not have a background image', 'businessx-extensions' ),
			'#f7f7f7' );
		/*=====*/

		businessx_controller_color_picker(
			'portfolio_color_heading_link',
			'businessx_section__portfolio',
			esc_html__( 'Headings and links colors:', 'businessx-extensions' ),
			'', '#232323' );
		/*=====*/

		businessx_controller_color_picker(
			'portfolio_color_heading_border',
			'businessx_section__portfolio',
			esc_html__( 'Section heading border color:', 'businessx-extensions' ),
			'', '#59c7f4' );
		/*=====*/

		businessx_controller_color_picker(
			'portfolio_color_text',
			'businessx_section__portfolio',
			esc_html__( 'Text color:', 'businessx-extensions' ),
			'', '#636363' );
		/*=====*/

		businessx_controller_color_picker(
			'portfolio_color_hover',
			'businessx_section__portfolio',
			esc_html__( 'Hover color:', 'businessx-extensions' ),
			'',
			'#232323' );
		/*=====*/

		businessx_controller_rgba_picker(
			'portfolio_color_thumb_hover',
			'businessx_section__portfolio',
			esc_html__( 'Thumbnail hover state:', 'businessx-extensions' ),
			'', 'rgba(37,146,202,0.8)', true, false );
		/*=====*/

		businessx_controller_color_picker(
			'portfolio_color_thumb_background',
			'businessx_section__portfolio',
			esc_html__( 'Thumbnail background:', 'businessx-extensions' ),
			'',
			'#e3e3e3' );
		/*=====*/

		businessx_controller_color_picker(
			'portfolio_color_thumb_color',
			'businessx_section__portfolio',
			esc_html__( 'Thumbnail text color:', 'businessx-extensions' ),
			'', '#ffffff' );
		/*=====*/

		// Background image
		businessx_controller_bg_image( 'portfolio_bg_image', 'businessx_section__portfolio', esc_html__( 'Background Image:', 'businessx-extensions' ), '', esc_html__( 'Use a HD image, suggested size: 1920x1080px', 'businessx-extensions' ) );
		/*=====*/

		// Background overlay
		businessx_controller_bg_overlay( 'portfolio_bg_overlay', 'businessx_section__portfolio', esc_html__( 'Show Background Overlay', 'businessx-extensions' ) );
		/*=====*/

		// Backgroud parallax
		businessx_controller_bg_parallax( 'portfolio_bg_parallax', 'businessx_section__portfolio', esc_html__( 'Enable Parallax Effect', 'businessx-extensions' ) );
		businessx_controller_simple_image(
			'portfolio_bg_parallax_img',
			'businessx_section__portfolio',
			esc_html__( 'Parallax Background Image', 'businessx-extensions' ),
			esc_html__( 'Use a HD image, suggested size: 1920x1080px', 'businessx-extensions' ), '', false
		);
		/*=====*/
