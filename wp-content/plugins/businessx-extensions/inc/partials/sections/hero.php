<?php
/**
 * ------------------
 * Template functions
 * ------------------
 *
 * In case you need to add some custom functions,
 * add them below.
 *
 */




/**
 * -----------------
 * Template partials
 * -----------------
 *
 * @see ../inc/partials/sections/hooks.php
 */

	/**
	 * Hero Section
	 * ------------
	 */

	// Section wrapper - start
	if( ! function_exists( 'bx_ext_part__hero_wrap_start' ) ) {
		function bx_ext_part__hero_wrap_start() {
			$mod      = 'hero_bg_parallax';
			$enabled  = bx_ext_tm( $mod, false );
			$class    = $enabled ? ' bx-ext-parallax' : '';
			$parallax = bxext_section_parallax( $mod, 'hero_bg_parallax_img', true );
			$format   = '<section id="section-hero" class="sec-hero%1$s"%2$s>';

			$output = sprintf( $format, $class, $parallax );
			$output = apply_filters( 'bx_ext_part___hero_wrap_start', $output, $format, $class, $parallax );

			echo $output;
		}
	}

	// Section wrapper - end
	if( ! function_exists( 'bx_ext_part__hero_wrap_end' ) ) {
		function bx_ext_part__hero_wrap_end() {
			?></section><?php
		}
	}

		// Overlay
		if( ! function_exists( 'bx_ext_part__hero_overlay' ) ) {
			function bx_ext_part__hero_overlay() {
				/**
 				 * Hooked:
 				 * bx_ext_part__hero_overlay_start - 10
 				 * bx_ext_part__hero_elements      - 20
 				 * bx_ext_part__hero_overlay_end   - 999
 				 */
 				do_action( 'bx_ext_part__hero_overlay' );
			}
		}

		// Overlay start
		if( ! function_exists( 'bx_ext_part__hero_overlay_start' ) ) {
			function bx_ext_part__hero_overlay_start() {
				?><div class="sec-hero-overlay"><?php
			}
		}

		// Overlay end
		if( ! function_exists( 'bx_ext_part__hero_overlay_end' ) ) {
			function bx_ext_part__hero_overlay_end() {
				?></div><?php
			}
		}

		// Elements
		if( ! function_exists( 'bx_ext_part__hero_elements' ) ) {
			function bx_ext_part__hero_elements() {
				$title       = bx_ext_tm( 'hero_section_title', esc_html__( 'Hero section title goes here.', 'businessx-extensions' ) );
				$description = bx_ext_tm( 'hero_section_description', esc_html__( 'You can edit this section by going to Customizer > Front Page Sections > Hero Section', 'businessx-extensions' ) );

				if( $title != '' || $description != '' ) {
					/**
	 				 * Hooked:
	 				 * bx_ext_part__hero_elements_start       - 10
	 				 * bx_ext_part__hero_elements_title       - 20
	 				 * bx_ext_part__hero_elements_description - 30
	 				 * bx_ext_part__hero_elements_buttons     - 40
	 				 * bx_ext_part__hero_elements_end         - 999
	 				 */
	 				do_action( 'bx_ext_part__hero_elements' );
				}
			}
		}

			// Elements start
			if( ! function_exists( 'bx_ext_part__hero_elements_start' ) ) {
				function bx_ext_part__hero_elements_start() {
					?><div class="sec-hs-elements ta-center"><?php
				}
			}

			// Elements end
			if( ! function_exists( 'bx_ext_part__hero_elements_end' ) ) {
				function bx_ext_part__hero_elements_end() {
					?></div><?php
				}
			}

			// Title
			if( ! function_exists( 'bx_ext_part__hero_elements_title' ) ) {
				function bx_ext_part__hero_elements_title() {
					$title  = bxext_sections_strings( 'hero', 'title' );
					$anim   = businessx_anim_classes( true );
					$format = '<h2 class="hs-primary-large %1$s">%2$s</h2>';
					$output = sprintf( $format, $anim, esc_html( $title ) );
					$output = apply_filters( 'bx_ext_part___hero_elements_title', $output, $format, $anim, $title );

					if( $title == '' ) return; // Do nothing

					echo $output;
				}
			}

			// Description
			if( ! function_exists( 'bx_ext_part__hero_elements_description' ) ) {
				function bx_ext_part__hero_elements_description() {
					$description = bxext_sections_strings( 'hero', 'description' );
					$anim        = businessx_anim_classes( true );
					$format      = '<p class="sec-hs-description fs-largest fw-regular %1$s">%2$s</p>';
					$output      = sprintf( $format, $anim, bxext_escape_content_filtered_nonp( $description ) );
					$output      = apply_filters( 'bx_ext_part___hero_elements_description', $output, $format, $anim, $description );

					if( $description == '' ) return; // Do nothing

					echo $output;
				}
			}

			// Buttons
			if( ! function_exists( 'bx_ext_part__hero_elements_buttons' ) ) {
				function bx_ext_part__hero_elements_buttons() {
					$buttons = businessx_hero_btns_output();
					$anim    = businessx_anim_classes( true );
					$format  = '<div class="sec-hs-buttons %1$s">%2$s</div>';
					$output  = sprintf( $format, $anim, $buttons );
					$output  = apply_filters( 'bx_ext_part___hero_elements_buttons', $output, $format, $anim, $buttons );

					echo $output;
				}
			}
