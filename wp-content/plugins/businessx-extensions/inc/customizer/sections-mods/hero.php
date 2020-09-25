<?php
/* ------------------------------------------------------------------------- *
 *  ______
 *
 *  Hero Section
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
	$wp_customize->add_section( new BXEXT_Section_FrontPage( $wp_customize, 'businessx_section__hero', array(
		'title'				=> esc_html__( 'Hero Section', 'businessx-extensions' ),
		'panel'				=> 'businessx_panel__sections',
		'priority'			=> absint( businessx_extensions_sec_prio( 'businessx_section__hero' ) ),
	) ) );



		/*  Hero Section options
		/* ------------------------------------ */

		// Hide section
		businessx_controller_checkbox(
			'hero_section_hide',
			'businessx_section__hero',
			esc_html__( 'Hide this section', 'businessx-extensions' ) );
		/*=====*/

		// Section title
		businessx_controller_txt(
			'hero_section_title',
			'businessx_section__hero',
			esc_html__( 'Heading:', 'businessx-extensions' ), '',
			esc_html__( 'Hero section title goes here.', 'businessx-extensions' ),
			'.sec-hero .hs-primary-large' );
		/*=====*/

		// Section description
		businessx_controller_txt_area(
			'hero_section_description',
			'businessx_section__hero',
			esc_html__( 'Paragraph:', 'businessx-extensions' ), '',
			esc_html__( 'You can edit this section by going to Customizer > Sections > Hero Section', 'businessx-extensions' ),
			'.sec-hero .sec-hs-description', true, 'businessx_ext_sanitize_content_filtered' );
		/*=====*/

		// Columns
		businessx_controller_select(
			'hero_section_btns',
			'businessx_section__hero',
			apply_filters( 'businessx_hero___btns_type_select', array(
				'btns-1-default' 	=> esc_html__( 'One - Default', 'businessx-extensions' ),
				'btns-1-opaque' 	=> esc_html__( 'One - Opaque', 'businessx-extensions' ),
				'btns-1-l-default' 	=> esc_html__( 'One Large - Default', 'businessx-extensions' ),
				'btns-1-l-opaque' 	=> esc_html__( 'One Large - Opaque', 'businessx-extensions' ),
				'btns-2-default' 	=> esc_html__( 'Two - Default', 'businessx-extensions' ),
				'btns-2-opaque' 	=> esc_html__( 'Two - Opaque', 'businessx-extensions' ),
				'btns-2-def-op' 	=> esc_html__( 'Two - Default + Opaque', 'businessx-extensions' ),
				'btns-2-op-def' 	=> esc_html__( 'Two - Opaque + Default', 'businessx-extensions' ),
			) ),
			esc_html__( 'Buttons:', 'businessx-extensions' ), '',
			apply_filters( 'businessx_hero___btns_type_default', 'btns-2-def-op' )
		);
		/*=====*/

		// 1st Button
		businessx_controller_txt(
			'hero_section_1st_btn',
			'businessx_section__hero',
			esc_html__( 'Button #1 text:', 'businessx-extensions' ), '', esc_html__( 'Call to Action', 'businessx-extensions' ),
			'.sec-hero .ac-btn-1st' );
		/*=====*/

		// 1st Button Link
		businessx_controller_txt(
			'hero_section_1st_btn_link',
			'businessx_section__hero',
			esc_html__( 'Button #1 link:', 'businessx-extensions' ),
			esc_html__( 'Also include http://', 'businessx-extensions' ), '', '',
			true, false, 'esc_url' );
		/*=====*/

		// 1st Button Target
		businessx_controller_checkbox(
			'hero_section_1st_btn_target',
			'businessx_section__hero',
			esc_html__( 'Open #1 in a new window', 'businessx-extensions' ), '', false, true );
		/*=====*/

		// 2nd Button
		businessx_controller_txt(
			'hero_section_2nd_btn',
			'businessx_section__hero',
			esc_html__( 'Button #2 text:', 'businessx-extensions' ), '', esc_html__( 'Call to Action', 'businessx-extensions' ),
			'.sec-hero .ac-btn-2nd' );
		/*=====*/

		// 2nd Button Link
		businessx_controller_txt(
			'hero_section_2nd_btn_link',
			'businessx_section__hero',
			esc_html__( 'Button #1 link:', 'businessx-extensions' ),
			esc_html__( 'Also include http://', 'businessx-extensions' ), '', '',
			true, false, 'esc_url' );
		/*=====*/

		// 2nd Button Target
		businessx_controller_checkbox(
			'hero_section_2nd_btn_target',
			'businessx_section__hero',
			esc_html__( 'Open #2 in a new window', 'businessx-extensions' ), '', false, true );
		/*=====*/

		// Text Between buttons
		businessx_controller_txt(
			'hero_section_btns_or',
			'businessx_section__hero',
			esc_html__( 'Text between buttons:', 'businessx-extensions' ), '', esc_html__( 'Or', 'businessx-extensions' ),
			'.sec-hero .ac-btns-or' );
		/*=====*/

		// Section tabs
		$wp_customize->add_setting( 'hero-sectiontabs', array() );

		$wp_customize->add_control( new BXEXT_Control_Tabs( $wp_customize, 'hero-sectiontabs', array(
			'section'          => 'businessx_section__hero',
			'type'             => 'section-tabs',
			'title_colors'     => __( 'Colors', 'businessx-extensions' ),
			'title_background' => __( 'Background', 'businessx-extensions' )
		) ) );

		// Section colors
		businessx_controller_color_picker(
			'hero_color_background',
			'businessx_section__hero',
			esc_html__( 'Section background color:', 'businessx-extensions' ),
			esc_html__( 'In case you do not have a background image', 'businessx-extensions' ),
			'#2f2f2f' );
		/*=====*/

		businessx_controller_color_picker(
			'hero_color_heading_link',
			'businessx_section__hero',
			esc_html__( 'Heading color:', 'businessx-extensions' ),
			'', '#ffffff' );
		/*=====*/

		businessx_controller_rgba_picker(
			'hero_color_text',
			'businessx_section__hero',
			esc_html__( 'Text color:', 'businessx-extensions' ),
			'', 'rgba(255,255,255,0.8)', true, false );
		/*=====*/

		businessx_controller_color_picker(
			'hero_color_hover',
			'businessx_section__hero',
			esc_html__( 'Links :hover color:', 'businessx-extensions' ),
			esc_html__( 'This will work only on links (if available), not buttons:', 'businessx-extensions' ),
			'#ffffff' );
		/*=====*/

		businessx_controller_rgba_picker(
			'hero_color_shadow',
			'businessx_section__hero',
			esc_html__( 'Top shadow color:', 'businessx-extensions' ),
			'', 'rgba(0,0,0,0.75)', true, false );
		/*=====*/

		businessx_controller_rgba_picker(
			'hero_color_text_shadow',
			'businessx_section__hero',
			esc_html__( 'Text shadow color:', 'businessx-extensions' ),
			'', 'rgba(0,0,0,0.75)', true, false );
		/*=====*/

		businessx_controller_color_picker(
			'hero_color_btn_1_bg',
			'businessx_section__hero',
			esc_html__( 'Default button', 'businessx-extensions' ), '',
			'#76bc1c' );
		/*=====*/

		businessx_controller_color_picker(
			'hero_color_btn_1_bg_hover',
			'businessx_section__hero',
			esc_html__( 'Default button :hover', 'businessx-extensions' ), '',
			'#82cf1f' );
		/*=====*/

		businessx_controller_color_picker(
			'hero_color_btn_1_bg_focus',
			'businessx_section__hero',
			esc_html__( 'Default button :focus', 'businessx-extensions' ), '',
			'#69a619' );
		/*=====*/

		businessx_controller_rgba_picker(
			'hero_color_btn_2_bg',
			'businessx_section__hero',
			esc_html__( 'Opaque button', 'businessx-extensions' ), '',
			'rgba(28,130,188,0.5)', true, false );
		/*=====*/

		businessx_controller_rgba_picker(
			'hero_color_btn_2_border',
			'businessx_section__hero',
			esc_html__( 'Opaque button border', 'businessx-extensions' ), '',
			'rgba(28,130,188,1)', true, false );
		/*=====*/

		businessx_controller_color_picker(
			'hero_color_btn_2_bg_hover',
			'businessx_section__hero',
			esc_html__( 'Opaque button :hover', 'businessx-extensions' ), '',
			'#1c82bc' );
		/*=====*/

		businessx_controller_color_picker(
			'hero_color_btn_2_bg_focus',
			'businessx_section__hero',
			esc_html__( 'Opaque button :focus', 'businessx-extensions' ), '',
			'#1972a6' );
		/*=====*/

		// Background image
		businessx_controller_bg_image( 'hero_bg_image', 'businessx_section__hero', esc_html__( 'Background Image:', 'businessx-extensions' ), '', esc_html__( 'Use a HD image, suggested size: 1920x1080px', 'businessx-extensions' ) );
		/*=====*/

		// Background overlay
		businessx_controller_rgba_picker(
			'hero_bg_overlay',
			'businessx_section__hero',
			esc_html__( 'Overlay background color:', 'businessx-extensions' ),
			'', 'rgba(5,20,30,0.4)', true, false );
		/*=====*/

		// Backgroud parallax
		businessx_controller_bg_parallax( 'hero_bg_parallax', 'businessx_section__hero', esc_html__( 'Enable Parallax Effect', 'businessx-extensions' ) );
		businessx_controller_simple_image(
			'hero_bg_parallax_img',
			'businessx_section__hero',
			esc_html__( 'Parallax Background Image', 'businessx-extensions' ),
			esc_html__( 'Use a HD image, suggested size: 1920x1080px', 'businessx-extensions' ), '', false
		);
		/*=====*/
