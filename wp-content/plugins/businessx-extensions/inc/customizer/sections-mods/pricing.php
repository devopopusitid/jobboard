<?php
/* ------------------------------------------------------------------------- *
 *  ______
 *
 *  Pricing Section
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
	$wp_customize->add_section( new BXEXT_Section_FrontPage( $wp_customize, 'businessx_section__pricing', array(
		'title'				=> esc_html__( 'Pricing Section', 'businessx-extensions' ),
		'panel'				=> 'businessx_panel__sections',
		'priority'			=> absint( businessx_extensions_sec_prio( 'businessx_section__pricing' ) ),
	) ) );



		/*  Pricing Section options
		/* ------------------------------------ */
		$wp_customize->add_setting( 'pricing-addedititems', array() );

		$wp_customize->add_control( new BXEXT_Control_AddEditItems( $wp_customize, 'pricing-addedititems', array(
			'section'      => 'businessx_section__pricing',
			'type'         => 'add-edit-items',
			'section_type' => 'pricing',
			'item_type'    => __( 'Add or edit packages', 'businessx-extensions' )
		) ) );

		// Hide section
		businessx_controller_checkbox(
			'pricing_section_hide',
			'businessx_section__pricing',
			esc_html__( 'Hide this section', 'businessx-extensions' ) );
		/*=====*/

		// Section title
		businessx_controller_txt(
			'pricing_section_title',
			'businessx_section__pricing',
			esc_html__( 'Section title', 'businessx-extensions' ),
			esc_html__( 'Set a title for this section.', 'businessx-extensions' ),
			esc_html__( 'Pricing Heading', 'businessx-extensions' ),
			'.sec-pricing .section-title' );
		/*=====*/

		// Section description
		businessx_controller_txt_area(
			'pricing_section_description',
			'businessx_section__pricing',
			esc_html__( 'Section description', 'businessx-extensions' ),
			esc_html__( 'Set a description for this section.', 'businessx-extensions' ),
			esc_html__( 'This is a description for the Pricing section. You can set it up in the Customizer where you can also add items for it.', 'businessx-extensions' ),
			'.sec-pricing .section-description', true, 'businessx_ext_sanitize_content_filtered' );
		/*=====*/

		// Columns
		businessx_controller_select(
			'pricing_section_columns',
			'businessx_section__pricing',
			apply_filters( 'businessx_pricing_columns_number', array(
				'grid-2x-col' 	=> 'Two columns',
				'grid-2x3-col' 	=> 'Three columns',
				'grid-1x-col' 	=> 'Four columns'
			) ),
			esc_html__( 'Grid:', 'businessx-extensions' ), '',
			apply_filters( 'businessx_pricing_columns_type', 'grid-2x3-col' )
		);
		/*=====*/

		// Section tabs
		$wp_customize->add_setting( 'pricing-sectiontabs', array() );

		$wp_customize->add_control( new BXEXT_Control_Tabs( $wp_customize, 'pricing-sectiontabs', array(
			'section'          => 'businessx_section__pricing',
			'type'             => 'section-tabs',
			'title_colors'     => __( 'Colors', 'businessx-extensions' ),
			'title_background' => __( 'Background', 'businessx-extensions' )
		) ) );

		// Section colors
		businessx_controller_color_picker(
			'pricing_color_background',
			'businessx_section__pricing',
			esc_html__( 'Section background color:', 'businessx-extensions' ),
			esc_html__( 'In case you do not have a background image', 'businessx-extensions' ),
			'#ffffff' );
		/*=====*/

		businessx_controller_color_picker(
			'pricing_color_heading_link',
			'businessx_section__pricing',
			esc_html__( 'Headings and links colors:', 'businessx-extensions' ),
			'', '#232323' );
		/*=====*/

		businessx_controller_color_picker(
			'pricing_color_heading_border',
			'businessx_section__pricing',
			esc_html__( 'Borders color:', 'businessx-extensions' ),
			'', '#ab4ed5' );
		/*=====*/

		businessx_controller_color_picker(
			'pricing_color_text',
			'businessx_section__pricing',
			esc_html__( 'Text color:', 'businessx-extensions' ),
			'', '#636363' );
		/*=====*/

		businessx_controller_color_picker(
			'pricing_color_hover',
			'businessx_section__pricing',
			esc_html__( 'Links :hover color', 'businessx-extensions' ),
			'',
			'#232323' );
		/*=====*/

		// Background image
		businessx_controller_bg_image( 'pricing_bg_image', 'businessx_section__pricing', esc_html__( 'Background Image:', 'businessx-extensions' ), '', esc_html__( 'Use a HD image, suggested size: 1920x1080px', 'businessx-extensions' ) );
		/*=====*/

		// Background overlay
		businessx_controller_bg_overlay( 'pricing_bg_overlay', 'businessx_section__pricing', esc_html__( 'Show Background Overlay', 'businessx-extensions' ) );
		/*=====*/

		// Backgroud parallax
		businessx_controller_bg_parallax( 'pricing_bg_parallax', 'businessx_section__pricing', esc_html__( 'Enable Parallax Effect', 'businessx-extensions' ) );
		businessx_controller_simple_image(
			'pricing_bg_parallax_img',
			'businessx_section__pricing',
			esc_html__( 'Parallax Background Image', 'businessx-extensions' ),
			esc_html__( 'Use a HD image, suggested size: 1920x1080px', 'businessx-extensions' ), '', false
		);
		/*=====*/
