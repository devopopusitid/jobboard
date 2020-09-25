<?php
/* ------------------------------------------------------------------------- *
 *  Helper Functions
/* ------------------------------------------------------------------------- */



/*  Check theme version
/* ------------------------------------ */
if( ! function_exists( 'businessx_extensions_ck_theme_v' ) ) {
    function businessx_extensions_ck_theme_v( $version, $sign = '>' ) {
        $theme_name = apply_filters( 'businessx_extensions___get_theme_name', 'businessx');
        $theme_ver = wp_get_theme( $theme_name )->get('Version');
        if( version_compare( $theme_ver, $version, $sign ) ) {
            return true;
        } else {
            return false;
        }
    }
}



/*  Check if Jetpack specific module
 *  is enabled
/* ------------------------------------ */
if( ! function_exists( 'businessx_extensions_jp_active' ) ) {
    function businessx_extensions_jp_active( $module ) {
        $active_modules = get_option( 'jetpack_active_modules' );
        if( $active_modules !== false ) {
            if( in_array( $module, $active_modules, TRUE ) ) { return true; } else { return false;  }
        } else {
            return false;
        }
    }
}



/*  Check if Jetpack specific module
 *  is enabled
/* ------------------------------------ */
if( ! function_exists( 'businessx_extensions_jp_ck_mobile_theme' ) ) {
    function businessx_extensions_jp_ck_mobile_theme() {
        if( businessx_extensions_jp_active( 'minileven' ) ) {
            echo '<div class="notice error is-dismissible">';
        		echo '<p>' . __( 'Jetpack\'s <i> Mobile Theme</i> module is activated.', 'businessx-extensions' )  .'</p>';
                echo '<p>' . __( 'This will cause an error or blank page on mobile devices. Businessx is already a responsive/mobile theme. Please disable the Mobile Theme module.', 'businessx-extensions' ) . '</p>';
            echo '</div>';
        }
    }
}
add_action( 'admin_notices', 'businessx_extensions_jp_ck_mobile_theme', 0 );



/*  Section parallax
/* ------------------------------------ */
if ( ! function_exists( 'bxext_section_parallax' ) ) {
	/**
	 * Adds a background image with parallax effect
	 *
	 * @since  1.0.4.3
	 * @param  string  $enabled Enable parallax theme mod
	 * @param  string  $bgimg   Parallax background image theme mod
	 * @param  boolean $return  Return or echo
	 * @return string
	 */
	function bxext_section_parallax( $enabled, $bgimg, $return = false ) {
		$background = get_theme_mod( $bgimg, '' );
		$parallax   = get_theme_mod( $enabled, false );
		$output     = '';

		if( $bgimg != '' && $parallax ) {
			$output = ' style="background-image: url(' . esc_url( $background ) . ');"';
		}

		if( $return ) { return $output; } else { echo $output; }
	}
}



