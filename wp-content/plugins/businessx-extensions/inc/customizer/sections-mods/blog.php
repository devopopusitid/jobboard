<?php
/* ------------------------------------------------------------------------- *
 *  ______
 *
 *  Blog
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
	$wp_customize->add_section( new BXEXT_Section_FrontPage( $wp_customize, 'businessx_section__blog', array(
		'title'				=> esc_html__( 'Blog Section', 'businessx-extensions' ),
		'panel'				=> 'businessx_panel__sections',
		'priority'			=> absint( businessx_extensions_sec_prio( 'businessx_section__blog' ) ),
	) ) );



		/*  Blog Section options
		/* ------------------------------------ */

		// Hide section
		businessx_controller_checkbox(
			'blog_section_hide',
			'businessx_section__blog',
			esc_html__( 'Hide this section', 'businessx-extensions' ) );
		/*=====*/

		// Section title
		businessx_controller_txt(
			'blog_section_title',
			'businessx_section__blog',
			esc_html__( 'Section title', 'businessx-extensions' ),
			esc_html__( 'Set a title for this section.', 'businessx-extensions' ),
			esc_html__( 'Blog Heading', 'businessx-extensions' ),
			'.sec-blog .section-title' );
		/*=====*/

		// Section description
		businessx_controller_txt_area(
			'blog_section_description',
			'businessx_section__blog',
			esc_html__( 'Section description', 'businessx-extensions' ),
			esc_html__( 'Set a description for this section.', 'businessx-extensions' ),
			esc_html__( 'This is a description for the Blog section. You can set it up in the Customizer where you can also add items for it.', 'businessx-extensions' ),
			'.sec-blog .section-description', true, 'businessx_ext_sanitize_content_filtered' );
		/*=====*/

		// Number of posts
		businessx_controller_txt(
			'blog_section_nr_posts',
			'businessx_section__blog',
			esc_html__( 'Number of posts', 'businessx-extensions' ),
			esc_html__( 'How many posts do you want to display?.', 'businessx-extensions' ),
			4, '', false, false, 'absint' );
		/*=====*/

		// Show action button
		bx_ext_controller_simple( array(
			'type' => 'checkbox',
			'setting_id' => 'blog_action_btn_show',
			'section_id' => 'businessx_section__blog',
			'label' => esc_html__( 'Show "More Articles" button?', 'businessx-extensions' ),
			'default' => false,
			'transport' => false,
		) );

		// Action button
		bx_ext_controller_simple( array(
			'setting_id' => 'blog_action_btn',
			'section_id' => 'businessx_section__blog',
			'label' => esc_html__( 'More articles label:', 'businessx-extensions' ),
			'default' => esc_html__( 'View More Articles', 'businessx-extensions' ),
			'sanitize' => 'sanitize_text_field',
			'selector' => '.blog-action-btn',
			'escape'   => 'esc_html',
		) );

		// Action button url
		bx_ext_controller_simple( array(
			'setting_id' => 'blog_action_btn_url',
			'section_id' => 'businessx_section__blog',
			'label' => esc_html__( 'More articles URL:', 'businessx-extensions' ),
			'default' => '#',
			'sanitize' => 'esc_url_raw',
			'postmsg' => true,
		) );

		// Section tabs
		$wp_customize->add_setting( 'blog-sectiontabs', array() );

		$wp_customize->add_control( new BXEXT_Control_Tabs( $wp_customize, 'blog-sectiontabs', array(
			'section'          => 'businessx_section__blog',
			'type'             => 'section-tabs',
			'title_colors'     => __( 'Colors', 'businessx-extensions' ),
			'title_background' => __( 'Background', 'businessx-extensions' )
		) ) );

		// Section colors
		businessx_controller_color_picker(
			'blog_color_background',
			'businessx_section__blog',
			esc_html__( 'Section background color:', 'businessx-extensions' ),
			esc_html__( 'In case you do not have a background image', 'businessx-extensions' ),
			'#ffffff' );
		/*=====*/

		businessx_controller_color_picker(
			'blog_color_heading_link',
			'businessx_section__blog',
			esc_html__( 'Headings and links colors:', 'businessx-extensions' ),
			'', '#232323' );
		/*=====*/

		businessx_controller_color_picker(
			'blog_color_heading_border',
			'businessx_section__blog',
			esc_html__( 'Section heading border color:', 'businessx-extensions' ),
			'', '#c00000' );
		/*=====*/

		businessx_controller_color_picker(
			'blog_color_text',
			'businessx_section__blog',
			esc_html__( 'Text color:', 'businessx-extensions' ),
			'', '#636363' );
		/*=====*/

		businessx_controller_color_picker(
			'blog_color_hover',
			'businessx_section__blog',
			esc_html__( 'Hover color:', 'businessx-extensions' ),
			'',
			'#232323' );
		/*=====*/

		businessx_controller_color_picker(
			'blog_color_rm_border',
			'businessx_section__blog',
			esc_html__( '"Read More" border color:', 'businessx-extensions' ),
			'',
			'#c00000' );
		/*=====*/

		businessx_controller_color_picker(
			'blog_color_rm_border_hover',
			'businessx_section__blog',
			esc_html__( '"Read More" hover border color:', 'businessx-extensions' ),
			'',
			'#232323' );
		/*=====*/

		// Background image
		businessx_controller_bg_image( 'blog_bg_image', 'businessx_section__blog', esc_html__( 'Background Image:', 'businessx-extensions' ), '', esc_html__( 'Use a HD image, suggested size: 1920x1080px', 'businessx-extensions' ) );
		/*=====*/

		// Background overlay
		businessx_controller_bg_overlay( 'blog_bg_overlay', 'businessx_section__blog', esc_html__( 'Show Background Overlay', 'businessx-extensions' ) );
		/*=====*/

		// Backgroud parallax
		businessx_controller_bg_parallax( 'blog_bg_parallax', 'businessx_section__blog', esc_html__( 'Enable Parallax Effect', 'businessx-extensions' ) );
		businessx_controller_simple_image(
			'blog_bg_parallax_img',
			'businessx_section__blog',
			esc_html__( 'Parallax Background Image', 'businessx-extensions' ),
			esc_html__( 'Use a HD image, suggested size: 1920x1080px. It is not recommended you use this option if you display more than 4 posts.', 'businessx-extensions' ), '', false
		);
		/*=====*/
