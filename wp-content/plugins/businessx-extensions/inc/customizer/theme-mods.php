<?php
/* ------------------------------------------------------------------------- *
 *
 *  Theme mods
 *  ________________
 *
 *	This file registers theme mods and adds some functions for
 *	the Customizer
 *	________________
 *
/* ------------------------------------------------------------------------- */


/*  Register Customizer options
/* ------------------------------------ */
if( ! function_exists( 'businessx_extensions_customize_register' ) ) {
	function businessx_extensions_customize_register( $wp_customize ) {
		$sections = businessx_extensions_sections();

		// Register custom sections/controls
		require_once( BUSINESSX_EXTS_PATH . '/inc/customizer/custom/section-dragdrop/drag-and-drop-info.php' );
		$wp_customize->register_section_type( 'BXEXT_Section_DragAndDrop' );

		require_once( BUSINESSX_EXTS_PATH . '/inc/customizer/custom/section-frontpage/front-page-section.php' );
		$wp_customize->register_section_type( 'BXEXT_Section_FrontPage' );

		require_once( BUSINESSX_EXTS_PATH . '/inc/customizer/custom/control-addedititems/add-edit-items.php' );
		$wp_customize->register_control_type( 'BXEXT_Control_AddEditItems' );

		require_once( BUSINESSX_EXTS_PATH . '/inc/customizer/custom/control-tabs/tabs.php' );
		$wp_customize->register_control_type( 'BXEXT_Control_Tabs' );

		/*  Add panels
		/* ------------------------------------ */
		// Front page
		$wp_customize->add_panel( 'businessx_panel__sections', array(
		  'title' 				=> __( 'Front Page Sections', 'businessx-extensions' ),
		  'priority'			=> 35,
		  'active_callback' 	=> 'businessx_front_pt',
		) );
		$wp_customize->add_panel( 'businessx_panel__sections_items', array(
		  'title' 				=> __( 'Sections Items', 'businessx-extensions' ),
		  'priority'			=> 36,
		  'active_callback' 	=> 'businessx_front_pt',
		) );

			// Sections position control
			$wp_customize->add_setting( 'businessx_sections_position', array(
				'default'           => '',
				'sanitize_callback' => 'businessx_ext_sanitize_sections_position'
			) );

			$wp_customize->add_control( 'businessx_sections_position', array(
				'section'  => 'title_tagline',
				'settings' => 'businessx_sections_position',
				'type'     => 'text'
			) );

			// Move section sidebars to another panel
			foreach ( $wp_customize->sections() as $id => $section ) {
				$sections_items = businessx_extensions_sections_items();
				foreach( $sections_items as $section_name ) {
					$needle = 'sidebar-widgets-section-' . $section_name;
					if( $needle === $id ) {
						$section->panel = 'businessx_panel__sections_items';
					}
				}
			}

			/*  Add sections
			/* ------------------------------------ */
			/// Drag & Drop msg
			$wp_customize->add_section( new BXEXT_Section_DragAndDrop( $wp_customize, 'dragdrop', array(
				'title'     => esc_html__( 'Drag and drop for position', 'businessx-extensions' ),
				'panel'     => 'businessx_panel__sections',
				'priority'  => 0
			) ) );

			/// Theme Settings
			$wp_customize->add_section( 'backup_options', array(
				'title'				=> __( 'Backups', 'businessx-extensions' ),
				'panel'				=> 'settings_options'
			) );

				////// Settings
				businessx_controller_info(
					'backup_info',
					'backup_options',
					__( 'Restore widgets position', 'businessx-extensions' ), '', '', 'bx-m-b' );

				businessx_controller_button(
					'backup_restore',
					'backup_options',
					__( 'Restore Backup', 'businessx-extensions' ), '', '#', 'bx-restore-sections' );


			/// Theme Sections
			if( ! empty( $sections ) ) {
				foreach( $sections as $index => $section ) {
					require_once ( BUSINESSX_EXTS_PATH . 'inc/customizer/sections-mods/' . $section . '.php' );
				}
			}


			/// Extensions Settings
			$wp_customize->add_section( 'extensions_options', array(
				'title'				=> __( 'Extensions', 'businessx-extensions' ),
				'panel'				=> 'settings_options'
			) );

				////// Settings
				businessx_controller_info(
					'disable_helpers_info',
					'extensions_options',
					__( 'Disable helpers/placeholders', 'businessx-extensions' ),
					__( 'Check the box bellow if you want to disable the helping/placeholder messages for all the sections.', 'businessx-extensions' ), '' );

				businessx_controller_checkbox(
					'disable_helpers',
					'extensions_options',
					esc_html__( 'Disable helping messages', 'businessx-extensions' ), '', false );

				if( bxext_compt_polylang_check() ) {
					/**
					 * @since 1.0.4.3
					 */
					businessx_controller_info(
						'use_polylang_info',
						'extensions_options',
						__( 'Enable Polylang translations', 'businessx-extensions' ),
						__( '<p>If you enable this, you will need to add all your text/copy from <code>Languages > Strings translations</code></p><p>This will work for sections titles, descriptions and some buttons. Any changes made to these lines from the <strong>Front Page Sections</strong> panel will not work if this option is enabled</p>', 'businessx-extensions' ), '' );

					businessx_controller_checkbox(
						'use_polylang',
						'extensions_options',
						esc_html__( 'Use Polylang translations', 'businessx-extensions' ), '', false );
				} // END bxext_compt_polylang_check()


		$wp_customize->remove_section( 'themes' );

	}
}
add_action( 'customize_register', 'businessx_extensions_customize_register', 12 );




/*  Backup widgets
/* ------------------------------------ */
if( ! function_exists( 'businessx_extensions_sections_bk_action' ) ) {
	function businessx_extensions_sections_bk_action() {

		// Check nonce
		if( ! isset( $_POST[ 'n_sections_bk' ] ) || ! wp_verify_nonce( $_POST[ 'n_sections_bk' ], 'n_sections_bk' ) )
			die( esc_html__( 'Permission denied', 'businessx-extensions' ) );

		$current_widgets = get_option( 'sidebars_widgets' );

		if( current_user_can( 'edit_theme_options' ) && ! empty( $current_widgets ) ) {
			//if( isset( $current_widgets[ 'wp_inactive_widgets' ] ) ) unset( $current_widgets[ 'wp_inactive_widgets' ] );
			$current_widgets[ 'wp_inactive_widgets' ] = array();
			update_option( 'businessx_ext_widgets_bk', $current_widgets ); }

		die();
	}
}
add_action( 'wp_ajax_businessx_extensions_sections_bk', 'businessx_extensions_sections_bk_action' );
add_action( 'wp_ajax_nopriv_businessx_extensions_sections_bk', 'businessx_extensions_sections_bk_action' );



/*  Restore widgets
/* ------------------------------------ */
if( ! function_exists( 'businessx_extensions_sections_rt_action' ) ) {
	function businessx_extensions_sections_rt_action() {

		// Check nonce
		if( ! isset( $_POST[ 'n_sections_rt' ] ) || ! wp_verify_nonce( $_POST[ 'n_sections_rt' ], 'n_sections_rt' ) )
			die( esc_html__( 'Permission denied', 'businessx-extensions' ) );

		$backup = get_option( 'businessx_ext_widgets_bk' );

		if( current_user_can( 'edit_theme_options' ) && ! empty( $backup ) ) {
			update_option( 'sidebars_widgets', $backup ); }

		die();
	}
}
add_action( 'wp_ajax_businessx_extensions_sections_rt', 'businessx_extensions_sections_rt_action' );
add_action( 'wp_ajax_nopriv_businessx_extensions_sections_rt', 'businessx_extensions_sections_rt_action' );



/*  Get/set section priority
/* ------------------------------------ */
if( ! function_exists( 'businessx_extensions_sec_prio' ) ) {
	function businessx_extensions_sec_prio( $section_name ) {
		$sections = get_theme_mod( 'businessx_sections_position' );

		if( $sections === false ) return;
		
		if( ! is_array( $sections ) ) {
			$sections = json_decode( $sections );
		}

		if( ! empty( $sections ) ) {
			foreach( $sections as $priority => $section ) {
				if( $section == $section_name ) {
					return $priority + 1;
				}
			}
		}
	}
}



/*  Customizer CSS mods
/* ------------------------------------ */
global $businessx_extensions_cs_mods;