/*  Section strings
/* ------------------------------------ */
if( ! function_exists( 'bxext_sections_strings' ) ) {
	/**
	 * Display sections strings and use multilang if selected
	 *
	 * @since  1.0.4.3
	 * @param  string  $section Selected section
	 * @param  string  $string  Selected string
	 * @return string
	 */
	function bxext_sections_strings( $section, $string ) {
		// Check if we should use the Polylang strings
		$polylang = ( get_theme_mod( 'use_polylang', false ) && bxext_compt_polylang_check() ) ? true : false;

		// For section
		switch( $section ) {

			// Features
			case 'features' :
				switch ( $string ) {
					case 'title' :
						if( $polylang ) {
							return pll__( 'Features Heading' );
						} else {
							return bx_ext_tm( 'features_section_title', __( 'Features Heading', 'businessx-extensions' ) );
						}
						break;
					case 'description' :
						if( $polylang ) {
							return pll__( 'This is a description for the Features section. You can set it up in the Customizer where you can also add items for it.' );
						} else {
							return bx_ext_tm( 'features_section_description', __( 'This is a description for the Features section. You can set it up in the Customizer where you can also add items for it.', 'businessx-extensions' ) );
						}
						break;
				}
				break;

			// About
			case 'about' :
				switch ( $string ) {
					case 'title' :
						if( $polylang ) {
							return pll__( 'About Us Heading' );
						} else {
							return bx_ext_tm( 'about_section_title', __( 'About Us Heading', 'businessx-extensions' ) );
						}
						break;
					case 'description' :
						if( $polylang ) {
							return pll__( 'This is a description for the About section. You can set it up in the Customizer > Front Page Sections > About Section.' );
						} else {
							return bx_ext_tm( 'about_section_description', __( 'This is a description for the About section. You can set it up in the Customizer > Front Page Sections > About Section.', 'businessx-extensions' ) );
						}
						break;
					case 'button' :
						if( $polylang ) {
							return pll__( 'Button Anchor Text' );
						} else {
							return bx_ext_tm( 'about_section_btn_anchor', __( 'More Info About Us', 'businessx-extensions' ) );
						}
						break;
				}
				break;

			// Team
			case 'team' :
				switch ( $string ) {
					case 'title' :
						if( $polylang ) {
							return pll__( 'Team Heading' );
						} else {
							return bx_ext_tm( 'team_section_title', __( 'Team Heading', 'businessx-extensions' ) );
						}
						break;
					case 'description' :
						if( $polylang ) {
							return pll__( 'This is a description for the Team section. You can set it up in the Customizer where you can also add items for it.' );
						} else {
							return bx_ext_tm( 'team_section_description', __( 'This is a description for the Team section. You can set it up in the Customizer where you can also add items for it.', 'businessx-extensions' ) );
						}
						break;
				}
				break;

			// Clients
			case 'clients' :
				switch ( $string ) {
					case 'title' :
						if( $polylang ) {
							return pll__( 'Clients Heading' );
						} else {
							return bx_ext_tm( 'clients_section_title', __( 'Clients Heading', 'businessx-extensions' ) );
						}
						break;
					case 'description' :
						if( $polylang ) {
							return pll__( 'This is a description for the Clients section. You can set it up in the Customizer where you can also add items for it.' );
						} else {
							return bx_ext_tm( 'clients_section_description', __( 'This is a description for the Clients section. You can set it up in the Customizer where you can also add items for it.', 'businessx-extensions' ) );
						}
						break;
				}
				break;

			// Pricing
			case 'pricing' :
				switch ( $string ) {
					case 'title' :
						if( $polylang ) {
							return pll__( 'Pricing Heading' );
						} else {
							return bx_ext_tm( 'pricing_section_title', __( 'Pricing Heading', 'businessx-extensions' ) );
						}
						break;
					case 'description' :
						if( $polylang ) {
							return pll__( 'This is a description for the Pricing section. You can set it up in the Customizer where you can also add items for it.' );
						} else {
							return bx_ext_tm( 'pricing_section_description', __( 'This is a description for the Pricing section. You can set it up in the Customizer where you can also add items for it.', 'businessx-extensions' ) );
						}
						break;
				}
				break;

			// Portfolio
			case 'portfolio' :
				switch ( $string ) {
					case 'title' :
						if( $polylang ) {
							return pll__( 'Portfolio Heading' );
						} else {
							return bx_ext_tm( 'portfolio_section_title', __( 'Portfolio Heading', 'businessx-extensions' ) );
						}
						break;
					case 'description' :
						if( $polylang ) {
							return pll__( 'This is a description for the Portfolio section. You can set it up in the Customizer where you can also change some options.' );
						} else {
							return bx_ext_tm( 'portfolio_section_description', __( 'This is a description for the Portfolio section. You can set it up in the Customizer where you can also change some options.', 'businessx-extensions' ) );
						}
						break;
					case 'button' :
						if( $polylang ) {
							return pll__( 'View More Projects' );
						} else {
							return bx_ext_tm( 'portfolio_action_btn', __( 'View More Projects', 'businessx-extensions' ) );
						}
						break;
				}
				break;

			// Testimonials
			case 'testimonials' :
				switch ( $string ) {
					case 'title' :
						if( $polylang ) {
							return pll__( 'Testimonials' );
						} else {
							return bx_ext_tm( 'testimonials_section_title', __( 'Testimonials', 'businessx-extensions' ) );
						}
						break;
				}
				break;

			// FAQ
			case 'faq' :
				switch ( $string ) {
					case 'title' :
						if( $polylang ) {
							return pll__( 'Frequently Asked Questions' );
						} else {
							return bx_ext_tm( 'faq_section_title', __( 'Frequently Asked Questions', 'businessx-extensions' ) );
						}
						break;
					case 'description' :
						if( $polylang ) {
							return pll__( 'This is a description for the FAQ section. You can set it up in the Customizer where you can also add items for it.' );
						} else {
							return bx_ext_tm( 'faq_section_description', __( 'This is a description for the FAQ section. You can set it up in the Customizer where you can also add items for it.', 'businessx-extensions' ) );
						}
						break;
				}
				break;

			// Hero
			case 'hero' :
				switch ( $string ) {
					case 'title' :
						if( $polylang ) {
							return pll__( 'Hero section title goes here.' );
						} else {
							return bx_ext_tm( 'hero_section_title', __( 'Hero section title goes here.', 'businessx-extensions' ) );
						}
						break;
					case 'description' :
						if( $polylang ) {
							return pll__( 'You can edit this section by going to Customizer > Sections > Hero Section' );
						} else {
							return bx_ext_tm( 'hero_section_description', __( 'You can edit this section by going to Customizer > Sections > Hero Section', 'businessx-extensions' ) );
						}
						break;
					case 'button-1' :
						if( $polylang ) {
							return pll__( 'Call to Action #1' );
						} else {
							return bx_ext_tm( 'hero_section_1st_btn', __( 'Call to Action #1', 'businessx-extensions' ) );
						}
						break;
					case 'button-2' :
						if( $polylang ) {
							return pll__( 'Call to Action #2' );
						} else {
							return bx_ext_tm( 'hero_section_2nd_btn', __( 'Call to Action #2', 'businessx-extensions' ) );
						}
						break;
					case 'or' :
						if( $polylang ) {
							return pll__( 'Or' );
						} else {
							return bx_ext_tm( 'hero_section_btns_or', __( 'Or', 'businessx-extensions' ) );
						}
						break;
				}
				break;

			// Maps
			case 'maps' :
				switch ( $string ) {
					case 'title' :
						if( $polylang ) {
							return pll__( 'Maps Section Title' );
						} else {
							return bx_ext_tm( 'maps_section_title', __( 'Maps Section Title', 'businessx-extensions' ) );
						}
						break;
				}
				break;

			// Blog
			case 'blog' :
				switch ( $string ) {
					case 'title' :
						if( $polylang ) {
							return pll__( 'Blog Heading' );
						} else {
							return bx_ext_tm( 'blog_section_title', __( 'Blog Heading', 'businessx-extensions' ) );
						}
						break;
					case 'description' :
						if( $polylang ) {
							return pll__( 'This is a description for the Blog section. You can set it up in the Customizer where you can also add items for it.' );
						} else {
							return bx_ext_tm( 'blog_section_description', __( 'This is a description for the Blog section. You can set it up in the Customizer where you can also add items for it.', 'businessx-extensions' ) );
						}
						break;
					case 'button' :
						if( $polylang ) {
							return pll__( 'View More Articles' );
						} else {
							return bx_ext_tm( 'blog_action_btn', __( 'View More Articles', 'businessx-extensions' ) );
						}
						break;
				}
				break;

			// Contact
			case 'contact' :
				switch ( $string ) {
					case 'title' :
						if( $polylang ) {
							return pll__( 'Contact Us' );
						} else {
							return bx_ext_tm( 'contact_section_title', __( 'Contact Us', 'businessx-extensions' ) );
						}
						break;
					case 'description' :
						if( $polylang ) {
							return pll__( 'This is a description for the Contact section. You can set it up in the Customizer where you can also add items for it.', 'Contact Section' );
						} else {
							return bx_ext_tm( 'contact_section_description', __( 'This is a description for the Contact section. You can set it up in the Customizer where you can also add items for it.', 'Contact Section', 'businessx-extensions' ) );
						}
						break;
					case 'shortcode' :
						if( $polylang ) {
							return pll__( 'Your contact form shortcode appears here...' );
						} else {
							return bx_ext_tm( 'contact_section_shortcode', __( 'Your contact form shortcode appears here...', 'businessx-extensions' ) );
						}
						break;
				}
				break;
		}

	}
}



