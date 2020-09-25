<?php
/* ------------------------------------------------------------------------- *
 *  ______
 *
 *  Maps Section
 *  ________________
 *
 *  Settings and controls options
 *  _____________________________
 *
 *  You can find the callback functions in:
 *  ../inc/customizer/helpers.php
 *
/* ------------------------------------------------------------------------- */


	/**
	 * Add section
	 */
	$wp_customize->add_section( new BXEXT_Section_FrontPage( $wp_customize, 'businessx_section__maps', array(
		'title'     => esc_html__( 'Maps Section', 'businessx-extensions' ),
		'panel'     => 'businessx_panel__sections',
		'priority'  => absint( businessx_extensions_sec_prio( 'businessx_section__maps' ) ),
	) ) );

		/**
		 * A list of options to register based on a callback function and arguments
		 * Use the `bx_maps_section___options` to add options
		 *
		 * @var array
		 */
		$bx_maps_section = apply_filters( 'bx_maps_section___options', array(

			/* Hide section */
			'hide_section' => array(
				'callback'   => 'simple',
				'args'       => array(
					'type'        => 'checkbox',
					'setting_id'  => 'maps_section_hide',
					'section_id'  => 'businessx_section__maps',
					'label'       => esc_html__( 'Hide this section', 'businessx-extensions' ),
					'default'     => true,
					'transport'   => false,
					'sanitize'    => 'businessx_sanitize_checkbox',
				)
			),

			/* Section title */
			'section_title' => array(
				'callback'    => 'simple',
				'args'        => array(
					'setting_id'  => 'maps_section_title',
					'section_id'  => 'businessx_section__maps',
					'label'       => esc_html__( 'Section title', 'businessx-extensions' ),
					'description' => esc_html__( 'Set a title for this section.', 'businessx-extensions' ),
					'default'     => esc_html__( 'Find us on the map', 'businessx-extensions' ),
					'selector'    => '.sec-maps .smo-title a',
				)
			),

			/* Hide icon */
			'hide_icon' => array(
				'callback'   => 'simple',
				'args'       => array(
					'type'        => 'checkbox',
					'setting_id'  => 'maps_section_hide_icon',
					'section_id'  => 'businessx_section__maps',
					'label'       => esc_html__( 'Hide icon', 'businessx-extensions' ),
					'default'     => true,
					'transport'   => false,
					'sanitize'    => 'businessx_sanitize_checkbox'
				)
			),

			/* Iframe information */
			'iframe_info' => array(
				'callback'          => 'simple',
				'args'              => array(
					'type'               => 'info',
					'setting_id'         => 'maps_section_iframe_about',
					'section_id'         => 'businessx_section__maps',
					'label'              => esc_html__( 'Google Maps Iframe', 'businessx-extensions' ),
					'description'        => __( '<p>To add a map you will need to go to the <a href="https://www.google.com/maps">Google Maps</a> website, select a location and click on the "Share" button.</p><p>A popup message will show up, now you just click "Embed Map" and copy paste the iframe code in this textarea field.</p>', 'businessx-extensions' ),
				)
			),


			/* Iframe code */
			'iframe_code' => array(
				'callback'  => 'simple',
				'args'      => array(
					'type'       => 'textarea',
					'setting_id' => 'maps_section_code',
					'section_id' => 'businessx_section__maps',
					'selector'   => '.sec-maps-iframe',
					'default'    => '',
					'sanitize'   => 'businessx_ext_sanitize_gmaps_iframe',
					'escape'     => 'businessx_ext_sanitize_gmaps_iframe'
				)
			),

			/* Overlay background color */
			'overlay_bg_color' => array(
				'callback'       => 'simple',
				'args'           => array(
					'type'         => 'rgba',
					'setting_id'   => 'maps_overlay_bg',
					'section_id'   => 'businessx_section__maps',
					'label'        => esc_html__( 'Overlay background color:', 'businessx-extensions' ),
					'default'      => 'rgba(0,0,0,0.8)',
				)
			),

			/* Overlay background color hover */
			'overlay_bg_hover' => array(
				'callback'       => 'simple',
				'args'           => array(
					'type'         => 'rgba',
					'setting_id'   => 'maps_overlay_bg_hover',
					'section_id'   => 'businessx_section__maps',
					'label'        => esc_html__( 'Overlay hover background color:', 'businessx-extensions' ),
					'default'      => 'rgba(0,0,0,0.75)',
				)
			),

			/* Overlay inner shadow */
			'overlay_inner_sh' => array(
				'callback'       => 'simple',
				'args'           => array(
					'type'         => 'rgba',
					'setting_id'   => 'maps_overlay_inner',
					'section_id'   => 'businessx_section__maps',
					'label'        => esc_html__( 'Overlay inner shadow:', 'businessx-extensions' ),
					'default'      => 'rgba(0,0,0,0.4)',
				)
			),

			/* Overlay inner shadow */
			'overlay_inner_sh_hover' => array(
				'callback'             => 'simple',
				'args'                 => array(
					'type'               => 'rgba',
					'setting_id'         => 'maps_overlay_inner_hover',
					'section_id'         => 'businessx_section__maps',
					'label'              => esc_html__( 'Overlay inner shadow hover:', 'businessx-extensions' ),
					'default'            => 'rgba(0,0,0,0.3)',
				)
			),

			/* Title color */
			'title_color' => array(
				'callback'   => 'simple',
				'args'       => array(
					'type'       => 'rgb',
					'setting_id' => 'maps_title_color',
					'section_id' => 'businessx_section__maps',
					'label'      => esc_html__( 'Title color:', 'businessx-extensions' ),
					'default'    => '#ffffff',
				)
			),

			/* Icon background color */
			'icon_background_color' => array(
				'callback'             => 'simple',
				'args'                 => array(
					'type'               => 'rgb',
					'setting_id'         => 'maps_icon_color',
					'section_id'         => 'businessx_section__maps',
					'label'              => esc_html__( 'Icon background color:', 'businessx-extensions' ),
					'default'            => '#d72f2f',
				)
			),

		) ); // End options

		/**
		 * Register controls based on the above options
		 */
		bx_ext_controller_register( $bx_maps_section );
