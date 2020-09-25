<?php
/**
 * ----------------------------------------
 * Some helper functions for the Customizer
 * ----------------------------------------
 */


if( ! function_exists( 'bx_ext_controller_register' ) ) {
	/**
	 * Adds multiple settings and controls based on callback functions
	 * and arguments
	 *
	 * @since 1.0.4.3
	 * @param  array  $options An array containing callback functions and arguments for them
	 * @return object          Multiple instances of WP_Customize_Manager
	 */
	function bx_ext_controller_register( $options = array() ) {
		/* Bail if no options */
		if( empty( $options ) ) return;

		/* Register and output all the settings/controls */
		foreach( $options as $option => $setting ) {
			$func = 'bx_ext_controller_' . $setting[ 'callback' ];
			$args = $setting[ 'args' ];

			/* If the callback function doesn't exist, continue. */
			if( ! function_exists( $func ) ) continue;

			/* Call the callback function with our arguments */
			call_user_func( $func, $args );
		}
	}
}


/*  New controllers
/* ------------------------------------ */
if ( ! function_exists( 'bx_ext_controller_simple' ) ) {
	/**
	 * Wrapper for $wp_customize->add_*, registers a Customizer
	 * setting and control
	 *
	 * @see    https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
	 * @see    https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
	 * @since  1.0.4.3
	 * @param  array  $args An array containing new arguments for add_setting & add_control
	 * @return object       WP_Customize_Manager instance
	 */
	function bx_ext_controller_simple( $args = array() ) {
		global $wp_customize;

		/* Bail if $wp_customize doesn't exist */
		if( ! is_object( $wp_customize ) ) return;

		/* Vars */
		$setting_args = $control_args = array();

		/* Defaults */
		$defaults = array(
			'type'        => 'text',
			'setting_id'  => '',
			'section_id'  => '',
			'label'       => '',
			'description' => '',
			'default'     => '',
			'selector'    => '',
			'transport'   => true,
			'sanitize'    => 'sanitize_text_field',
			'escape'      => 'esc_html',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'postmsg'     => false
		);

		/* New args */
		$args         = wp_parse_args( $args, $defaults );
		$type         = $args['type'];
		$args         = apply_filters( 'bx_ext_controller_simple___' . $type .'_args', $args, $defaults, $type );
		$setting_id   = $args['setting_id'];
		$section_id   = $args['section_id'];
		$label        = $args['label'];
		$description  = $args['description'];
		$default      = $args['default'];
		$selector     = $args['selector'];
		$sanitize     = $args['sanitize'];
		$escape       = $args['escape'];
		$priority     = $args['priority'];
		$capability   = $args['capability'];
		$postmsg      = $args['postmsg'];



		/**
		 * Transport type
		 * @see https://codex.wordpress.org/Theme_Customization_API#Part_2:_Generating_Live_CSS
		 * @var string
		 */
		$transport = $args['transport'] ? 'postMessage' : 'refresh';

		/* Default section args */
		$settings_args = apply_filters( 'bx_ext_controller_simple___' . $type .'_settings_args', array(
			'default'           => $default,
			'sanitize_callback' => $sanitize,
			'capability'        => $capability,
			'transport'         => $transport,
		), $args, $type, $transport );

		/* Default control args */
		$control_args  = apply_filters( 'bx_ext_controller_simple___' . $type .'_control_args', array(
			'label'             => $label,
			'description'       => $description,
			'section'           => $section_id,
			'settings'          => $setting_id,
			'type'              => $type,
			'priority'          => intval( $priority ),
		), $args, $type );

		/* The type of control and setting we display and register. */
		$types = array(
			'select'     => 1,
			'checkbox'   => 1,
			'textarea'   => 1,
			'text'       => 1,
			'rgb'        => 1,
			'rgba'       => 1,
			'image'      => 1,
			'info'       => 1,
			'tabs'       => 1,
		);

		if( array_key_exists( $type, $types ) ) {
			switch( $type ) {

				/**
				 * Tabs
				 */
				case 'tabs':
				$control_args['type']              = 'section-tabs';
				$control_args['title_colors']     = __( 'Colors', 'businessx-extensions' );
				$control_args['title_background'] = __( 'Background', 'businessx-extensions' );
				$wp_customize->add_setting( $setting_id, array() );
				$wp_customize->add_control( new BXEXT_Control_Tabs( $wp_customize, $setting_id, $control_args ) );
					break;

				/**
				 * Information
				 */
				case 'info':
					$control_args['type'] = 'info-control';
					$wp_customize->add_setting( $setting_id, $settings_args );
					$wp_customize->add_control( new Businessx_Control_Info( $wp_customize, $setting_id, $control_args ) );
					break;

				/**
				 * Image uploader
				 */
				case 'image':
					$control_args['type']         = 'image';
					$settings_args['sanitize']    = $sanitize !== 'esc_html' ? $sanitize : 'esc_url_raw';
					$wp_customize->add_setting( $setting_id, $settings_args );
					$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $setting_id, $control_args ) );
					break;

				/**
				 * RGBA color picker
				 */
				case 'rgba':
					$control_args['type']         = 'alpha-color';
					$control_args['show_opacity'] = ! empty( $args['show_opacity'] ) ? $args['show_opacity'] : true;
					$control_args['palette']      = ! empty( $args['palette'] ) ? $args['palette'] : array();
					$settings_args['sanitize']    = $sanitize !== 'esc_html' ? $sanitize : 'businessx_sanitize_rgba';
					$wp_customize->add_setting( $setting_id, $settings_args );
					$wp_customize->add_control( new Businessx_Control_RGBA( $wp_customize, $setting_id, $control_args ) );
					break;

				/**
				 * RGB color picker
				 */
				case 'rgb':
					$control_args['type']      = 'color';
					$settings_args['sanitize'] = $sanitize !== 'esc_html' ? $sanitize : 'sanitize_hex_color';
					$wp_customize->add_setting( $setting_id, $settings_args );
					$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $setting_id, $control_args ) );
					break;

				/**
				 * Select box
				 */
				case 'select':
					$control_args['type']         = 'select';
					$control_args['width']        = ! empty( $args['width'] ) ? $args['width'] : '100';
					$control_args['choices']      = ! empty( $args['choices'] ) ? $args['choices'] : array();
					$settings_args['sanitize']    = $sanitize !== 'esc_html' ? $sanitize : 'businessx_sanitize_select';
					$wp_customize->add_setting( $setting_id, $settings_args );
					$wp_customize->add_control( $setting_id, $control_args );
					break;

				/**
				 * Checkbox input
				 */
				case 'checkbox':
					$control_args['type']         = 'checkbox';
					$settings_args['sanitize']    = 'businessx_sanitize_checkbox';
					$wp_customize->add_setting( $setting_id, $settings_args );
					$wp_customize->add_control( $setting_id, $control_args );
					break;

				/**
				 * Textarea field
				 */
				case 'textarea':
					$control_args['type'] = 'textarea';
					$wp_customize->add_setting( $setting_id, $settings_args );
					$wp_customize->add_control( $setting_id, $control_args );
					break;

				/**
				 * Simple text field
				 */
				default:
					$wp_customize->add_setting( $setting_id, $settings_args );
					$wp_customize->add_control( $setting_id, $control_args );

			}
		}

		/* Selective refresh in case transport is set to true */
		if( $transport && $type !== 'rgb' && $type !== 'rgba' && $type !== 'image' && $type !== 'background' && $type !== 'opacity' && $postmsg === false ) {
			$wp_customize->selective_refresh->add_partial( $setting_id, array(
				'selector' => $selector,
				'render_callback' => function() use ( &$setting_id, &$escape )  {
					$tm = get_theme_mod( $setting_id );
					if( function_exists( $escape ) ) {
						return call_user_func( $escape, $tm );
					} else {
						return esc_html( $tm );
					}
				},
			) );
		}

		/* Add new controls & settings */
		do_action( 'bx_ext_controller_simple__new', $defaults, $args, $type, $settings_args, $control_args );

	}
}