/*  Get theme mod
/* ------------------------------------ */
if( ! function_exists( 'bx_ext_tm' ) ) {
	/**
	 * Wrapper for get_theme_mod with a filter applied on the default value.
	 *
	 * @since  1.0.4.3
	 * @param  string  $theme_mod Theme modification name.
	 * @param  boolean $default   The default value. If not set, returns false.
	 * @return mixed              Returns theme modification value.
	 */
	function bx_ext_tm( $theme_mod, $default = false ) {
		$def = $default ? apply_filters( 'bx_ext___tm_' . $theme_mod . '_default', $default ) : $default;
		$mod = get_theme_mod( $theme_mod, $def );
		return $mod;
	}
}



/*  Debug mode
/* ------------------------------------ */
if( ! function_exists( 'bx_ext_get_min_suffix' ) ) {
	/**
	 * Add/remove ".min" suffix to scripts/styles based
	 * on SCRIPT_DEBUG or BUSINESSX_DEBUG
	 *
	 * @since  1.0.4.3
	 * @return null|string
	 */
	function bx_ext_get_min_suffix() {
		$script_debug = defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ? true : false;
		$bxext_debug  = defined( 'BUSINESSX_DEBUG' ) && true === BUSINESSX_DEBUG ? true : false;
		return ( $script_debug || $bxext_debug ) ? '' : '.min';
	}
}



