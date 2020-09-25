<?php
/* ------------------------------------------------------------------------- *
 *  ______
 *
 *  Slider Section
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
	$wp_customize->add_section( new BXEXT_Section_FrontPage( $wp_customize, 'businessx_section__slider', array(
		'title'				=> esc_html__( 'Slider Section', 'businessx-extensions' ),
		'panel'				=> 'businessx_panel__sections',
		'priority'			=> absint( businessx_extensions_sec_prio( 'businessx_section__slider' ) ),
	) ) );



		/*  Slider Section options
		/* ------------------------------------ */
		$wp_customize->add_setting( 'slider-addedititems', array() );

		$wp_customize->add_control( new BXEXT_Control_AddEditItems( $wp_customize, 'slider-addedititems', array(
			'section'      => 'businessx_section__slider',
			'type'         => 'add-edit-items',
			'section_type' => 'slider',
			'item_type'    => __( 'Add or edit slides', 'businessx-extensions' )
		) ) );

		// Hide section
		businessx_controller_checkbox(
			'slider_section_hide',
			'businessx_section__slider',
			esc_html__( 'Hide this section', 'businessx-extensions' ) );
		/*=====*/

		// Disable arrows
		businessx_controller_checkbox(
			'slider_arrows_disable',
			'businessx_section__slider',
			esc_html__( 'Disable arrows', 'businessx-extensions' ), esc_html__( 'This will disable navigation arrows', 'businessx-extensions' ),
			false, false );
		/*=====*/

		// Autoplay options
		businessx_controller_checkbox(
			'slider_autoplay_enable',
			'businessx_section__slider',
			esc_html__( 'Enable autoplay', 'businessx-extensions' ), esc_html__( 'This will only work on the live website', 'businessx-extensions' ),
			false, true );
		/*=====*/

		businessx_controller_txt(
			'slider_autoplay_delay',
			'businessx_section__slider',
			esc_html__( 'Autoplay delay', 'businessx-extensions' ), esc_html__( 'In miliseconds, 5000 = 5 seconds. This will only work on the live website', 'businessx-extensions' ),
			'5000',
			'', true, false, 'absint' );
		/*=====*/

		// Section colors
		businessx_controller_color_picker(
			'slider_background_color',
			'businessx_section__slider',
			esc_html__( 'Section background color:', 'businessx-extensions' ),
			esc_html__( 'In case you do not have a background image', 'businessx-extensions' ),
			'#232323' );
		/*=====*/

		// Arrows
		businessx_controller_rgba_picker(
			'slider_arrows_bg',
			'businessx_section__slider',
			esc_html__( 'Arrows background color:', 'businessx-extensions' ),
			'', 'rgba(255,255,255,0.1)', true, false );
		/*=====*/

		businessx_controller_rgba_picker(
			'slider_arrows_bg_hover',
			'businessx_section__slider',
			esc_html__( 'Arrows :hover bg color:', 'businessx-extensions' ),
			'', 'rgba(255,255,255,0.2)', true, false );
		/*=====*/

		businessx_controller_color_picker(
			'slider_arrows_color',
			'businessx_section__slider',
			esc_html__( 'Arrows icon color:', 'businessx-extensions' ),
			'', '#ffffff' );
		/*=====*/

		// Dots
		businessx_controller_rgba_picker(
			'slider_dots_bg',
			'businessx_section__slider',
			esc_html__( 'Dots background color:', 'businessx-extensions' ),
			'', 'rgba(255,255,255,0.2)', true, false );
		/*=====*/

		businessx_controller_rgba_picker(
			'slider_dots_bg_hover',
			'businessx_section__slider',
			esc_html__( 'Dots hover bg color:', 'businessx-extensions' ),
			'', 'rgba(255,255,255,0.4)', true, false );
		/*=====*/

		businessx_controller_color_picker(
			'slider_dots_active',
			'businessx_section__slider',
			esc_html__( 'Dots active border color:', 'businessx-extensions' ),
			'', '#ffffff' );
		/*=====*/