if( ! function_exists( 'bx_ext_controller_custom' ) ) {
	/**
	 * Adds some custom options with preset defaults, build up with `bx_ext_controller_simple()`.
	 * Defaults to `background` if not `type` is chosen
	 *
	 * @since  1.0.4.3
	 * @param  array  $args A few custom arguments for `bx_ext_controller_simple()`
	 * @return object       WP_Customize_Manager instance
	 */
	function bx_ext_controller_custom( $args = array() ) {
		/* Defaults */
		$defaults = array(
			'type'        => 'background',
			'setting_id'  => '',
			'section_id'  => '',
			'default'     => '',
		);

		/* New args */
		$args         = wp_parse_args( $args, $defaults );
		$type         = $args['type'];
		$setting_id   = $args['setting_id'];
		$section_id   = $args['section_id'];
		$default      = $args['default'];

		/* The type of control and setting we display and register. */
		$types = array(
			'overlay'    => 1,
			'background' => 1
		);

		if( array_key_exists( $type, $types ) ) {
			switch( $type ) {

				/**
				 * Background overlay options
				 */
				case 'overlay':
					// Show or hide overlay
					bx_ext_controller_simple( apply_filters( 'bx_ext_controller_custom___overlay_show', array(
						'type'        => 'checkbox',
						'setting_id'  => $setting_id,
						'section_id'  => $section_id,
						'label'       => esc_html__( 'Show Background Overlay', 'businessx-extensions' ),
						'default'     => false,
						'transport'   => false,
						'sanitize'    => 'businessx_sanitize_checkbox',
					), $type, $setting_id, $section_id ) );

					// Overlay color
					bx_ext_controller_simple( apply_filters( 'bx_ext_controller_custom___overlay_color', array(
						'type'        => 'rgb',
						'setting_id'  => $setting_id . '_color',
						'section_id'  => $section_id,
						'label'       => esc_html__( 'Overlay background color:', 'businessx-extensions' ),
						'default'     => $default === '' ? '#000000' : $default,
					), $type, $setting_id, $section_id, $default ) );

					// Overlay opacity
					bx_ext_controller_simple( apply_filters( 'bx_ext_controller_custom___overlay_opacity', array(
						'type'        => 'select',
						'setting_id'  => $setting_id . '_opacity',
						'section_id'  => $section_id,
						'label'       => esc_html__( 'Background overlay opacity:', 'businessx-extensions' ),
						'default'     => '0.5',
						'choices'     => bx_ext_controller_overlay_opacity( $setting_id ),
						'postmsg'     => true,
					), $type, $setting_id, $section_id ) );
					break;

				/**
				 * Background image options
				 */
				default:
					// Image upload
					bx_ext_controller_simple( apply_filters( 'bx_ext_controller_custom___bg_image', array(
						'type'        => 'image',
						'setting_id'  => $setting_id,
						'section_id'  => $section_id,
						'label'       => esc_html__( 'Background Image:', 'businessx-extensions' ),
						'description' => esc_html__( 'Use a HD image, suggested size: 1920x1080px', 'businessx-extensions' ),
					), $type, $setting_id, $section_id ) );

					// Select a background size
					bx_ext_controller_simple( apply_filters( 'bx_ext_controller_custom___bg_size', array(
						'type'        => 'select',
						'setting_id'  => $setting_id . '_size',
						'section_id'  => $section_id,
						'label'       => esc_html__( 'Background-size:', 'businessx-extensions' ),
						'default'     => 'cover',
						'choices'     => businessx_bg_options_size(),
						'postmsg'     => true,
					), $type, $setting_id . '_size', $section_id ) );

					// Select how the background repeats
					bx_ext_controller_simple( apply_filters( 'bx_ext_controller_custom___bg_repeat', array(
						'type'        => 'select',
						'setting_id'  => $setting_id . '_repeat',
						'section_id'  => $section_id,
						'label'       => esc_html__( 'Background-repeat:', 'businessx-extensions' ),
						'default'     => 'no-repeat',
						'choices'     => businessx_bg_options_repeat(),
						'postmsg'     => true,
					), $type, $setting_id . '_repeat', $section_id ) );

					// Select a background position
					bx_ext_controller_simple( apply_filters( 'bx_ext_controller_custom___bg_position', array(
						'type'        => 'select',
						'setting_id'  => $setting_id . '_position',
						'section_id'  => $section_id,
						'label'       => esc_html__( 'Background-position:', 'businessx-extensions' ),
						'default'     => 'center center',
						'choices'     => businessx_bg_options_position(),
						'postmsg'     => true,
					), $type, $setting_id . '_position', $section_id ) );

			}
		}

		/* Add new controls & settings */
		do_action( 'bx_ext_controller_custom__new', $defaults, $args, $type, $setting_id, $section_id, $default );
	}
}