/*  Show section
/* ------------------------------------ */
if( ! function_exists( 'bx_ext_show_section' ) ) {
	/**
	 * Show section if it's not hidden or in a shortcode
	 * @since  1.0.4.3
	 * @param  string  $section Section name, for example `contact`.
	 * @param  boolean $echo    Return or echo the value.
	 * @return mixed            Returns boolean if `$echo` is false else `true` or `false` as strings.
	 */
	function bx_ext_show_section( $section, $echo = false ) {
		$var         = $section . '_sec__shortcode';
		$newsections = apply_filters( 'bx_ext_show_section___new', array( 'maps', 'contact' ) );
		$def         = in_array( $section, $newsections ) ? 1 : 0;
		$default     = apply_filters( $section . '_section_hide___def', $def );
		$hide        = bx_ext_tm( $section . '_section_hide', $default ) == 0 ? true : false;
		$shortcode   = get_query_var( $var ) ? true : false;

		if( $echo ) {
			echo ( $hide || $shortcode ) ? 'show' : 'hide';
		} else {
			return ( $hide || $shortcode ) ? true : false;
		}
	}
}



/*  Sanitization
/* ------------------------------------ */
// Sections position
if( ! function_exists( 'businessx_ext_sanitize_sections_position' ) ) {
	/**
	 * Sanitization function for the sections position theme mod
	 *
	 * @since  1.0.6
	 * @param  array|string $current Current theme mod
	 * @return string                Sections list in a JSON object
	 */
	function businessx_ext_sanitize_sections_position( $current ) {
		$current = ! is_array( $current ) ? json_decode( $current ) : $current;
	
		return wp_json_encode( array_map( 'sanitize_key', array_unique( $current ) ) );
	}
}

// Textarea with autop
if( ! function_exists( 'businessx_ext_sanitize_content_filtered' ) ) {
	/**
	 * Sanitzation function allowing wp_kses_post() tags through
	 *
	 * @since  1.0.4.3
	 * @param  string  $content Content to sanitize
	 * @return string           Sanitized content with wp_kses_post()
	 */
	function businessx_ext_sanitize_content_filtered( $content ) {
		return wp_kses_post( wptexturize( $content ) );
	}
}

// Google Maps iframe
if( ! function_exists( 'businessx_ext_sanitize_gmaps_iframe' ) ) {
	/**
	 * Sanitize Google Maps iframe
	 *
	 * @since  1.0.4.3
	 * @param  string  $content Iframe code
	 * @return string           Sanitized iframe using wp_kses()
	 */
	function businessx_ext_sanitize_gmaps_iframe( $content ) {
		$allowed = apply_filters( 'businessx_ext_sanitize_gmaps_iframe___allowed', array(
			'iframe' => array(
				'src'             => true,
				'width'           => true,
				'height'          => true,
				'frameborder'     => true,
				'style'           => true,
				'allowfullscreen' => true,
			)
		) );

		return wp_kses( $content, $allowed );
	}
}