$businessx_extensions_cs_mods = apply_filters( 'businessx_extensions_cs_mods___filter', array(

	/* Features Section */
	'features_color_heading_link' => '#232323',
	'features_color_background' => '#ffffff',
	'features_color_heading_border' => '#e3e3e3',
	'features_color_text' => '#636363',
	'features_color_hover' => '#232323',
	'features_bg_image' => '',
	'features_bg_image_size' => 'cover',
	'features_bg_image_repeat' => 'no-repeat',
	'features_bg_image_position' => 'center center',
	'features_bg_overlay_color' => '#000000',
	'features_bg_overlay_opacity' => '0.5',

	/* FAQ Section */
	'faq_color_headings' => '#232323',
	'faq_color_background' => '#f2f2f2',
	'faq_color_heading_border' => '#a252f5',
	'faq_color_heading_small_border' => '#d7d7d7',
	'faq_color_text' => '#636363',
	'faq_color_link' => '#a252f5',
	'faq_color_hover' => '#232323',
	'faq_bg_image' => '',
	'faq_bg_image_size' => 'cover',
	'faq_bg_image_repeat' => 'no-repeat',
	'faq_bg_image_position' => 'center center',
	'faq_bg_overlay_color' => '#000000',
	'faq_bg_overlay_opacity' => '0.5',

	/* Clients Section */
	'clients_color_heading' => '#232323',
	'clients_color_background' => '#ffffff',
	'clients_color_heading_border' => '#e7ab4a',
	'clients_color_text' => '#636363',
	'clients_color_borders' => '#dadada',
	'clients_color_wrapper_bg' => '#ffffff',
	'clients_color_nav_bg' => '#f3f3f3',
	'clients_color_nav_btns' => '#232323',
	'clients_bg_image' => '',
	'clients_bg_image_size' => 'cover',
	'clients_bg_image_repeat' => 'no-repeat',
	'clients_bg_image_position' => 'center center',
	'clients_bg_overlay_color' => '#000000',
	'clients_bg_overlay_opacity' => '0.5',

	/* About Us Section */
	'about_color_heading_link' => '#ffffff',
	'about_color_background' => '#2f2f2f',
	'about_color_heading_border' => '#e51638',
	'about_color_text' => '#bbbbbb',
	'about_color_btn' => 'rgba(229,22,56,0.5)',
	'about_color_btn_2nd' => '#e51638',
	'about_bg_image' => '',
	'about_bg_image_size' => 'cover',
	'about_bg_image_repeat' => 'no-repeat',
	'about_bg_image_position' => 'center center',
	'about_bg_overlay_color' => '#000000',
	'about_bg_overlay_opacity' => '0.5',

	/* Testimonials Section */
	'testimonials_color_background' => '#1f1f1f',
	'testimonials_color_headings' => '#ffffff',
	'testimonials_color_heading_border' => '#884cf3',
	'testimonials_color_text' => '#bbbbbb',
	'testimonials_color_item_bg' => 'rgba(40,40,40,1)',
	'testimonials_color_avatar_bg' => '#ffffff',
	'testimonials_color_button_bg' => '#884cf3',
	'testimonials_color_button_bg_hover' => '#aa7bff',
	'testimonials_color_button_bg_active' => '#6c32d4',
	'testimonials_color_nav_bg' => 'rgba(40,40,40,1)',
	'testimonials_color_nav_border' => '#884cf3',
	'testimonials_color_nav_btns' => '#ffffff',
	'testimonials_bg_image' => '',
	'testimonials_bg_image_size' => 'cover',
	'testimonials_bg_image_repeat' => 'no-repeat',
	'testimonials_bg_image_position' => 'center center',
	'testimonials_bg_overlay_color' => '#000000',
	'testimonials_bg_overlay_opacity' => '0.5',

	/* Team Section */
	'team_color_background' => '#1f1f1f',
	'team_color_heading_link' => '#ffffff',
	'team_color_heading_border' => '#16ade5',
	'team_color_text' => '#bbbbbb',
	'team_color_hover' => '#ffffff',
	'team_color_avatar_bg' => '#666666',
	'team_bg_image' => '',
	'team_bg_image_size' => 'cover',
	'team_bg_image_repeat' => 'no-repeat',
	'team_bg_image_position' => 'center center',
	'team_bg_overlay_color' => '#000000',
	'team_bg_overlay_opacity' => '0.5',

	/* Pricing Section */
	'pricing_color_background' => '#ffffff',
	'pricing_color_heading_link' => '#232323',
	'pricing_color_heading_border' => '#ab4ed5',
	'pricing_color_text' => '#636363',
	'pricing_color_hover' => '#232323',
	'pricing_bg_image' => '',
	'pricing_bg_image_size' => 'cover',
	'pricing_bg_image_repeat' => 'no-repeat',
	'pricing_bg_image_position' => 'center center',
	'pricing_bg_overlay_color' => '#000000',
	'pricing_bg_overlay_opacity' => '0.5',

	/* Portfolio Section */
	'portfolio_color_background' => '#f7f7f7',
	'portfolio_color_heading_link' => '#232323',
	'portfolio_color_heading_border' => '#59c7f4',
	'portfolio_color_text' => '#636363',
	'portfolio_color_hover' => '#232323',
	'portfolio_color_thumb_hover' => 'rgba(37,146,202,0.8)',
	'portfolio_color_thumb_background' => '#e3e3e3',
	'portfolio_color_thumb_color' => '#ffffff',
	'portfolio_bg_image' => '',
	'portfolio_bg_image_size' => 'cover',
	'portfolio_bg_image_repeat' => 'no-repeat',
	'portfolio_bg_image_position' => 'center center',
	'portfolio_bg_overlay_color' => '#000000',
	'portfolio_bg_overlay_opacity' => '0.5',

	/* Hero Section */
	'hero_color_background' => '#2f2f2f',
	'hero_color_heading_link' => '#ffffff',
	'hero_color_text' => 'rgba(255,255,255,0.8)',
	'hero_color_hover' => '#ffffff',
	'hero_color_shadow' => 'rgba(0,0,0,0.75)',
	'hero_color_text_shadow' => 'rgba(0,0,0,0.75)',
	'hero_color_btn_1_bg' => '#76bc1c',
	'hero_color_btn_1_bg_hover' => '#82cf1f',
	'hero_color_btn_1_bg_focus' => '#69a619',
	'hero_color_btn_2_bg' => 'rgba(28,130,188,0.5)',
	'hero_color_btn_2_border' => 'rgba(28,130,188,1)',
	'hero_color_btn_2_bg_hover' => '#1c82bc',
	'hero_color_btn_2_bg_focus' => '#1972a6',
	'hero_bg_image' => '',
	'hero_bg_image_size' => 'cover',
	'hero_bg_image_repeat' => 'no-repeat',
	'hero_bg_image_position' => 'center center',
	'hero_bg_overlay' => 'rgba(5,20,30,0.4)',

	/* Blog Section */
	'blog_color_background' => '#ffffff',
	'blog_color_heading_link' => '#232323',
	'blog_color_heading_border' => '#c00000',
	'blog_color_text' => '#636363',
	'blog_color_hover' => '#232323',
	'blog_color_rm_border' => '#c00000',
	'blog_color_rm_border_hover' => '#232323',
	'blog_bg_image' => '',
	'blog_bg_image_size' => 'cover',
	'blog_bg_image_repeat' => 'no-repeat',
	'blog_bg_image_position' => 'center center',
	'blog_bg_overlay_color' => '#000000',
	'blog_bg_overlay_opacity' => '0.5',

	/* Slider Section */
	'slider_background_color' => '#232323',
	'slider_arrows_bg' => 'rgba(255,255,255,0.1)',
	'slider_arrows_bg_hover' => 'rgba(255,255,255,0.2)',
	'slider_arrows_color' => '#ffffff',
	'slider_dots_bg' => 'rgba(255,255,255,0.2)',
	'slider_dots_bg_hover' => 'rgba(255,255,255,0.4)',
	'slider_dots_active' => '#ffffff',

	/* Contact Section */
	'contact_color_background' => '#2e910e',
	'contact_color_font' => '#ffffff',
	'contact_color_link' => '#feffc9',
	'contact_color_link_hover' => '#ffffff',
	'contact_color_headings' => '#ffffff',
	'contact_color_title_border' => '#76bc1c',
	'contact_color_social' => '#ffffff',
	'contact_color_social_bg' => 'rgba(255,255,255,0.2)',
	'contact_color_social_bg_hover' => 'rgba(255,255,255,0.4)',
	'contact_color_submit' => '#ffffff',
	'contact_color_submit_bg' => '#76bc1c',
	'contact_color_submit_bg_hover' => '#82cf1f',
	'contact_color_submit_bg_active' => '#69a619',
	'contact_bg_image' => '',
	'contact_bg_image_size' => 'cover',
	'contact_bg_image_repeat' => 'no-repeat',
	'contact_bg_image_position' => 'center center',
	'contact_bg_overlay_color' => '#000000',
	'contact_bg_overlay_opacity' => '0.5',

	/* Maps Section */
	'maps_overlay_bg' => 'rgba(0,0,0,0.8)',
	'maps_overlay_bg_hover' => 'rgba(0,0,0,0.75)',
	'maps_overlay_inner' => 'rgba(0,0,0,0.4)',
	'maps_overlay_inner_hover' => 'rgba(0,0,0,0.3)',
	'maps_title_color' => '#ffffff',
	'maps_icon_color' => '#d72f2f',

) );