if ( ! function_exists( 'bx_ext_controller_overlay_opacity' ) ) {
	/**
	 * An array of options for a select option that changes
	 * the overlay opacty
	 *
	 * @since  1.0.4.3
	 * @param  string $setting_id The theme mod setting ID
	 * @return array              From 10% to 100% options
	 */
	function bx_ext_controller_overlay_opacity( $setting_id ) {
		return apply_filters( 'businessx_' . $setting_id . '_opacity_select_filter', array(
			'0'   => esc_html__( 'Transparent', 'businessx-extensions' ),
			'0.1' => esc_html__( '10%', 'businessx-extensions' ),
			'0.2' => esc_html__( '20%', 'businessx-extensions' ),
			'0.3' => esc_html__( '30%', 'businessx-extensions' ),
			'0.4' => esc_html__( '40%', 'businessx-extensions' ),
			'0.5' => esc_html__( '50%', 'businessx-extensions' ),
			'0.6' => esc_html__( '60%', 'businessx-extensions' ),
			'0.7' => esc_html__( '70%', 'businessx-extensions' ),
			'0.8' => esc_html__( '80%', 'businessx-extensions' ),
			'0.9' => esc_html__( '90%', 'businessx-extensions' ),
			'1'   => esc_html__( '100%', 'businessx-extensions' ),
		) );
	}
}