/*  Escaping
/* ------------------------------------ */
// Textarea with autop
if( ! function_exists( 'businessx_ext_escape_content_filtered' ) ) {
	/**
	 * Escape textarea content and allow shortcodes. Also, wpautop the all thing.
	 *
	 * @since  1.0.4.3
	 * @param  string  $content The content that needs escaping
	 * @return string           Escaped content
	 */
	function businessx_ext_escape_content_filtered( $content ) {
		$new_content = shortcode_unautop( do_shortcode( wpautop( wptexturize( wp_kses_post( $content ) ) ) ) );
		$partials    = apply_filters( 'businessx_ext_escape_content_filtered___partials', array(
			'<p></p>'    => '',
			'<p><div'    => '<div',
			'</div></p>' => '</div>',
		), $new_content );

		foreach ( $partials as $partial => $change ) {
			$new_content = str_replace( $partial, $change, $new_content );
		}

		return $new_content;
	}
}

// Textarea without wpautop
if( ! function_exists( 'bxext_escape_content_filtered_nonp' ) ) {
	/**
	 * Escape textarea content and allow shortcodes.
	 *
	 * @since  1.0.4.3
	 * @param  string  $content The content that needs escaping
	 * @return string           Escaped content
	 */
	function bxext_escape_content_filtered_nonp( $content ) {
		return shortcode_unautop( do_shortcode( wptexturize( wp_kses_post( $content ) ) ) );
	}
}

// Unfiltered
if( ! function_exists( 'businessx_ext_escape_unfiltered' ) ) {
	/**
	 * Unfiltered content
	 *
	 * @since  1.0.4.3
	 * @param  string  $content Content to be escaped
	 * @return string           Returns raw content, no escaping applied
	 */
	function businessx_ext_escape_unfiltered( $content ) {
		return $content;
	}
}



/*  Section Parallax
/* ------------------------------------ */
if( businessx_extensions_ck_theme_v( '1.0.4', '>=' ) || ! ( 'Businessx' == businessx_extensions_theme() ) || ! ( 'Businessx' == businessx_extensions_theme( true ) ) ) :
if ( ! function_exists( 'businessx_section_parallax' ) ) {
	function businessx_section_parallax( $enabled, $bgimg, $return = false ) {
		$background			= get_theme_mod( $bgimg, '' );
		$parallax			= get_theme_mod( $enabled, false );
		$output				= '';

		if( $bgimg != '' && $parallax ) {
			$output = ' data-parallax="scroll" data-speed="0.5" data-image-src="' . esc_url( $background ) . '" style="background: none !important;"';
		}

		if( $return ) { return $output; } else { echo $output; }
	}
}
endif;