/*  Output CSS for JS templating
/* ------------------------------------ */
if( ! function_exists( 'businessx_extensions_czr_output_css' ) ) {
	function businessx_extensions_czr_output_css( $settings ) {
		global $businessx_extensions_cs_mods;
		$new_settings = array();

		foreach( $businessx_extensions_cs_mods as $bcs ) {
			$new_settings[ $bcs ] = '';
		}

		$settings = wp_parse_args( $settings, $new_settings );

		/* Variables */

		return <<<CSS
		/* Features Section */
		.sec-features {
			color: {$settings['features_color_text']};
			background-image: url( {$settings['features_bg_image']} );
			background-size: {$settings['features_bg_image_size']};
			background-repeat: {$settings['features_bg_image_repeat']};
			background-position: {$settings['features_bg_image_position']};
		}
		.sec-features .grid-overlay {
			background-color: {$settings['features_bg_overlay_color']};
			opacity: {$settings['features_bg_overlay_opacity']};
		}
		.sec-features .section-title, .sec-features h3, .sec-features a, .sec-feature .ac-btn-alt, .sec-feature .ac-btn-alt:hover, .sec-feature .ac-btn-alt:focus, .sec-feature .ac-btn-alt:active {
			color: {$settings['features_color_heading_link']};
		}
		.sec-features .section-title  {
			border-color: {$settings['features_color_heading_border']};
		}
		.sec-features {
			background-color: {$settings['features_color_background']};
		}
		.sec-features a:hover { color: {$settings['features_color_hover']}; }
		.sec-features a.ac-btn-alt:hover:after { border-color: {$settings['features_color_hover']}; }

		/* FAQ Section */
		.sec-faq {
			color: {$settings['faq_color_text']};
			background-image: url( {$settings['faq_bg_image']} );
			background-size: {$settings['faq_bg_image_size']};
			background-repeat: {$settings['faq_bg_image_repeat']};
			background-position: {$settings['faq_bg_image_position']};
		}
		.sec-faq .grid-overlay {
			background-color: {$settings['faq_bg_overlay_color']};
			opacity: {$settings['faq_bg_overlay_opacity']};
		}
		.sec-faq .section-title, .sec-faq .hs-secondary-small {
			color: {$settings['faq_color_headings']};
		}
		.sec-faq .hs-secondary-small  {
			border-color: {$settings['faq_color_heading_small_border']};
		}
		.sec-faq .section-title  {
			border-color: {$settings['faq_color_heading_border']};
		}
		.sec-faq {
			background-color: {$settings['faq_color_background']};
		}
		.sec-faq a { color: {$settings['faq_color_link']}; }
		.sec-faq a:hover { color: {$settings['faq_color_hover']}; }

		/* Clients Section */
		.sec-clients {
			background-image: url( {$settings['clients_bg_image']} );
			background-color: {$settings['clients_color_background']};
			background-size: {$settings['clients_bg_image_size']};
			background-repeat: {$settings['clients_bg_image_repeat']};
			background-position: {$settings['clients_bg_image_position']};
			color: {$settings['clients_color_text']};
		}
		.sec-clients .grid-overlay {
			background-color: {$settings['clients_bg_overlay_color']};
			opacity: {$settings['clients_bg_overlay_opacity']};
		}
		.sec-clients .section-title {
			color: {$settings['clients_color_heading']};
			border-color: {$settings['clients_color_heading_border']};
		}
		.sec-clients .owl-stage-outer, .sec-clients .owl-item, .sec-clients-nav-btns {
			border-color: {$settings['clients_color_borders']};
		}
		.sec-clients .owl-stage-outer {
			background-color: {$settings['clients_color_wrapper_bg']};
		}
		.sec-clients-nav-btns {
			background-color: {$settings['clients_color_nav_bg']};
		}
		.sec-clients-nav-btn-prev, .sec-clients-nav-btn-next,
		.sec-clients-nav-btn-prev:hover, .sec-clients-nav-btn-next:hover,
		.sec-clients-nav-btn-prev:focus, .sec-clients-nav-btn-next:focus,
		.sec-clients-nav-btn-prev:active, .sec-clients-nav-btn-next:active {
			color: {$settings['clients_color_nav_btns']};
		}

		/* About Us Section */
		.sec-about {
			background-image: url( {$settings['about_bg_image']} );
			background-color: {$settings['about_color_background']};
			background-size: {$settings['about_bg_image_size']};
			background-repeat: {$settings['about_bg_image_repeat']};
			background-position: {$settings['about_bg_image_position']};
			color: {$settings['about_color_text']};
		}
		.sec-about .grid-overlay {
			background-color: {$settings['about_bg_overlay_color']};
			opacity: {$settings['about_bg_overlay_opacity']};
		}
		.sec-about .section-title, .sec-about-box h3, .sec-about-box a, .sec-about-box a:hover, .sec-about-box a:focus, .sec-about-box a:active {
			color: {$settings['about_color_heading_link']};
		}
		.sec-about .section-title, .sec-about-box:after {
			border-color: {$settings['about_color_heading_border']};
		}
		.sec-about .about-button .ac-btn.btn-opaque {
			box-shadow: inset 0 0 0 3px {$settings['about_color_btn_2nd']};
			background-color: {$settings['about_color_btn']};
		}
		.sec-about .about-button .ac-btn.btn-opaque:hover {
			background-color: {$settings['about_color_btn_2nd']};
		}

		/* Testimonials Section */
		.sec-testimonials {
			background-image: url( {$settings['testimonials_bg_image']} );
			background-color: {$settings['testimonials_color_background']};
			background-size: {$settings['testimonials_bg_image_size']};
			background-repeat: {$settings['testimonials_bg_image_repeat']};
			background-position: {$settings['testimonials_bg_image_position']};
			color: {$settings['testimonials_color_text']};
		}
		.sec-testimonials .grid-overlay {
			background-color: {$settings['testimonials_bg_overlay_color']};
			opacity: {$settings['testimonials_bg_overlay_opacity']};
		}
		.sec-testimonials .section-title {
			border-color: {$settings['testimonials_color_heading_border']};
		}
		.sec-testimonials .section-title, .sec-testimonials h3 {
			color: {$settings['testimonials_color_headings']};
		}
		.sec-testimonials .owl-item {
			background: radial-gradient(2.222em 2.222em at 50% -0.556em, rgba(0, 0, 0, 0) 2.194em, {$settings['testimonials_color_item_bg']} 2.250em);
		}
		.sec-testimonials .client-avatar { background-color: {$settings['testimonials_color_avatar_bg']}; }
		.sec-testimonials .testimonial-button .ac-btn { background-color: {$settings['testimonials_color_button_bg']}; }
		.sec-testimonials .testimonial-button .ac-btn:hover { background-color: {$settings['testimonials_color_button_bg_hover']}; }
		.sec-testimonials .testimonial-button .ac-btn:active { background-color: {$settings['testimonials_color_button_bg_active']}; }
		.sec-testimonials-nav-btns {
			background-color: {$settings['testimonials_color_nav_bg']};
			border-color: {$settings['testimonials_color_nav_border']};
		}
		.sec-testimonials-nav-btn-prev, .sec-testimonials-nav-btn-next,
		.sec-testimonials-nav-btn-prev:hover, .sec-testimonials-nav-btn-next:hover,
		.sec-testimonials-nav-btn-prev:focus, .sec-testimonials-nav-btn-next:focus,
		.sec-testimonials-nav-btn-prev:active, .sec-testimonials-nav-btn-next:active { color: {$settings['testimonials_color_nav_btns']}; }

		/* Team Section */
		.sec-team {
			background-image: url( {$settings['team_bg_image']} );
			background-color: {$settings['team_color_background']};
			background-size: {$settings['team_bg_image_size']};
			background-repeat: {$settings['team_bg_image_repeat']};
			background-position: {$settings['team_bg_image_position']};
			color: {$settings['team_color_text']};
		}
		.sec-team .grid-overlay {
			background-color: {$settings['team_bg_overlay_color']};
			opacity: {$settings['team_bg_overlay_opacity']};
		}
		.sec-team .section-title, .sec-team-member h3, .sec-team-member h4, .sec-team a, .sec-team a:focus, .sec-team a:active {
			color: {$settings['team_color_heading_link']};
		}
		.sec-team .section-title, .sec-team-member h4.hb-bottom-abs-small:after {
			border-color: {$settings['team_color_heading_border']};
		}
		.sec-team a:hover {
			color: {$settings['team_color_hover']};
		}
		.sec-team .sec-team-member-avatar {
			background-color: {$settings['team_color_avatar_bg']};
		}

		/* Pricing Section */
		.sec-pricing {
			background-image: url( {$settings['pricing_bg_image']} );
			background-color: {$settings['pricing_color_background']};
			background-size: {$settings['pricing_bg_image_size']};
			background-repeat: {$settings['pricing_bg_image_repeat']};
			background-position: {$settings['pricing_bg_image_position']};
			color: {$settings['pricing_color_text']};
		}
		.sec-pricing .grid-overlay {
			background-color: {$settings['pricing_bg_overlay_color']};
			opacity: {$settings['pricing_bg_overlay_opacity']};
		}
		.sec-pricing .section-title, .sec-pricing a:not(.ac-btn), .sec-pricing a:not(.ac-btn):hover, .sec-pricing a:not(.ac-btn):focus, .sec-pricing a:not(.ac-btn):active {
			color: {$settings['pricing_color_heading_link']};
		}
		.sec-pricing .section-title {
			border-color: {$settings['pricing_color_heading_border']};
		}
		.sec-pricing a:not(.ac-btn):hover {
			color: {$settings['pricing_color_hover']};
		}

		/* Portfolio Section */
		.sec-portfolio {
			background-image: url( {$settings['portfolio_bg_image']} );
			background-color: {$settings['portfolio_color_background']};
			background-size: {$settings['portfolio_bg_image_size']};
			background-repeat: {$settings['portfolio_bg_image_repeat']};
			background-position: {$settings['portfolio_bg_image_position']};
			color: {$settings['portfolio_color_text']};
		}
		.sec-portfolio .grid-overlay {
			background-color: {$settings['portfolio_bg_overlay_color']};
			opacity: {$settings['portfolio_bg_overlay_opacity']};
		}
		.sec-portfolio .section-title, .sec-portfolio a:not(.ac-btn), .sec-portfolio a:not(.ac-btn):hover, .sec-portfolio a:not(.ac-btn):focus, .sec-portfolio a:not(.ac-btn):active {
			color: {$settings['portfolio_color_heading_link']};
		}
		.sec-portfolio .section-title {
			border-color: {$settings['portfolio_color_heading_border']};
		}
		.sec-portfolio a:not(.ac-btn):hover, .sec-portfolio a:not(.ac-btn):visited:hover {
			color: {$settings['portfolio_color_hover']};
		}
		.sec-portfolio-item figure figcaption {
			background-color: {$settings['portfolio_color_thumb_hover']};
		}
		.sec-portfolio-item {
			background-color: {$settings['portfolio_color_thumb_background']};
		}
		.sec-portfolio-item figure figcaption, .sec-portfolio-item .description a, .sec-portfolio-item .description a:hover, .sec-portfolio-item .description a:focus, .sec-portfolio-item .description a:active {
			color: {$settings['portfolio_color_thumb_color']};
		}

		/* Hero Section */
		.sec-hero {
			background-image: url( {$settings['hero_bg_image']} );
			background-color: {$settings['hero_color_background']};
			background-size: {$settings['hero_bg_image_size']};
			background-repeat: {$settings['hero_bg_image_repeat']};
			background-position: {$settings['hero_bg_image_position']};
			color: {$settings['hero_color_text']};
		}
		.sec-hero .sec-hero-overlay {
			background-color: {$settings['hero_bg_overlay']};
		}
		.sec-hero .sec-hs-elements .hs-primary-large, .sec-hero a:not(.ac-btn), .sec-hero a:not(.ac-btn):hover, .sec-hero a:not(.ac-btn):focus, .sec-hero a:not(.ac-btn):active {
			color: {$settings['hero_color_heading_link']};
		}
		.sec-hero a:not(.ac-btn):hover {
			color: {$settings['hero_color_hover']};
		}
		.sec-hero .sec-hero-overlay:before {
			background: -moz-linear-gradient(top, {$settings['hero_color_shadow']} 0%, rgba(0,0,0,0) 100%);
			background: -webkit-linear-gradient(top, {$settings['hero_color_shadow']} 0%, rgba(0,0,0,0) 100%);
			background: linear-gradient(to bottom, {$settings['hero_color_shadow']} 0%, rgba(0,0,0,0) 100%);
		}
		.sec-hero .sec-hs-elements .hs-primary-large, .sec-hero .sec-hs-elements .sec-hs-description, .sec-hero .sec-hs-elements .ac-btns-or {
			text-shadow: 0 1px 2px {$settings['hero_color_text_shadow']};
		}
		.sec-hero .ac-btn {
			background-color: {$settings['hero_color_btn_1_bg']};
		}
		.sec-hero .ac-btn:hover {
			background-color: {$settings['hero_color_btn_1_bg_hover']};
		}
		.sec-hero .ac-btn:focus {
			background-color: {$settings['hero_color_btn_1_bg_focus']};
		}
		.sec-hero .ac-btn.btn-opaque {
			background-color: {$settings['hero_color_btn_2_bg']};
			box-shadow: inset 0 0 0 3px {$settings['hero_color_btn_2_border']};
		}
		.sec-hero .ac-btn.btn-opaque:hover {
			background-color: {$settings['hero_color_btn_2_bg_hover']};
		}
		.sec-hero .ac-btn.btn-opaque:focus {
			background-color: {$settings['hero_color_btn_2_bg_focus']};
		}

		/* Blog Section */
		.sec-blog {
			background-image: url( {$settings['blog_bg_image']} );
			background-color: {$settings['blog_color_background']};
			background-size: {$settings['blog_bg_image_size']};
			background-repeat: {$settings['blog_bg_image_repeat']};
			background-position: {$settings['blog_bg_image_position']};
			color: {$settings['blog_color_text']};
		}
		.sec-blog .grid-overlay {
			background-color: {$settings['blog_bg_overlay_color']};
			opacity: {$settings['blog_bg_overlay_opacity']};
		}
		.sec-blog .section-title, .sec-blog a, .sec-blog a:hover, .sec-blog a:focus, .sec-blog a:active, .sec-blog a.ac-btn-alt {
			color: {$settings['blog_color_heading_link']};
		}
		.sec-blog a:hover, .sec-blog a.ac-btn-alt:hover {
			color: {$settings['blog_color_hover']};
		}
		.sec-blog .section-title {
			border-color: {$settings['blog_color_heading_border']};
		}
		.sec-blog .ac-btn-alt {
			border-color: {$settings['blog_color_rm_border']};
		}
		.sec-blog .ac-btn-alt:hover:after {
			border-color: {$settings['blog_color_rm_border_hover']};
		}

		/* Slider Section */
		.sec-slider {
			background-color: {$settings['slider_background_color']};
		}
		.sec-slider .ss-prev, .sec-slider .ss-next {
			color: {$settings['slider_arrows_color']};
			background-color: {$settings['slider_arrows_bg']};
		}
		.sec-slider .ss-prev:hover, .sec-slider .ss-next:hover {
			color: {$settings['slider_arrows_color']};
			background-color: {$settings['slider_arrows_bg_hover']};
		}
		.sec-slider .owl-dot {
			background-color: {$settings['slider_dots_bg']};
		}
		.sec-slider .owl-dot:hover {
			background-color: {$settings['slider_dots_bg_hover']};
		}
		.sec-slider .owl-dot.active {
			border-color: {$settings['slider_dots_active']};
		}

		/* Contact Section */
		.sec-contact {
			background-image: url( {$settings['contact_bg_image']} );
			background-color: {$settings['contact_color_background']};
			background-size: {$settings['contact_bg_image_size']};
			background-repeat: {$settings['contact_bg_image_repeat']};
			background-position: {$settings['contact_bg_image_position']};
		}
		.sec-contact .grid-overlay {
			background-color: {$settings['contact_bg_overlay_color']};
			opacity: {$settings['contact_bg_overlay_opacity']};
		}
		.sec-contact .section-title,
		.sec-contact h1, .sec-contact h2, .sec-contact h3, .sec-contact h4, .sec-contact h5, .sec-contact h6 {
			color: {$settings['contact_color_headings']};
		}
		.sec-contact .section-title {
			border-color: {$settings['contact_color_title_border']};
		}
		.sec-contact { color: {$settings['contact_color_font']}; }
		.sec-contact a, .sec-contact a:focus, .sec-contact a:active {
			color: {$settings['contact_color_link']};
		}
		.sec-contact a:hover{
			color: {$settings['contact_color_link_hover']};
		}
		.sec-contact .sec-contact-social a, .sec-contact .sec-contact-social a:focus, .sec-contact .sec-contact-social a:active {
			background-color: {$settings['contact_color_social_bg']};
			color: {$settings['contact_color_social']};
		}
		.sec-contact .sec-contact-social a:hover {
			color: {$settings['contact_color_social']};
			background-color: {$settings['contact_color_social_bg_hover']};
		}
		.sec-contact .ac-btn, .sec-contact input[type=submit], .sec-contact input[type=reset], .sec-contact input[type=button], .sec-contact button {
			color: {$settings['contact_color_submit']};
			background-color: {$settings['contact_color_submit_bg']};
		}
		.sec-contact .ac-btn:hover, .sec-contact input[type=submit]:hover, .sec-contact input[type=reset]:hover, .sec-contact input[type=button]:hover, .sec-contact button:hover {
			background-color: {$settings['contact_color_submit_bg_hover']};
			color: {$settings['contact_color_submit']};
		}
		.sec-contact .ac-btn:focus, .sec-contact input[type=submit]:focus, .sec-contact input[type=reset]:focus, .sec-contact input[type=button]:focus, .sec-contact button:focus, .sec-contact .ac-btn:active, .sec-contact input[type=submit]:active, .sec-contact input[type=reset]:active, .sec-contact input[type=button]:focus, .sec-contact button:active {
			background-color: {$settings['contact_color_submit_bg_active']};
			color: {$settings['contact_color_submit']};
		}

		/* Maps Section */
		.sec-maps .sec-maps-overlay {
			background-color: {$settings['maps_overlay_bg']};
			box-shadow: inset 0 0 7.222em 0.833em {$settings['maps_overlay_inner']};
		}
		.sec-maps .sec-maps-overlay:hover {
			background-color: {$settings['maps_overlay_bg_hover']};
			box-shadow: inset 0 0 7.222em 0.833em {$settings['maps_overlay_inner_hover']};
		}
		.sec-maps .smo-title, .sec-maps a:not(.smo-icon), .sec-maps a:not(.smo-icon):hover, .sec-maps a:not(.smo-icon):focus, .sec-maps a:not(.smo-icon):active {
			color: {$settings['maps_title_color']};
		}
		.sec-maps a.smo-icon {
			background-color: {$settings['maps_icon_color']};
		}

CSS;
	}
}



