<?php
/* ------------------------------------------------------------------------- *
 *  ______
 *
 *  Frequently Asked Questions
 *  ________________
 *
 *	Panel, settings and controls options
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
	$wp_customize->add_section( new BXEXT_Section_FrontPage( $wp_customize, 'businessx_section__faq', array(
		'title'				=> esc_html__( 'FAQ Section', 'businessx-extensions' ),
		'panel'				=> 'businessx_panel__sections',
		'priority'			=> absint( businessx_extensions_sec_prio( 'businessx_section__faq' ) ),
	) ) );



		/*  FAQ Section options
		/* ------------------------------------ */
		$wp_customize->add_setting( 'faq-addedititems', array() );

		$wp_customize->add_control( new BXEXT_Control_AddEditItems( $wp_customize, 'faq-addedititems', array(
			'section'      => 'businessx_section__faq',
			'type'         => 'add-edit-items',
			'section_type' => 'faq',
			'item_type'    => __( 'Add or edit questions', 'businessx-extensions' )
		) ) );

		// Hide section
		businessx_controller_checkbox(
			'faq_section_hide',
			'businessx_section__faq',
			esc_html__( 'Hide this section', 'businessx-extensions' ) );
		/*=====*/

		// Section title
		businessx_controller_txt(
			'faq_section_title',
			'businessx_section__faq',
			esc_html__( 'Section title', 'businessx-extensions' ),
			esc_html__( 'Set a title for this section.', 'businessx-extensions' ),
			esc_html__( 'Frequently Asked Questions', 'businessx-extensions' ),
			'.sec-faq .section-title' );
		/*=====*/

		// Section description
		businessx_controller_txt_area(
			'faq_section_description',
			'businessx_section__faq',
			esc_html__( 'Section description', 'businessx-extensions' ),
			esc_html__( 'Set a description for this section.', 'businessx-extensions' ),
			esc_html__( 'This is a description for the FAQ section. You can set it up in the Customizer where you can also add items for it.', 'businessx-extensions' ),
			'.sec-faq .section-description', true, 'businessx_ext_sanitize_content_filtered' );
		/*=====*/

		// Section tabs
		$wp_customize->add_setting( 'faq-sectiontabs', array() );

		$wp_customize->add_control( new BXEXT_Control_Tabs( $wp_customize, 'faq-sectiontabs', array(
			'section'          => 'businessx_section__faq',
			'type'             => 'section-tabs',
			'title_colors'     => __( 'Colors', 'businessx-extensions' ),
			'title_background' => __( 'Background', 'businessx-extensions' )
		) ) );

		// Section colors
		businessx_controller_color_picker(
			'faq_color_background',
			'businessx_section__faq',
			esc_html__( 'Section background color:', 'businessx-extensions' ),
			esc_html__( 'In case you do not have a background image', 'businessx-extensions' ),
			'#f2f2f2' );
		/*=====*/

		businessx_controller_color_picker(
			'faq_color_headings',
			'businessx_section__faq',
			esc_html__( 'Headings color:', 'businessx-extensions' ),
			'', '#232323' );
		/*=====*/

		businessx_controller_color_picker(
			'faq_color_heading_border',
			'businessx_section__faq',
			esc_html__( 'Section heading border color:', 'businessx-extensions' ),
			'', '#a252f5' );
		/*=====*/

		businessx_controller_color_picker(
			'faq_color_heading_small_border',
			'businessx_section__faq',
			esc_html__( 'Smaller headings border color:', 'businessx-extensions' ),
			'', '#d7d7d7' );
		/*=====*/

		businessx_controller_color_picker(
			'faq_color_text',
			'businessx_section__faq',
			esc_html__( 'Text color:', 'businessx-extensions' ),
			'', '#636363' );
		/*=====*/

		businessx_controller_color_picker(
			'faq_color_link',
			'businessx_section__faq',
			esc_html__( 'Links color:', 'businessx-extensions' ),
			'',
			'#a252f5' );
		/*=====*/

		businessx_controller_color_picker(
			'faq_color_hover',
			'businessx_section__faq',
			esc_html__( 'Hover color:', 'businessx-extensions' ),
			'',
			'#232323' );
		/*=====*/

		// Background image
		businessx_controller_bg_image( 'faq_bg_image', 'businessx_section__faq', esc_html__( 'Background Image:', 'businessx-extensions' ), '', esc_html__( 'Use a HD image, suggested size: 1920x1080px', 'businessx-extensions' ) );
		/*=====*/

		// Background overlay
		businessx_controller_bg_overlay( 'faq_bg_overlay', 'businessx_section__faq', esc_html__( 'Show Background Overlay', 'businessx-extensions' ) );
		/*=====*/

		// Backgroud parallax
		businessx_controller_bg_parallax( 'faq_bg_parallax', 'businessx_section__faq', esc_html__( 'Enable Parallax Effect', 'businessx-extensions' ) );
		businessx_controller_simple_image(
			'faq_bg_parallax_img',
			'businessx_section__faq',
			esc_html__( 'Parallax Background Image', 'businessx-extensions' ),
			esc_html__( 'Use a HD image, suggested size: 1920x1080px. If you have a lot of "questions", it is not recommended to use this option.', 'businessx-extensions' ), '', false
		);
		/*=====*/