if( businessx_extensions_ck_theme_v( '1.0.3' ) || ! ( 'Businessx' == businessx_extensions_theme() ) || ! ( 'Businessx' == businessx_extensions_theme( true ) ) ) : // Backwards compatibility
/*  Hero buttons output
/* ------------------------------------ */
if( ! function_exists( 'businessx_hero_btns_output' ) ) {
    function businessx_hero_btns_output() {
    	$type = get_theme_mod( 'hero_section_btns', apply_filters( 'businessx_hero___btns_type_default', 'btns-2-def-op' ) );
    	$btn_1_text = bxext_sections_strings( 'hero', 'button-1' );
    	$btn_1_link = get_theme_mod( 'hero_section_1st_btn_link', '#' );
    	$btn_1_target = get_theme_mod( 'hero_section_1st_btn_target', false ) ? '_blank' : '_self';
    	$btn_2_text = bxext_sections_strings( 'hero', 'button-2' );
    	$btn_2_link = get_theme_mod( 'hero_section_2nd_btn_link', '#' );
    	$btn_2_target = get_theme_mod( 'hero_section_2nd_btn_target', false ) ? '_blank' : '_self';
    	$btns_between = bxext_sections_strings( 'hero', 'or' );
    	$output = '';

    	switch( $type ) {
    		// One button - default
    		case 'btns-1-default' :
    			$output .= '<a target="' . esc_attr( $btn_1_target ) . '" href="' . esc_url( $btn_1_link ) . '" class="ac-btn btn-biggest ac-btn-1st">' . esc_html( $btn_1_text ) . '</a>';
    		break;

    		// One button - opaque
    		case 'btns-1-opaque' :
    			$output .= '<a target="' . esc_attr( $btn_1_target ) . '" href="' . esc_url( $btn_1_link ) . '" class="ac-btn btn-biggest ac-btn-1st btn-opaque">' . esc_html( $btn_1_text ) . '</a>';
    		break;

    		// One large - default
    		case 'btns-1-l-default' :
    			$output .= '<a target="' . esc_attr( $btn_1_target ) . '" href="' . esc_url( $btn_1_link ) . '" class="ac-btn btn-biggest ac-btn-1st btn-width-50">' . esc_html( $btn_1_text ) . '</a>';
    		break;

    		// One large - opaque
    		case 'btns-1-l-opaque' :
    			$output .= '<a target="' . esc_attr( $btn_1_target ) . '" href="' . esc_url( $btn_1_link ) . '" class="ac-btn btn-biggest ac-btn-1st btn-width-50 btn-opaque">' . esc_html( $btn_1_text ) . '</a>';
    		break;

    		// Two - default
    		case 'btns-2-default' :
    			$output .= '<a target="' . esc_attr( $btn_1_target ) . '" href="' . esc_url( $btn_1_link ) . '" class="ac-btn btn-biggest ac-btn-1st">' . esc_html( $btn_1_text ) . '</a>';
    			if( $btns_between != '' ) {
    				$output .= '<span class="ac-btns-or fw-bolder">' . esc_html( $btns_between ) . '</span>'; }
    			$output .= '<a target="' . esc_attr( $btn_2_target ) . '" href="' . esc_url( $btn_2_link ) . '" class="ac-btn btn-biggest ac-btn-2nd">' . esc_html( $btn_2_text ) . '</a>';
    		break;

    		// Two - opaque
    		case 'btns-2-opaque' :
    			$output .= '<a target="' . esc_attr( $btn_1_target ) . '" href="' . esc_url( $btn_1_link ) . '" class="ac-btn btn-biggest ac-btn-1st btn-opaque">' . esc_html( $btn_1_text ) . '</a>';
    			if( $btns_between != '' ) {
    				$output .= '<span class="ac-btns-or fw-bolder">' . esc_html( $btns_between ) . '</span>'; }
    			$output .= '<a target="' . esc_attr( $btn_2_target ) . '" href="' . esc_url( $btn_2_link ) . '" class="ac-btn btn-biggest ac-btn-2nd btn-opaque">' . esc_html( $btn_2_text ) . '</a>';
    		break;

    		// Two - default + opaque
    		case 'btns-2-def-op' :
    			$output .= '<a target="' . esc_attr( $btn_1_target ) . '" href="' . esc_url( $btn_1_link ) . '" class="ac-btn btn-biggest ac-btn-1st">' . esc_html( $btn_1_text ) . '</a>';
    			if( $btns_between != '' ) {
    				$output .= '<span class="ac-btns-or fw-bolder">' . esc_html( $btns_between ) . '</span>'; }
    			$output .= '<a target="' . esc_attr( $btn_2_target ) . '" href="' . esc_url( $btn_2_link ) . '" class="ac-btn btn-biggest ac-btn-2nd btn-opaque">' . esc_html( $btn_2_text ) . '</a>';
    		break;

    		// Two - opaque + default
    		case 'btns-2-op-def' :
    			$output .= '<a target="' . esc_attr( $btn_1_target ) . '" href="' . esc_url( $btn_1_link ) . '" class="ac-btn btn-biggest ac-btn-1st btn-opaque">' . esc_html( $btn_1_text ) . '</a>';
    			if( $btns_between != '' ) {
    				$output .= '<span class="ac-btns-or fw-bolder">' . esc_html( $btns_between ) . '</span>'; }
    			$output .= '<a target="' . esc_attr( $btn_2_target ) . '" href="' . esc_url( $btn_2_link ) . '" class="ac-btn btn-biggest ac-btn-2nd">' . esc_html( $btn_2_text ) . '</a>';
    		break;

    		// Default
    		default : $output .= '';
    	}

    	return apply_filters( 'businessx_hero___btns_output', $output );

    }
}



