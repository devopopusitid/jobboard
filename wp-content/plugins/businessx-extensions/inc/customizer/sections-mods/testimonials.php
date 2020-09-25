<?php
/* ------------------------------------------------------------------------- *
 *  ______
 *
 *  Testimonials
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
	$wp_customize->add_section( new BXEXT_Section_FrontPage( $wp_customize, 'businessx_section__testimonials', array(
		'title'				=> esc_html__( 'Testimonials Section', 'businessx-extensions' ),
		'panel'				=> 'businessx_panel__sections',
		'priority'			=> absint( businessx_extensions_sec_prio( 'businessx_section__testimonials' ) ),
	) ) );



		/*  Testimonials Section options
		/* ------------------------------------ */
		$wp_customize->add_setting( 'testimonials-addedititems', array() );

		$wp_customize->add_control( new BXEXT_Control_AddEditItems( $wp_customize, 'testimonials-addedititems', array(
			'section'      => 'businessx_section__testimonials',
			'type'         => 'add-edit-items',
			'section_type' => 'testimonials',
			'item_type'    => __( 'Add or edit testimonials', 'businessx-extensions' )
		) ) );

		// Hide section
		businessx_controller_checkbox(
			'testimonials_section_hide',
			'businessx_section__testimonials',
			esc_html__( 'Hide this section', 'businessx-extensions' ) );
		/*=====*/

		// Section title
		businessx_controller_txt(
			'testimonials_section_title',
			'businessx_section__testimonials',
			esc_html__( 'Section title', 'businessx-extensions' ),
			esc_html__( 'Set a title for this section.', 'businessx-extensions' ),
			esc_html__( 'Testimonials', 'businessx-extensions' ),
			'.sec-testimonials .section-title' );
		/*=====*/

		// Section tabs
		$wp_customize->add_setting( 'testimonials-sectiontabs', array() );

		$wp_customize->add_control( new BXEXT_Control_Tabs( $wp_customize, 'testimonials-sectiontabs', array(
			'section'          => 'businessx_section__testimonials',
			'type'             => 'section-tabs',
			'title_colors'     => __( 'Colors', 'businessx-extensions' ),
			'title_background' => __( 'Background', 'businessx-extensions' )
		) ) );

		// Section colors
		businessx_controller_color_picker(
			'testimonials_color_background',
			'businessx_section__testimonials',
			esc_html__( 'Section background color:', 'businessx-extensions' ),
			esc_html__( 'In case you do not have a background image', 'businessx-extensions' ),
			'#1f1f1f' );
		/*=====*/

		businessx_controller_color_picker(
			'testimonials_color_headings',
			'businessx_section__testimonials',
			esc_html__( 'Headings color:', 'businessx-extensions' ),
			'', '#ffffff' );
		/*=====*/

		businessx_controller_color_picker(
			'testimonials_color_heading_border',
			'businessx_section__testimonials',
			esc_html__( 'Section heading border color:', 'businessx-extensions' ),
			'', '#884cf3' );
		/*=====*/

		businessx_controller_color_picker(
			'testimonials_color_text',
			'businessx_section__testimonials',
			esc_html__( 'Text color:', 'businessx-extensions' ),
			'', '#bbbbbb' );
		/*=====*/

		businessx_controller_rgba_picker(
			'testimonials_color_item_bg',
			'businessx_section__testimonials',
			esc_html__( 'Slide background color:', 'businessx-extensions' ),
			'', 'rgba(40,40,40,1)' );
		/*=====*/

		businessx_controller_color_picker(
			'testimonials_color_avatar_bg',
			'businessx_section__testimonials',
			esc_html__( 'Avatar background color:', 'businessx-extensions' ),
			'', '#ffffff' );
		/*=====*/

		businessx_controller_color_picker(
			'testimonials_color_button_bg',
			'businessx_section__testimonials',
			esc_html__( 'Button background:', 'businessx-extensions' ),
			'', '#884cf3' );
		/*=====*/

		businessx_controller_color_picker(
			'testimonials_color_button_bg_hover',
			'businessx_section__testimonials',
			esc_html__( 'Button :hover background:', 'businessx-extensions' ),
			'', '#aa7bff' );
		/*=====*/

		businessx_controller_color_picker(
			'testimonials_color_button_bg_active',
			'businessx_section__testimonials',
			esc_html__( 'Button :active background:', 'businessx-extensions' ),
			'', '#6c32d4' );
		/*=====*/

		businessx_controller_rgba_picker(
			'testimonials_color_nav_bg',
			'businessx_section__testimonials',
			esc_html__( 'Navigation background color:', 'businessx-extensions' ),
			'', 'rgba(40,40,40,1)' );
		/*=====*/

		businessx_controller_color_picker(
			'testimonials_color_nav_border',
			'businessx_section__testimonials',
			esc_html__( 'Navigation border color:', 'businessx-extensions' ),
			'', '#884cf3' );
		/*=====*/

		businessx_controller_color_picker(
			'testimonials_color_nav_btns',
			'businessx_section__testimonials',
			esc_html__( 'Navigation font color:', 'businessx-extensions' ),
			'', '#ffffff' );
		/*=====*/

		// Background image
		businessx_controller_bg_image( 'testimonials_bg_image', 'businessx_section__testimonials', esc_html__( 'Background Image:', 'businessx-extensions' ), '', esc_html__( 'Use a HD image, suggested size: 1920x1080px', 'businessx-extensions' ) );
		/*=====*/

		// Background overlay
		businessx_controller_bg_overlay( 'testimonials_bg_overlay', 'businessx_section__testimonials', esc_html__( 'Show Background Overlay', 'businessx-extensions' ) );
		/*=====*/

		// Backgroud parallax
		businessx_controller_bg_parallax( 'testimonials_bg_parallax', 'businessx_section__testimonials', esc_html__( 'Enable Parallax Effect', 'businessx-extensions' ) );
		businessx_controller_simple_image(
			'testimonials_bg_parallax_img',
			'businessx_section__testimonials',
			esc_html__( 'Parallax Background Image', 'businessx-extensions' ),
			esc_html__( 'Use a HD image, suggested size: 1920x1080px', 'businessx-extensions' ), '', false
		);
		/*=====*/
