<?php
/* ------------------------------------------------------------------------- *
 *  ______
 *
 *  About Us Section
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
	$wp_customize->add_section( new BXEXT_Section_FrontPage( $wp_customize, 'businessx_section__about', array(
		'title'				=>  esc_html__( 'About Us Section', 'businessx-extensions' ),
		'panel'				=> 'businessx_panel__sections',
		'priority'			=> absint( businessx_extensions_sec_prio( 'businessx_section__about' ) ),
	) ) );



		/*  About Us Section options
		/* ------------------------------------ */
		$wp_customize->add_setting( 'about-addedititems', array() );

		$wp_customize->add_control( new BXEXT_Control_AddEditItems( $wp_customize, 'about-addedititems', array(
			'section'      => 'businessx_section__about',
			'type'         => 'add-edit-items',
			'section_type' => 'about',
			'item_type'    => __( 'Add or edit about boxes', 'businessx-extensions' )
		) ) );

		// Hide section
		businessx_controller_checkbox(
			'about_section_hide',
			'businessx_section__about',
			esc_html__( 'Hide this section', 'businessx-extensions' ) );
		/*=====*/

		// Section title
		businessx_controller_txt(
			'about_section_title',
			'businessx_section__about',
			esc_html__( 'Section title', 'businessx-extensions' ),
			esc_html__( 'Set a title for this section.', 'businessx-extensions' ),
			esc_html__( 'About Us Heading', 'businessx-extensions' ),
			'.sec-about .section-title' );
		/*=====*/

		// Section description
		businessx_controller_txt_area(
			'about_section_description',
			'businessx_section__about',
			esc_html__( 'Section description', 'businessx-extensions' ),
			esc_html__( 'Set a description for this section.', 'businessx-extensions' ),
			esc_html__( 'This is a description for the About Us section. You can set it up in the Customizer where you can also add items for it.', 'businessx-extensions' ),
			'.sec-about .section-description', true, 'businessx_ext_sanitize_content_filtered' );
		/*=====*/

		// Section button anchor
		businessx_controller_txt(
			'about_section_btn_anchor',
			'businessx_section__about',
			esc_html__( 'Button Anchor Text', 'businessx-extensions' ),
			'', esc_html__( 'More Info About Us', 'businessx-extensions' ),
			'.sec-about .about-button .ac-btn' );
		/*=====*/

		// Section button anchor
		businessx_controller_txt(
			'about_section_btn_anchor_url',
			'businessx_section__about',
			esc_html__( 'Button Link', 'businessx-extensions' ),
			'', '#', '', true, false );
		/*=====*/

		//  Button Target
		businessx_controller_checkbox(
			'about_section_btn_target',
			'businessx_section__about',
			esc_html__( 'Open link in a new window', 'businessx-extensions' ), '', false, true );
		/*=====*/

		// Hide section button
		businessx_controller_checkbox(
			'about_section_hide_btn',
			'businessx_section__about',
			esc_html__( 'Hide this button', 'businessx-extensions' ) );
		/*=====*/

		// Section tabs
		$wp_customize->add_setting( 'about-sectiontabs', array() );

		$wp_customize->add_control( new BXEXT_Control_Tabs( $wp_customize, 'about-sectiontabs', array(
			'section'          => 'businessx_section__about',
			'type'             => 'section-tabs',
			'title_colors'     => __( 'Colors', 'businessx-extensions' ),
			'title_background' => __( 'Background', 'businessx-extensions' )
		) ) );

		// Section colors
		businessx_controller_color_picker(
			'about_color_background',
			'businessx_section__about',
			esc_html__( 'Section background color:', 'businessx-extensions' ),
			esc_html__( 'In case you do not have a background image', 'businessx-extensions' ),
			'#2f2f2f' );
		/*=====*/

		businessx_controller_color_picker(
			'about_color_heading_link',
			'businessx_section__about',
			esc_html__( 'Headings and links colors:', 'businessx-extensions' ),
			'', '#ffffff' );
		/*=====*/

		businessx_controller_color_picker(
			'about_color_heading_border',
			'businessx_section__about',
			esc_html__( 'Borders color:', 'businessx-extensions' ),
			esc_html__( 'Applies to the Section Heading and boxes', 'businessx-extensions' ),
			'#e51638' );
		/*=====*/

		businessx_controller_color_picker(
			'about_color_text',
			'businessx_section__about',
			esc_html__( 'Text color:', 'businessx-extensions' ),
			'', '#bbbbbb' );
		/*=====*/

		businessx_controller_rgba_picker(
			'about_color_btn',
			'businessx_section__about',
			esc_html__( 'Button background color:', 'businessx-extensions' ),
			'', 'rgba(229,22,56,0.5)', true, false );
		/*=====*/

		businessx_controller_color_picker(
			'about_color_btn_2nd',
			'businessx_section__about',
			esc_html__( 'Button 2nd background color:', 'businessx-extensions' ),
			esc_html__( 'This applies to the border and hover state', 'businessx-extensions' ),
			'#e51638' );
		/*=====*/

		// Background image
		businessx_controller_bg_image( 'about_bg_image', 'businessx_section__about', esc_html__( 'Background Image:', 'businessx-extensions' ), '', esc_html__( 'Use a HD image, suggested size: 1920x1080px', 'businessx-extensions' ) );
		/*=====*/

		// Background overlay
		businessx_controller_bg_overlay( 'about_bg_overlay', 'businessx_section__about', esc_html__( 'Show Background Overlay', 'businessx-extensions' ) );
		/*=====*/

		// Backgroud parallax
		businessx_controller_bg_parallax( 'about_bg_parallax', 'businessx_section__about', esc_html__( 'Enable Parallax Effect', 'businessx-extensions' ) );
		businessx_controller_simple_image(
			'about_bg_parallax_img',
			'businessx_section__about',
			esc_html__( 'Parallax Background Image', 'businessx-extensions' ),
			esc_html__( 'Use a HD image, suggested size: 1920x1080px', 'businessx-extensions' ), '', false
		);
		/*=====*/