/*  Output inline styles
/* ------------------------------------ */
if( ! function_exists( 'businessx_extensions_final_inline_css' ) ) {
	function businessx_extensions_final_inline_css() {
		global $businessx_extensions_cs_mods;
		$css = '';

		foreach ( $businessx_extensions_cs_mods as $bcs => $bcs_value ) {
			${"$bcs"} = $bcs_value;
		}

		/*
			businessx_cd() checks if it's not a default value
			businessx_gcs() generates CSS for output
			-------
			You can find both functions in the theme: ../acosmin/customizer/customizer.php
		*/


			/* Features Section */
			if( businessx_cd( 'features_color_text', $features_color_text ) ) {
			$css .= businessx_gcs( '.sec-features', 'color', 'features_color_text' ); }

			if( businessx_cd( 'features_bg_overlay_color', $features_bg_overlay_color ) ) {
			$css .= businessx_gcs( '.sec-features .grid-overlay', 'background-color', 'features_bg_overlay_color' ); }

			if( businessx_cd( 'features_bg_overlay_opacity', $features_bg_overlay_opacity ) ) {
			$css .= businessx_gcs( '.sec-features .grid-overlay', 'opacity', 'features_bg_overlay_opacity' ); }

			if( businessx_cd( 'features_color_heading_link', $features_color_heading_link ) ) {
			$css .= businessx_gcs( '.sec-features .section-title, .sec-features h3, .sec-features a, .sec-feature .ac-btn-alt, .sec-feature .ac-btn-alt:hover, .sec-feature .ac-btn-alt:focus, .sec-feature .ac-btn-alt:active', 'color', 'features_color_heading_link' ); }

			if( businessx_cd( 'features_color_heading_border', $features_color_heading_border ) ) {
			$css .= businessx_gcs( '.sec-features .section-title', 'border-color', 'features_color_heading_border' ); }

			if( businessx_cd( 'features_color_background', $features_color_background ) ) {
			$css .= businessx_gcs( '.sec-features', 'background-color', 'features_color_background' ); }

			if( businessx_cd( 'features_color_hover', $features_color_hover ) ) {
			$css .= businessx_gcs( '.sec-features a:hover', 'color', 'features_color_hover' );
			$css .= businessx_gcs( '.sec-features a.ac-btn-alt:hover:after, .sec-feature a.ac-btn-alt:focus:after, .sec-feature a.ac-btn-alt:active:after', 'border-color', 'features_color_hover', '', ' !important' ); }


			if( businessx_cd( 'features_bg_image', $features_bg_image ) ) {
			$css .= businessx_gcs( '.sec-features', 'background-image', 'features_bg_image', 'url(', ')' ); }

			if( businessx_cd( 'features_bg_image_size', $features_bg_image_size ) ) {
			$css .= businessx_gcs( '.sec-features', 'background-size', 'features_bg_image_size' ); }

			if( businessx_cd( 'features_bg_image_repeat', $features_bg_image_repeat ) ) {
			$css .= businessx_gcs( '.sec-features', 'background-repeat', 'features_bg_image_repeat' ); }

			if( businessx_cd( 'features_bg_image_position', $features_bg_image_position ) ) {
			$css .= businessx_gcs( '.sec-features', 'background-position', 'features_bg_image_position' ); }


			/* FAQ Section */
			if( businessx_cd( 'faq_color_text', $faq_color_text ) ) {
			$css .= businessx_gcs( '.sec-faq', 'color', 'faq_color_text' ); }

			if( businessx_cd( 'faq_bg_overlay_color', $faq_bg_overlay_color ) ) {
			$css .= businessx_gcs( '.sec-faq .grid-overlay', 'background-color', 'faq_bg_overlay_color' ); }

			if( businessx_cd( 'faq_bg_overlay_opacity', $faq_bg_overlay_opacity ) ) {
			$css .= businessx_gcs( '.sec-faq .grid-overlay', 'opacity', 'faq_bg_overlay_opacity' ); }

			if( businessx_cd( 'faq_color_headings', $faq_color_headings ) ) {
			$css .= businessx_gcs( '.sec-faq .section-title, .sec-faq .hs-secondary-small', 'color', 'faq_color_headings' ); }

			if( businessx_cd( 'faq_color_heading_border', $faq_color_heading_border ) ) {
			$css .= businessx_gcs( '.sec-faq .section-title', 'border-color', 'faq_color_heading_border' ); }

			if( businessx_cd( 'faq_color_heading_small_border', $faq_color_heading_small_border ) ) {
			$css .= businessx_gcs( '.sec-faq .hs-secondary-small', 'border-color', 'faq_color_heading_small_border' ); }

			if( businessx_cd( 'faq_color_background', $faq_color_background ) ) {
			$css .= businessx_gcs( '.sec-faq', 'background-color', 'faq_color_background' ); }

			if( businessx_cd( 'faq_color_link', $faq_color_link ) ) {
			$css .= businessx_gcs( '.sec-faq a', 'color', 'faq_color_link' ); }

			if( businessx_cd( 'faq_color_hover', $faq_color_hover ) ) {
			$css .= businessx_gcs( '.sec-faq a:hover', 'color', 'faq_color_hover' ); }

			if( businessx_cd( 'faq_bg_image', $faq_bg_image ) ) {
			$css .= businessx_gcs( '.sec-faq', 'background-image', 'faq_bg_image', 'url(', ')' ); }

			if( businessx_cd( 'faq_bg_image_size', $faq_bg_image_size ) ) {
			$css .= businessx_gcs( '.sec-faq', 'background-size', 'faq_bg_image_size' ); }

			if( businessx_cd( 'faq_bg_image_repeat', $faq_bg_image_repeat ) ) {
			$css .= businessx_gcs( '.sec-faq', 'background-repeat', 'faq_bg_image_repeat' ); }

			if( businessx_cd( 'faq_bg_image_position', $faq_bg_image_position ) ) {
			$css .= businessx_gcs( '.sec-faq', 'background-position', 'faq_bg_image_position' ); }


			/* Clients Section */
			if( businessx_cd( 'clients_color_heading', $clients_color_heading ) ) {
			$css .= businessx_gcs( '.sec-clients .section-title', 'color', 'clients_color_heading' ); }

			if( businessx_cd( 'clients_color_heading_border', $clients_color_heading_border ) ) {
			$css .= businessx_gcs( '.sec-clients .section-title', 'border-color', 'clients_color_heading_border' ); }

			if( businessx_cd( 'clients_color_background', $clients_color_background ) ) {
			$css .= businessx_gcs( '.sec-clients', 'background-color', 'clients_color_background' ); }

			if( businessx_cd( 'clients_color_text', $clients_color_text ) ) {
			$css .= businessx_gcs( '.sec-clients', 'color', 'clients_color_text' ); }

			if( businessx_cd( 'clients_color_borders', $clients_color_borders ) ) {
			$css .= businessx_gcs( '.sec-clients .owl-stage-outer, .sec-clients .owl-item, .sec-clients-nav-btns', 'border-color', 'clients_color_borders' ); }

			if( businessx_cd( 'clients_color_wrapper_bg', $clients_color_wrapper_bg ) ) {
			$css .= businessx_gcs( '.sec-clients .owl-stage-outer', 'background-color', 'clients_color_wrapper_bg' ); }

			if( businessx_cd( 'clients_color_nav_bg', $clients_color_nav_bg ) ) {
			$css .= businessx_gcs( '.sec-clients-nav-btns', 'background-color', 'clients_color_nav_bg' ); }

			if( businessx_cd( 'clients_color_nav_btns', $clients_color_nav_btns ) ) {
			$css .= businessx_gcs(
				'.sec-clients-nav-btn-prev, .sec-clients-nav-btn-next,
				.sec-clients-nav-btn-prev:hover, .sec-clients-nav-btn-next:hover,
				.sec-clients-nav-btn-prev:focus, .sec-clients-nav-btn-next:focus,
				.sec-clients-nav-btn-prev:active, .sec-clients-nav-btn-next:active',
				'color', 'clients_color_nav_btns' ); }

			if( businessx_cd( 'clients_bg_image', $clients_bg_image ) ) {
			$css .= businessx_gcs( '.sec-clients', 'background-image', 'clients_bg_image', 'url(', ')' ); }

			if( businessx_cd( 'clients_bg_image_size', $clients_bg_image_size ) ) {
			$css .= businessx_gcs( '.sec-clients', 'background-size', 'clients_bg_image_size' ); }

			if( businessx_cd( 'clients_bg_image_repeat', $clients_bg_image_repeat ) ) {
			$css .= businessx_gcs( '.sec-clients', 'background-repeat', 'clients_bg_image_repeat' ); }

			if( businessx_cd( 'clients_bg_image_position', $clients_bg_image_position ) ) {
			$css .= businessx_gcs( '.sec-clients', 'background-position', 'clients_bg_image_position' ); }

			if( businessx_cd( 'clients_bg_overlay_color', $clients_bg_overlay_color ) ) {
			$css .= businessx_gcs( '.sec-clients .grid-overlay', 'background-color', 'clients_bg_overlay_color' ); }

			if( businessx_cd( 'clients_bg_overlay_opacity', $clients_bg_overlay_opacity ) ) {
			$css .= businessx_gcs( '.sec-clients .grid-overlay', 'opacity', 'clients_bg_overlay_opacity' ); }


			/* About Us Section */
			if( businessx_cd( 'about_color_background', $about_color_background ) ) {
			$css .= businessx_gcs( '.sec-about', 'background-color', 'about_color_background' ); }

			if( businessx_cd( 'about_color_text', $about_color_text ) ) {
			$css .= businessx_gcs( '.sec-about', 'color', 'about_color_text' ); }

			if( businessx_cd( 'about_color_heading_link', $about_color_heading_link ) ) {
			$css .= businessx_gcs( '.sec-about .section-title, .sec-about-box h3, .sec-about-box a, .sec-about-box a:hover, .sec-about-box a:focus, .sec-about-box a:active', 'color', 'about_color_heading_link' ); }

			if( businessx_cd( 'about_color_heading_border', $about_color_heading_border ) ) {
			$css .= businessx_gcs( '.sec-about .section-title, .sec-about-box:after', 'border-color', 'about_color_heading_border' ); }

			if( businessx_cd( 'about_color_btn', $about_color_btn ) ) {

			$css .= businessx_gcs( '.sec-about .about-button .ac-btn.btn-opaque', 'background-color', 'about_color_btn' ); }

			if( businessx_cd( 'about_color_btn_2nd', $about_color_btn_2nd ) ) {
			$css .= businessx_gcs( '.sec-about .about-button .ac-btn.btn-opaque', 'box-shadow', 'about_color_btn_2nd', 'inset 0 0 0 3px ' );
			$css .= businessx_gcs( '.sec-about .about-button .ac-btn.btn-opaque:hover', 'background-color', 'about_color_btn_2nd' ); }

			if( businessx_cd( 'about_bg_image', $about_bg_image ) ) {
			$css .= businessx_gcs( '.sec-about', 'background-image', 'about_bg_image', 'url(', ')' ); }

			if( businessx_cd( 'about_bg_image_size', $about_bg_image_size ) ) {
			$css .= businessx_gcs( '.sec-about', 'background-size', 'about_bg_image_size' ); }

			if( businessx_cd( 'about_bg_image_repeat', $about_bg_image_repeat ) ) {
			$css .= businessx_gcs( '.sec-about', 'background-repeat', 'about_bg_image_repeat' ); }

			if( businessx_cd( 'about_bg_image_position', $about_bg_image_position ) ) {
			$css .= businessx_gcs( '.sec-about', 'background-position', 'about_bg_image_position' ); }

			if( businessx_cd( 'about_bg_overlay_color', $about_bg_overlay_color ) ) {
			$css .= businessx_gcs( '.sec-about .grid-overlay', 'background-color', 'about_bg_overlay_color' ); }

			if( businessx_cd( 'about_bg_overlay_opacity', $about_bg_overlay_opacity ) ) {
			$css .= businessx_gcs( '.sec-about .grid-overlay', 'opacity', 'about_bg_overlay_opacity' ); }


			/* Testimonials Section */
			if( businessx_cd( 'testimonials_color_background', $testimonials_color_background ) ) {
			$css .= businessx_gcs( '.sec-testimonials', 'background-color', 'testimonials_color_background' ); }

			if( businessx_cd( 'testimonials_bg_image', $testimonials_bg_image ) ) {
			$css .= businessx_gcs( '.sec-testimonials', 'background-image', 'testimonials_bg_image', 'url(', ')' ); }

			if( businessx_cd( 'testimonials_bg_image_size', $testimonials_bg_image_size ) ) {
			$css .= businessx_gcs( '.sec-testimonials', 'background-size', 'testimonials_bg_image_size' ); }

			if( businessx_cd( 'testimonials_bg_image_repeat', $testimonials_bg_image_repeat ) ) {
			$css .= businessx_gcs( '.sec-testimonials', 'background-repeat', 'testimonials_bg_image_repeat' ); }

			if( businessx_cd( 'testimonials_bg_image_position', $testimonials_bg_image_position ) ) {
			$css .= businessx_gcs( '.sec-testimonials', 'background-position', 'testimonials_bg_image_position' ); }

			if( businessx_cd( 'testimonials_bg_overlay_color', $testimonials_bg_overlay_color ) ) {
			$css .= businessx_gcs( '.sec-testimonials .grid-overlay', 'background-color', 'testimonials_bg_overlay_color' ); }

			if( businessx_cd( 'testimonials_bg_overlay_opacity', $testimonials_bg_overlay_opacity ) ) {
			$css .= businessx_gcs( '.sec-testimonials .grid-overlay', 'opacity', 'testimonials_bg_overlay_opacity' ); }

			if( businessx_cd( 'testimonials_color_text', $testimonials_color_text ) ) {
			$css .= businessx_gcs( '.sec-testimonials', 'color', 'testimonials_color_text' ); }

			if( businessx_cd( 'testimonials_color_heading_border', $testimonials_color_heading_border ) ) {
			$css .= businessx_gcs( '.sec-testimonials .section-title', 'border-color', 'testimonials_color_heading_border' ); }

			if( businessx_cd( 'testimonials_color_headings', $testimonials_color_headings ) ) {
			$css .= businessx_gcs( '.sec-testimonials .section-title, .sec-testimonials h3', 'color', 'testimonials_color_headings' ); }

			if( businessx_cd( 'testimonials_color_item_bg', $testimonials_color_item_bg ) ) {
			$css .= businessx_gcs( '.sec-testimonials .owl-item', 'background', 'testimonials_color_item_bg', 'radial-gradient(2.222em 2.222em at 50% -0.556em, rgba(0, 0, 0, 0) 2.194em, ', ' 2.250em)' ); }

			if( businessx_cd( 'testimonials_color_avatar_bg', $testimonials_color_avatar_bg ) ) {
			$css .= businessx_gcs( '.sec-testimonials .client-avatar', 'background-color', 'testimonials_color_avatar_bg' ); }

			if( businessx_cd( 'testimonials_color_button_bg', $testimonials_color_button_bg ) ) {
			$css .= businessx_gcs( '.sec-testimonials .testimonial-button .ac-btn', 'background-color', 'testimonials_color_button_bg' ); }

			if( businessx_cd( 'testimonials_color_button_bg_hover', $testimonials_color_button_bg_hover ) ) {
			$css .= businessx_gcs( '.sec-testimonials .testimonial-button .ac-btn:hover', 'background-color', 'testimonials_color_button_bg_hover' ); }

			if( businessx_cd( 'testimonials_color_button_bg_active', $testimonials_color_button_bg_active ) ) {
			$css .= businessx_gcs( '.sec-testimonials .testimonial-button .ac-btn:active', 'background-color', 'testimonials_color_button_bg_active' ); }

			if( businessx_cd( 'testimonials_color_nav_bg', $testimonials_color_nav_bg ) ) {
			$css .= businessx_gcs( '.sec-testimonials-nav-btns', 'background-color', 'testimonials_color_nav_bg' ); }

			if( businessx_cd( 'testimonials_color_nav_border', $testimonials_color_nav_border ) ) {
			$css .= businessx_gcs( '.sec-testimonials-nav-btns', 'border-color', 'testimonials_color_nav_border' ); }

			if( businessx_cd( 'testimonials_color_nav_btns', $testimonials_color_nav_btns ) ) {
			$css .= businessx_gcs(
				'.sec-testimonials-nav-btn-prev, .sec-testimonials-nav-btn-next,
				.sec-testimonials-nav-btn-prev:hover, .sec-testimonials-nav-btn-next:hover,
				.sec-testimonials-nav-btn-prev:focus, .sec-testimonials-nav-btn-next:focus,
				.sec-testimonials-nav-btn-prev:active, .sec-testimonials-nav-btn-next:active',
				'color', 'testimonials_color_nav_btns' ); }


			/* Team Section */
			if( businessx_cd( 'team_color_background', $team_color_background ) ) {
			$css .= businessx_gcs( '.sec-team', 'background-color', 'team_color_background' ); }

			if( businessx_cd( 'team_bg_image', $team_bg_image ) ) {
			$css .= businessx_gcs( '.sec-team', 'background-image', 'team_bg_image', 'url(', ')' ); }

			if( businessx_cd( 'team_bg_image_size', $team_bg_image_size ) ) {
			$css .= businessx_gcs( '.sec-team', 'background-size', 'team_bg_image_size' ); }

			if( businessx_cd( 'team_bg_image_repeat', $team_bg_image_repeat ) ) {
			$css .= businessx_gcs( '.sec-team', 'background-repeat', 'team_bg_image_repeat' ); }

			if( businessx_cd( 'team_bg_image_position', $team_bg_image_position ) ) {
			$css .= businessx_gcs( '.sec-team', 'background-position', 'team_bg_image_position' ); }

			if( businessx_cd( 'team_bg_overlay_color', $team_bg_overlay_color ) ) {
			$css .= businessx_gcs( '.sec-team .grid-overlay', 'background-color', 'team_bg_overlay_color' ); }

			if( businessx_cd( 'team_bg_overlay_opacity', $team_bg_overlay_opacity ) ) {
			$css .= businessx_gcs( '.sec-team .grid-overlay', 'opacity', 'team_bg_overlay_opacity' ); }

			if( businessx_cd( 'team_color_text', $team_color_text ) ) {
			$css .= businessx_gcs( '.sec-team', 'color', 'team_color_text' ); }

			if( businessx_cd( 'team_color_heading_link', $team_color_heading_link ) ) {
			$css .= businessx_gcs( '.sec-team .section-title, .sec-team-member h3, .sec-team-member h4, .sec-team a, .sec-team a:focus, .sec-team a:active', 'color', 'team_color_heading_link' ); }

			if( businessx_cd( 'team_color_heading_border', $team_color_heading_border ) ) {
			$css .= businessx_gcs( '.sec-team .section-title, .sec-team-member h4.hb-bottom-abs-small:after', 'border-color', 'team_color_heading_border' ); }

			if( businessx_cd( 'team_color_hover', $team_color_hover ) ) {
			$css .= businessx_gcs( '.sec-team a:hover', 'color', 'team_color_hover' ); }

			if( businessx_cd( 'team_color_avatar_bg', $team_color_avatar_bg ) ) {
			$css .= businessx_gcs( '.sec-team .sec-team-member-avatar', 'background-color', 'team_color_avatar_bg' ); }


			/* Pricing Section */
			if( businessx_cd( 'pricing_color_background', $pricing_color_background ) ) {
			$css .= businessx_gcs( '.sec-pricing', 'background-color', 'pricing_color_background' ); }

			if( businessx_cd( 'pricing_bg_image', $pricing_bg_image ) ) {
			$css .= businessx_gcs( '.sec-pricing', 'background-image', 'pricing_bg_image', 'url(', ')' ); }

			if( businessx_cd( 'pricing_bg_image_size', $pricing_bg_image_size ) ) {
			$css .= businessx_gcs( '.sec-pricing', 'background-size', 'pricing_bg_image_size' ); }

			if( businessx_cd( 'pricing_bg_image_repeat', $pricing_bg_image_repeat ) ) {
			$css .= businessx_gcs( '.sec-pricing', 'background-repeat', 'pricing_bg_image_repeat' ); }

			if( businessx_cd( 'pricing_bg_image_position', $pricing_bg_image_position ) ) {
			$css .= businessx_gcs( '.sec-pricing', 'background-position', 'pricing_bg_image_position' ); }

			if( businessx_cd( 'pricing_bg_overlay_color', $pricing_bg_overlay_color ) ) {
			$css .= businessx_gcs( '.sec-pricing .grid-overlay', 'background-color', 'pricing_bg_overlay_color' ); }

			if( businessx_cd( 'pricing_bg_overlay_opacity', $pricing_bg_overlay_opacity ) ) {
			$css .= businessx_gcs( '.sec-pricing .grid-overlay', 'opacity', 'pricing_bg_overlay_opacity' ); }

			if( businessx_cd( 'pricing_color_text', $pricing_color_text ) ) {
			$css .= businessx_gcs( '.sec-pricing', 'color', 'pricing_color_text' ); }

			if( businessx_cd( 'pricing_color_heading_link', $pricing_color_heading_link ) ) {
			$css .= businessx_gcs( '.sec-pricing .section-title, .sec-pricing a:not(.ac-btn), .sec-pricing a:not(.ac-btn):hover, .sec-pricing a:not(.ac-btn):focus, .sec-pricing a:not(.ac-btn):active', 'color', 'pricing_color_heading_link' ); }

			if( businessx_cd( 'pricing_color_heading_border', $pricing_color_heading_border ) ) {
			$css .= businessx_gcs( '.sec-pricing .section-title', 'border-color', 'pricing_color_heading_border' ); }

			if( businessx_cd( 'pricing_color_hover', $pricing_color_hover ) ) {
			$css .= businessx_gcs( '.sec-pricing a:not(.ac-btn):hover', 'color', 'pricing_color_hover' ); }


			/* Portfolio Section */
			if( businessx_cd( 'portfolio_color_background', $portfolio_color_background ) ) {
			$css .= businessx_gcs( '.sec-portfolio', 'background-color', 'portfolio_color_background' ); }

			if( businessx_cd( 'portfolio_bg_image', $portfolio_bg_image ) ) {
			$css .= businessx_gcs( '.sec-portfolio', 'background-image', 'portfolio_bg_image', 'url(', ')' ); }

			if( businessx_cd( 'portfolio_bg_image_size', $portfolio_bg_image_size ) ) {
			$css .= businessx_gcs( '.sec-portfolio', 'background-size', 'portfolio_bg_image_size' ); }

			if( businessx_cd( 'portfolio_bg_image_repeat', $portfolio_bg_image_repeat ) ) {
			$css .= businessx_gcs( '.sec-portfolio', 'background-repeat', 'portfolio_bg_image_repeat' ); }

			if( businessx_cd( 'portfolio_bg_image_position', $portfolio_bg_image_position ) ) {
			$css .= businessx_gcs( '.sec-portfolio', 'background-position', 'portfolio_bg_image_position' ); }

			if( businessx_cd( 'portfolio_bg_overlay_color', $portfolio_bg_overlay_color ) ) {
			$css .= businessx_gcs( '.sec-portfolio .grid-overlay', 'background-color', 'portfolio_bg_overlay_color' ); }

			if( businessx_cd( 'portfolio_bg_overlay_opacity', $portfolio_bg_overlay_opacity ) ) {
			$css .= businessx_gcs( '.sec-portfolio .grid-overlay', 'opacity', 'portfolio_bg_overlay_opacity' ); }

			if( businessx_cd( 'portfolio_color_text', $portfolio_color_text ) ) {
			$css .= businessx_gcs( '.sec-portfolio', 'color', 'portfolio_color_text' ); }

			if( businessx_cd( 'portfolio_color_heading_link', $portfolio_color_heading_link ) ) {
			$css .= businessx_gcs( '.sec-portfolio .section-title, .sec-portfolio a:not(.ac-btn), .sec-portfolio a:not(.ac-btn):hover, .sec-portfolio a:not(.ac-btn):focus, .sec-portfolio a:not(.ac-btn):active', 'color', 'portfolio_color_heading_link' ); }

			if( businessx_cd( 'portfolio_color_heading_border', $portfolio_color_heading_border ) ) {
			$css .= businessx_gcs( '.sec-portfolio .section-title', 'border-color', 'portfolio_color_heading_border' ); }

			if( businessx_cd( 'portfolio_color_hover', $portfolio_color_hover ) ) {
			$css .= businessx_gcs( '.sec-portfolio a:not(.ac-btn):hover, .sec-portfolio a:not(.ac-btn):visited:hover', 'color', 'portfolio_color_hover' ); }

			if( businessx_cd( 'portfolio_color_thumb_hover', $portfolio_color_thumb_hover ) ) {
			$css .= businessx_gcs( '.sec-portfolio-item figure figcaption', 'background-color', 'portfolio_color_thumb_hover' ); }

			if( businessx_cd( 'portfolio_color_thumb_background', $portfolio_color_thumb_background ) ) {
			$css .= businessx_gcs( '.sec-portfolio-item', 'background-color', 'portfolio_color_thumb_background' ); }

			if( businessx_cd( 'portfolio_color_thumb_color', $portfolio_color_thumb_color ) ) {
			$css .= businessx_gcs(
				'.sec-portfolio-item figure figcaption, .sec-portfolio-item .description a, .sec-portfolio-item .description a:hover, .sec-portfolio-item .description a:focus, .sec-portfolio-item .description a:active', 'color', 'portfolio_color_thumb_color' ); }


			/* Hero Section */
			if( businessx_cd( 'hero_color_background', $hero_color_background ) ) {
			$css .= businessx_gcs( '.sec-hero', 'background-color', 'hero_color_background' ); }

			if( businessx_cd( 'hero_bg_image', $hero_bg_image ) ) {
			$css .= businessx_gcs( '.sec-hero', 'background-image', 'hero_bg_image', 'url(', ')' ); }

			if( businessx_cd( 'hero_bg_image_size', $hero_bg_image_size ) ) {
			$css .= businessx_gcs( '.sec-hero', 'background-size', 'hero_bg_image_size' ); }

			if( businessx_cd( 'hero_bg_image_repeat', $hero_bg_image_repeat ) ) {
			$css .= businessx_gcs( '.sec-hero', 'background-repeat', 'hero_bg_image_repeat' ); }

			if( businessx_cd( 'hero_bg_image_position', $hero_bg_image_position ) ) {
			$css .= businessx_gcs( '.sec-hero', 'background-position', 'hero_bg_image_position' ); }

			if( businessx_cd( 'hero_bg_overlay', $hero_bg_overlay ) ) {
			$css .= businessx_gcs( '.sec-hero .sec-hero-overlay', 'background-color', 'hero_bg_overlay' ); }

			if( businessx_cd( 'hero_color_text', $hero_color_text ) ) {
			$css .= businessx_gcs( '.sec-hero', 'color', 'hero_color_text' ); }

			if( businessx_cd( 'hero_color_heading_link', $hero_color_heading_link ) ) {
			$css .= businessx_gcs( '.sec-hero .sec-hs-elements .hs-primary-large, .sec-hero a:not(.ac-btn), .sec-hero a:not(.ac-btn):hover, .sec-hero a:not(.ac-btn):focus, .sec-hero a:not(.ac-btn):active', 'color', 'hero_color_heading_link' ); }

			if( businessx_cd( 'hero_color_hover', $hero_color_hover ) ) {
			$css .= businessx_gcs( '.sec-hero a:not(.ac-btn):hover', 'color', 'hero_color_hover' ); }

			if( businessx_cd( 'hero_color_shadow', $hero_color_shadow ) ) {
			$css .= businessx_gcs( '.sec-hero .sec-hero-overlay:before', 'background', 'hero_color_shadow', '-moz-linear-gradient(top, ', ' 0%, rgba(0,0,0,0) 100%)');
			$css .= businessx_gcs( '.sec-hero .sec-hero-overlay:before', 'background', 'hero_color_shadow', '-webkit-linear-gradient(top, ', ' 0%, rgba(0,0,0,0) 100%)');
			$css .= businessx_gcs( '.sec-hero .sec-hero-overlay:before', 'background', 'hero_color_shadow', 'linear-gradient(top, ', ' 0%, rgba(0,0,0,0) 100%)'); }

			if( businessx_cd( 'hero_color_text_shadow', $hero_color_text_shadow ) ) {
			$css .= businessx_gcs( '.sec-hero .sec-hs-elements .hs-primary-large, .sec-hero .sec-hs-elements .sec-hs-description, .sec-hero .sec-hs-elements .ac-btns-or', 'text-shadow', 'hero_color_text_shadow', '0 1px 2px ' ); }

			if( businessx_cd( 'hero_color_btn_1_bg', $hero_color_btn_1_bg ) ) {
			$css .= businessx_gcs( '.sec-hero .ac-btn', 'background-color', 'hero_color_btn_1_bg' ); }

			if( businessx_cd( 'hero_color_btn_1_bg_hover', $hero_color_btn_1_bg_hover ) ) {
			$css .= businessx_gcs( '.sec-hero .ac-btn:hover', 'background-color', 'hero_color_btn_1_bg_hover' ); }

			if( businessx_cd( 'hero_color_btn_1_bg_focus', $hero_color_btn_1_bg_focus ) ) {
			$css .= businessx_gcs( '.sec-hero .ac-btn:focus', 'background-color', 'hero_color_btn_1_bg_focus' ); }

			if( businessx_cd( 'hero_color_btn_2_bg', $hero_color_btn_2_bg ) ) {
			$css .= businessx_gcs( '.sec-hero .ac-btn.btn-opaque', 'background-color', 'hero_color_btn_2_bg' ); }

			if( businessx_cd( 'hero_color_btn_2_border', $hero_color_btn_2_border ) ) {
			$css .= businessx_gcs( '.sec-hero .ac-btn.btn-opaque', 'box-shadow', 'hero_color_btn_2_border', 'inset 0 0 0 3px ' ); }

			if( businessx_cd( 'hero_color_btn_2_bg_hover', $hero_color_btn_2_bg_hover ) ) {
			$css .= businessx_gcs( '.sec-hero .ac-btn.btn-opaque:hover', 'background-color', 'hero_color_btn_2_bg_hover' ); }

			if( businessx_cd( 'hero_color_btn_2_bg_focus', $hero_color_btn_2_bg_focus ) ) {
			$css .= businessx_gcs( '.sec-hero .ac-btn.btn-opaque:focus', 'background-color', 'hero_color_btn_2_bg_focus' ); }


			/* Blog Section */
			if( businessx_cd( 'blog_color_background', $blog_color_background ) ) {
			$css .= businessx_gcs( '.sec-blog', 'background-color', 'blog_color_background' ); }

			if( businessx_cd( 'blog_bg_image', $blog_bg_image ) ) {
			$css .= businessx_gcs( '.sec-blog', 'background-image', 'blog_bg_image', 'url(', ')' ); }

			if( businessx_cd( 'blog_bg_image_size', $blog_bg_image_size ) ) {
			$css .= businessx_gcs( '.sec-blog', 'background-size', 'blog_bg_image_size' ); }

			if( businessx_cd( 'blog_bg_image_repeat', $blog_bg_image_repeat ) ) {
			$css .= businessx_gcs( '.sec-blog', 'background-repeat', 'blog_bg_image_repeat' ); }

			if( businessx_cd( 'blog_bg_image_position', $blog_bg_image_position ) ) {
			$css .= businessx_gcs( '.sec-blog', 'background-position', 'blog_bg_image_position' ); }

			if( businessx_cd( 'blog_bg_overlay_color', $blog_bg_overlay_color ) ) {
			$css .= businessx_gcs( '.sec-blog .grid-overlay', 'background-color', 'blog_bg_overlay_color' ); }

			if( businessx_cd( 'blog_bg_overlay_opacity', $blog_bg_overlay_opacity ) ) {
			$css .= businessx_gcs( '.sec-blog .grid-overlay', 'opacity', 'blog_bg_overlay_opacity' ); }

			if( businessx_cd( 'blog_color_text', $blog_color_text ) ) {
			$css .= businessx_gcs( '.sec-blog', 'color', 'blog_color_text' ); }

			if( businessx_cd( 'blog_color_heading_link', $blog_color_heading_link ) ) {
			$css .= businessx_gcs( '.sec-blog .section-title, .sec-blog a, .sec-blog a:hover, .sec-blog a:focus, .sec-blog a:active, .sec-blog a.ac-btn-alt', 'color', 'blog_color_heading_link' ); }

			if( businessx_cd( 'blog_color_hover', $blog_color_hover ) ) {
			$css .= businessx_gcs( '.sec-blog a:hover, .sec-blog a.ac-btn-alt:hover', 'color', 'blog_color_hover' ); }

			if( businessx_cd( 'blog_color_heading_border', $blog_color_heading_border ) ) {
			$css .= businessx_gcs( '.sec-blog .section-title', 'border-color', 'blog_color_heading_border' ); }

			if( businessx_cd( 'blog_color_rm_border', $blog_color_rm_border ) ) {
			$css .= businessx_gcs( '.sec-blog .ac-btn-alt', 'border-color', 'blog_color_rm_border' ); }

			if( businessx_cd( 'blog_color_rm_border_hover', $blog_color_rm_border_hover ) ) {
			$css .= businessx_gcs( '.sec-blog .ac-btn-alt:hover:after', 'border-color', 'blog_color_rm_border_hover' ); }


			/* Slider Section */
			if( businessx_cd( 'slider_background_color', $slider_background_color ) ) {
			$css .= businessx_gcs( '.sec-slider', 'background-color', 'slider_background_color' ); }

			if( businessx_cd( 'slider_arrows_color', $slider_arrows_color ) ) {
			$css .= businessx_gcs( '.sec-slider .ss-prev, .sec-slider .ss-next', 'color', 'slider_arrows_color' ); }

			if( businessx_cd( 'slider_arrows_bg', $slider_arrows_bg ) ) {
			$css .= businessx_gcs( '.sec-slider .ss-prev, .sec-slider .ss-next', 'background-color', 'slider_arrows_bg' ); }

			if( businessx_cd( 'slider_arrows_color', $slider_arrows_color ) ) {
			$css .= businessx_gcs( '.sec-slider .ss-prev:hover, .sec-slider .ss-next:hover', 'color', 'slider_arrows_color' ); }

			if( businessx_cd( 'slider_arrows_bg_hover', $slider_arrows_bg_hover ) ) {
			$css .= businessx_gcs( '.sec-slider .ss-prev:hover, .sec-slider .ss-next:hover', 'background-color', 'slider_arrows_bg_hover' ); }

			if( businessx_cd( 'slider_dots_bg', $slider_dots_bg ) ) {
			$css .= businessx_gcs( '.sec-slider .owl-dot', 'background-color', 'slider_dots_bg' ); }

			if( businessx_cd( 'slider_dots_bg_hover', $slider_dots_bg_hover ) ) {
			$css .= businessx_gcs( '.sec-slider .owl-dot:hover', 'background-color', 'slider_dots_bg_hover' ); }

			if( businessx_cd( 'slider_dots_active', $slider_dots_active ) ) {
			$css .= businessx_gcs( '.sec-slider .owl-dot.active', 'border-color', 'slider_dots_active' ); }

			/* Contact Section */
			if( businessx_cd( 'contact_color_background', $contact_color_background ) ) {
			$css .= businessx_gcs( '.sec-contact', 'background-color', 'contact_color_background' ); }

			if( businessx_cd( 'contact_color_font', $contact_color_font ) ) {
			$css .= businessx_gcs( '.sec-contact', 'color', 'contact_color_font' ); }

			if( businessx_cd( 'contact_color_link', $contact_color_link ) ) {
			$css .= businessx_gcs( '.sec-contact a, .sec-contact a:focus, .sec-contact a:active', 'color', 'contact_color_link' ); }

			if( businessx_cd( 'contact_color_link_hover', $contact_color_link_hover ) ) {
			$css .= businessx_gcs( '.sec-contact a:hover', 'color', 'contact_color_link_hover' ); }

			if( businessx_cd( 'contact_color_headings', $contact_color_headings ) ) {
			$css .= businessx_gcs( '.sec-contact .section-title, .sec-contact h1, .sec-contact h2, .sec-contact h3, .sec-contact h4, .sec-contact h5, .sec-contact h6', 'color', 'contact_color_headings' ); }

			if( businessx_cd( 'contact_color_title_border', $contact_color_title_border ) ) {
			$css .= businessx_gcs( '.sec-contact .section-title', 'border-color', 'contact_color_title_border' ); }

			if( businessx_cd( 'contact_color_social', $contact_color_social ) ) {
			$css .= businessx_gcs( '.sec-contact .sec-contact-social a, .sec-contact .sec-contact-social a:focus, .sec-contact .sec-contact-social a:active, .sec-contact .sec-contact-social a:hover', 'color', 'contact_color_social' ); }

			if( businessx_cd( 'contact_color_social_bg', $contact_color_social_bg ) ) {
			$css .= businessx_gcs( '.sec-contact .sec-contact-social a, .sec-contact .sec-contact-social a:focus, .sec-contact .sec-contact-social a:active', 'background-color', 'contact_color_social_bg' ); }

			if( businessx_cd( 'contact_color_social_bg_hover', $contact_color_social_bg_hover ) ) {
			$css .= businessx_gcs( '.sec-contact .sec-contact-social a:hover', 'background-color', 'contact_color_social_bg_hover' ); }

			if( businessx_cd( 'contact_bg_image', $contact_bg_image ) ) {
			$css .= businessx_gcs( '.sec-contact', 'background-image', 'contact_bg_image', 'url(', ')' ); }

			if( businessx_cd( 'contact_bg_image_size', $contact_bg_image_size ) ) {
			$css .= businessx_gcs( '.sec-contact', 'background-size', 'contact_bg_image_size' ); }

			if( businessx_cd( 'contact_bg_image_repeat', $contact_bg_image_repeat ) ) {
			$css .= businessx_gcs( '.sec-contact', 'background-repeat', 'contact_bg_image_repeat' ); }

			if( businessx_cd( 'contact_bg_image_position', $contact_bg_image_position ) ) {
			$css .= businessx_gcs( '.sec-contact', 'background-position', 'contact_bg_image_position' ); }

			if( businessx_cd( 'contact_bg_overlay_color', $contact_bg_overlay_color ) ) {
			$css .= businessx_gcs( '.sec-contact .grid-overlay', 'background-color', 'contact_bg_overlay_color' ); }

			if( businessx_cd( 'contact_bg_overlay_opacity', $contact_bg_overlay_opacity ) ) {
			$css .= businessx_gcs( '.sec-contact .grid-overlay', 'opacity', 'contact_bg_overlay_opacity' ); }

			if( businessx_cd( 'contact_color_submit', $contact_color_submit ) ) {
			$css .= businessx_gcs( '.sec-contact .ac-btn, .sec-contact input[type=submit], .sec-contact input[type=reset], .sec-contact input[type=button], .sec-contact button, .sec-contact .ac-btn:hover, .sec-contact input[type=submit]:hover, .sec-contact input[type=reset]:hover, .sec-contact input[type=button]:hover, .sec-contact button:hover, .sec-contact .ac-btn:focus, .sec-contact input[type=submit]:focus, .sec-contact input[type=reset]:focus, .sec-contact input[type=button]:focus, .sec-contact button:focus, .sec-contact .ac-btn:active, .sec-contact input[type=submit]:active, .sec-contact input[type=reset]:active, .sec-contact input[type=button]:focus, .sec-contact button:active', 'color', 'contact_color_submit' ); }

			if( businessx_cd( 'contact_color_submit_bg', $contact_color_submit_bg ) ) {
			$css .= businessx_gcs( '.sec-contact .ac-btn, .sec-contact input[type=submit], .sec-contact input[type=reset], .sec-contact input[type=button], .sec-contact button', 'background-color', 'contact_color_submit_bg' ); }

			if( businessx_cd( 'contact_color_submit_bg_hover', $contact_color_submit_bg_hover ) ) {
			$css .= businessx_gcs( '.sec-contact .ac-btn:hover, .sec-contact input[type=submit]:hover, .sec-contact input[type=reset]:hover, .sec-contact input[type=button]:hover, .sec-contact button:hover', 'background-color', 'contact_color_submit_bg_hover' ); }

			if( businessx_cd( 'contact_color_submit_bg_active', $contact_color_submit_bg_active ) ) {
			$css .= businessx_gcs( '.sec-contact .ac-btn:focus, .sec-contact input[type=submit]:focus, .sec-contact input[type=reset]:focus, .sec-contact input[type=button]:focus, .sec-contact button:focus, .sec-contact .ac-btn:active, .sec-contact input[type=submit]:active, .sec-contact input[type=reset]:active, .sec-contact input[type=button]:focus, .sec-contact button:active', 'background-color', 'contact_color_submit_bg_active' ); }


			/* Maps Section */
			if( businessx_cd( 'maps_overlay_bg', $maps_overlay_bg ) ) {
			$css .= businessx_gcs( '.sec-maps .sec-maps-overlay', 'background-color', 'maps_overlay_bg' ); }

			if( businessx_cd( 'maps_overlay_bg_hover', $maps_overlay_bg_hover ) ) {
			$css .= businessx_gcs( '.sec-maps .sec-maps-overlay:hover', 'background-color', 'maps_overlay_bg_hover' ); }

			if( businessx_cd( 'maps_overlay_inner', $maps_overlay_inner ) ) {
			$css .= businessx_gcs( '.sec-maps .sec-maps-overlay', 'box-shadow', 'maps_overlay_inner', 'inset 0 0 7.222em 0.833em ' ); }

			if( businessx_cd( 'maps_overlay_inner_hover', $maps_overlay_inner_hover ) ) {
			$css .= businessx_gcs( '.sec-maps .sec-maps-overlay', 'box-shadow', 'maps_overlay_inner_hover', 'inset 0 0 7.222em 0.833em ' ); }

			if( businessx_cd( 'maps_title_color', $maps_title_color ) ) {
			$css .= businessx_gcs( '.sec-maps .smo-title, .sec-maps a:not(.smo-icon), .sec-maps a:not(.smo-icon):hover, .sec-maps a:not(.smo-icon):focus, .sec-maps a:not(.smo-icon):active', 'color', 'maps_title_color' ); }

			if( businessx_cd( 'maps_icon_color', $maps_icon_color ) ) {
			$css .= businessx_gcs( '.sec-maps a.smo-icon', 'background-color', 'maps_icon_color' ); }


		// Adds inline css
		wp_add_inline_style( 'businessx-style', esc_html( $css ) );
	}
}
add_action( 'wp_enqueue_scripts', 'businessx_extensions_final_inline_css', 12 );



/*  CSS JS template
/* ------------------------------------ */

if( ! function_exists( 'businessx_extensions_czr_output_css_template' ) ) {
	function businessx_extensions_czr_output_css_template() {
		global $businessx_extensions_cs_mods;
		$new_settings = array();

		foreach( $businessx_extensions_cs_mods as $bcs => $bcs_value ) {
			$new_settings[ $bcs ] = '{{ data.' . $bcs . ' }}';
		}

		?>
		<script type="text/html" id="tmpl-businessx-ext-czr-settings-output">
			<?php echo businessx_extensions_czr_output_css( $new_settings  ); ?>
		</script>
		<?php
	}
}
add_action( 'customize_controls_print_footer_scripts', 'businessx_extensions_czr_output_css_template', 11 );
