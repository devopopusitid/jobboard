<?php
/* ------------------------------------------------------------------------- *
 *  ______
 *
 *  Clients
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
	$wp_customize->add_section( new BXEXT_Section_FrontPage( $wp_customize, 'businessx_section__clients', array(
		'title'				=> esc_html__( 'Clients Section', 'businessx-extensions' ),
		'panel'				=> 'businessx_panel__sections',
		'priority'			=> absint( businessx_extensions_sec_prio( 'businessx_section__clients' ) ),
	) ) );



		/*  Clients Section options
		/* ------------------------------------ */
		$wp_customize->add_setting( 'clients-addedititems', array() );

		$wp_customize->add_control( new BXEXT_Control_AddEditItems( $wp_customize, 'clients-addedititems', array(
			'section'      => 'businessx_section__clients',
			'type'         => 'add-edit-items',
			'section_type' => 'clients',
			'item_type'    => __( 'Add or edit clients', 'businessx-extensions' )
		) ) );

		// Hide section
		businessx_controller_checkbox(
			'clients_section_hide',
			'businessx_section__clients',
			esc_html__( 'Hide this section', 'businessx-extensions' ) );
		/*=====*/

		// Section title
		businessx_controller_txt(
			'clients_section_title',
			'businessx_section__clients',
			esc_html__( 'Section title', 'businessx-extensions' ),
			esc_html__( 'Set a title for this section.', 'businessx-extensions' ),
			esc_html__( 'Clients Heading', 'businessx-extensions' ),
			'.sec-clients .section-title' );
		/*=====*/

		// Section description
		businessx_controller_txt_area(
			'clients_section_description',
			'businessx_section__clients',
			esc_html__( 'Section description', 'businessx-extensions' ),
			esc_html__( 'Set a description for this section.', 'businessx-extensions' ),
			esc_html__( 'This is a description for the Clients section. You can set it up in the Customizer where you can also add items for it.', 'businessx-extensions' ),
			'.sec-clients .section-description', true, 'businessx_ext_sanitize_content_filtered' );
		/*=====*/

		// Autoscroll carousel
		businessx_controller_checkbox(
			'clients_section_autoscroll',
			'businessx_section__clients',
			esc_html__( 'Enable autoscroll', 'businessx-extensions' ),
			esc_html__( 'The autoscroll function works only on the live website, not in Customizer', 'businessx-extensions' ),
			false, true );
		/*=====*/

		// Section tabs
		$wp_customize->add_setting( 'clients-sectiontabs', array() );

		$wp_customize->add_control( new BXEXT_Control_Tabs( $wp_customize, 'clients-sectiontabs', array(
			'section'          => 'businessx_section__clients',
			'type'             => 'section-tabs',
			'title_colors'     => __( 'Colors', 'businessx-extensions' ),
			'title_background' => __( 'Background', 'businessx-extensions' )
		) ) );

		// Section colors
		businessx_controller_color_picker(
			'clients_color_background',
			'businessx_section__clients',
			esc_html__( 'Section background color:', 'businessx-extensions' ),
			esc_html__( 'In case you do not have a background image', 'businessx-extensions' ),
			'#ffffff' );
		/*=====*/

		businessx_controller_color_picker(
			'clients_color_heading',
			'businessx_section__clients',
			esc_html__( 'Headings color:', 'businessx-extensions' ),
			'', '#232323' );
		/*=====*/

		businessx_controller_color_picker(
			'clients_color_heading_border',
			'businessx_section__clients',
			esc_html__( 'Section heading border color:', 'businessx-extensions' ),
			'', '#e7ab4a' );
		/*=====*/

		businessx_controller_color_picker(
			'clients_color_text',
			'businessx_section__clients',
			esc_html__( 'Text color:', 'businessx-extensions' ),
			'', '#636363' );
		/*=====*/

		businessx_controller_color_picker(
			'clients_color_borders',
			'businessx_section__clients',
			esc_html__( 'Borders color:', 'businessx-extensions' ),
			'', '#dadada' );
		/*=====*/

		businessx_controller_color_picker(
			'clients_color_wrapper_bg',
			'businessx_section__clients',
			esc_html__( 'Carousel background color:', 'businessx-extensions' ),
			'', '#ffffff' );
		/*=====*/

		businessx_controller_color_picker(
			'clients_color_nav_bg',
			'businessx_section__clients',
			esc_html__( 'Navigation background color:', 'businessx-extensions' ),
			'', '#f3f3f3' );
		/*=====*/

		businessx_controller_color_picker(
			'clients_color_nav_btns',
			'businessx_section__clients',
			esc_html__( 'Navigation font color:', 'businessx-extensions' ),
			'', '#232323' );
		/*=====*/

		// Background image
		businessx_controller_bg_image( 'clients_bg_image', 'businessx_section__clients', esc_html__( 'Background Image:', 'businessx-extensions' ), '', esc_html__( 'Use a HD image, suggested size: 1920x1080px', 'businessx-extensions' ) );
		/*=====*/

		// Background overlay
		businessx_controller_bg_overlay( 'clients_bg_overlay', 'businessx_section__clients', esc_html__( 'Show Background Overlay', 'businessx-extensions' ) );
		/*=====*/

		// Backgroud parallax
		businessx_controller_bg_parallax( 'clients_bg_parallax', 'businessx_section__clients', esc_html__( 'Enable Parallax Effect', 'businessx-extensions' ) );
		businessx_controller_simple_image(
			'clients_bg_parallax_img',
			'businessx_section__clients',
			esc_html__( 'Parallax Background Image', 'businessx-extensions' ),
			esc_html__( 'Use a HD image, suggested size: 1920x1080px.', 'businessx-extensions' ), '', false
		);
		/*=====*/