/*  Slider buttons output
/* ------------------------------------ */
if( ! function_exists( 'businessx_slider_btns_output' ) ) {
    function businessx_slider_btns_output( $type = 'btns-2-def-op', $btns_between = ' ', $btn_1_text = '', $btn_1_link = '', $btn_1_target = false, $btn_2_text = '', $btn_2_link = '', $btn_2_target = false ) {
    	$btn_1_text 	= ! empty( $btn_1_text ) ? $btn_1_text : esc_html__( 'Call to Action #1', 'businessx-extensions' );
    	$btn_1_link 	= ! empty( $btn_1_link ) ? $btn_1_link : '#';
    	$btn_1_target	= $btn_1_target ? '_blank' : '_self';
    	$btn_2_text 	= ! empty( $btn_2_text ) ? $btn_2_text : esc_html__( 'Call to Action #2', 'businessx-extensions' );
    	$btn_2_link 	= ! empty( $btn_2_link ) ? $btn_2_link : '#';
    	$btn_2_target	= $btn_2_target ? '_blank' : '_self';
    	$output = '';

    	switch( $type ) {
    		// One button - default
    		case 'btns-1-default' :
    			$output .= '<a target="' . esc_attr( $btn_1_target ) . '" href="' . esc_url( $btn_1_link ) . '" class="ac-btn btn-biggest ac-btn-1st">' . esc_html( $btn_1_text ) . '</a>';
    		break;

    		// One button - opaque
    		case 'btns-1-opaque' :
    			$output .= '<a target="' . esc_attr( $btn_1_target ) . '" href="' . esc_url( $btn_1_link ) . '" class="ac-btn btn-biggest ac-btn-2nd btn-opaque">' . esc_html( $btn_1_text ) . '</a>';
    		break;

    		// One large - default
    		case 'btns-1-l-default' :
    			$output .= '<a target="' . esc_attr( $btn_1_target ) . '" href="' . esc_url( $btn_1_link ) . '" class="ac-btn btn-biggest ac-btn-1st btn-width-50">' . esc_html( $btn_1_text ) . '</a>';
    		break;

    		// One large - opaque
    		case 'btns-1-l-opaque' :
    			$output .= '<a target="' . esc_attr( $btn_1_target ) . '" href="' . esc_url( $btn_1_link ) . '" class="ac-btn btn-biggest ac-btn-2nd btn-width-50 btn-opaque">' . esc_html( $btn_1_text ) . '</a>';
    		break;

    		// Two - default
    		case 'btns-2-default' :
    			$output .= '<a target="' . esc_attr( $btn_1_target ) . '" href="' . esc_url( $btn_1_link ) . '" class="ac-btn btn-biggest ac-btn-1st">' . esc_html( $btn_1_text ) . '</a>';
    			if( $btns_between != '' ) {
    				$output .= '<span class="ac-btns-or fw-bolder">' . esc_html( $btns_between ) . '</span>'; }
    			$output .= '<a target="' . esc_attr( $btn_2_target ) . '" href="' . esc_url( $btn_2_link ) . '" class="ac-btn btn-biggest ac-btn-1st">' . esc_html( $btn_2_text ) . '</a>';
    		break;

    		// Two - opaque
    		case 'btns-2-opaque' :
    			$output .= '<a target="' . esc_attr( $btn_1_target ) . '" href="' . esc_url( $btn_1_link ) . '" class="ac-btn btn-biggest ac-btn-2nd btn-opaque">' . esc_html( $btn_1_text ) . '</a>';
    			if( $btns_between != '' ) {
    				$output .= '<span class="ac-btns-or fw-bolder">' . esc_html( $btns_between ) . '</span>'; }
    			$output .= '<a target="' . esc_attr( $btn_2_target ) . '" href="' . esc_url( $btn_2_link ) . '" class="ac-btn btn-biggest ac-btn-2nd btn-opaque">' . esc_html( $btn_2_text ) . '</a>';
    		break;

    		// Two - default + opaque
    		case 'btns-2-def-op' :
    			$output .= '<a target="' . esc_attr( $btn_1_target ) . '" href="' . esc_url( $btn_1_link ) . '" class="ac-btn btn-biggest ac-btn-1st">' . esc_html( $btn_1_text ) . '</a>';
    			if( $btns_between != '' ) {
    				$output .= '<span class="ac-btns-or fw-bolder">' . esc_html( $btns_between ) . '</span>'; }
    			$output .= '<a target="' . esc_attr( $btn_2_target ) . '" href="' . esc_url( $btn_2_link ) . '" class="ac-btn btn-biggest ac-btn-2nd btn-opaque">' . esc_html( $btn_2_text ) . '</a>';
    		break;

    		// Two - opaque + default
    		case 'btns-2-op-def' :
    			$output .= '<a target="' . esc_attr( $btn_1_target ) . '" href="' . esc_url( $btn_1_link ) . '" class="ac-btn btn-biggest ac-btn-2nd btn-opaque">' . esc_html( $btn_1_text ) . '</a>';
    			if( $btns_between != '' ) {
    				$output .= '<span class="ac-btns-or fw-bolder">' . esc_html( $btns_between ) . '</span>'; }
    			$output .= '<a target="' . esc_attr( $btn_2_target ) . '" href="' . esc_url( $btn_2_link ) . '" class="ac-btn btn-biggest ac-btn-1st">' . esc_html( $btn_2_text ) . '</a>';
    		break;

    		// Default
    		default : $output .= '';
    	}

    	return apply_filters( 'businessx_slider___btns_output', $output );

    }
}



/*  Slider buttons options
/* ------------------------------------ */
if( ! function_exists( 'businessx_slider_btns_select' ) ) {
    function businessx_slider_btns_select( $just_values = false ) {
    	if( ! $just_values ) {
    		$options = apply_filters( 'businessx_slider_btns___select', $options = array(
    				array(
    					'value' 	=> 'btns-1-default',
    					'title'		=> esc_html__( 'One - Default', 'businessx-extensions' ),
    					'disabled'	=> false
    				),
    				array(
    					'value' 	=> 'btns-1-opaque',
    					'title'		=> esc_html__( 'One - Opaque', 'businessx-extensions' ),
    					'disabled'	=> false
    				),
    				array(
    					'value' 	=> 'btns-1-l-default',
    					'title'		=> esc_html__( 'One Large - Default', 'businessx-extensions' ),
    					'disabled'	=> false
    				),
    				array(
    					'value' 	=> 'btns-1-l-opaque',
    					'title'		=> esc_html__( 'One Large - Opaque', 'businessx-extensions' ),
    					'disabled'	=> false
    				),
    				array(
    					'value' 	=> 'btns-2-default',
    					'title'		=> esc_html__( 'Two - Default', 'businessx-extensions' ),
    					'disabled'	=> false
    				),
    				array(
    					'value' 	=> 'btns-2-opaque',
    					'title'		=> esc_html__( 'Two - Opaque', 'businessx-extensions' ),
    					'disabled'	=> false
    				),
    				array(
    					'value' 	=> 'btns-2-def-op',
    					'title'		=> esc_html__( 'Two - Default + Opaque', 'businessx-extensions' ),
    					'disabled'	=> false
    				),
    				array(
    					'value' 	=> 'btns-2-op-def',
    					'title'		=> esc_html__( 'Two - Opaque + Default', 'businessx-extensions' ),
    					'disabled'	=> false
    				),
    		) );
    	} else {
    		$options = apply_filters( 'businessx_slider_btns___select_values', $options = array(
    			'btns-1-default', 'btns-1-opaque', 'btns-1-l-default', 'btns-1-l-opaque', 'btns-2-default', 'btns-2-opaque', 'btns-2-def-op', 'btns-2-op-def'
    		) );
    	}

    	return $options;
    }
}
endif; // Backwards compatibility END
