<?php
/* ------------------------------------------------------------------------- *
 *  Output styles generated/saved by sections
/* ------------------------------------------------------------------------- */


/*  Check default
/* ------------------------------------ */
if ( ! function_exists( 'businessx_cdefault' ) ) {
	function businessx_cdefault( $option, $default ) {
		if( isset( $option ) && $option != '' && $option != $default ) {
			return true;
		}
	}
}


/*  Features section
/* ------------------------------------ */
if ( ! function_exists( 'businessx_features_css_output' ) ) {
	function businessx_features_css_output() {
		
		$disabled = get_theme_mod( 'features_section_hide', false );
		$widget = get_option( 'widget_bx-item-features' );
			unset( $widget['_multiwidget'] );
			
		if( ! $disabled ) {
			if ( count( $widget ) >= 1 ) {
				
				$custom_css = '';
				$default = apply_filters( 'businessx_extensions_features_item___color', '#bc1c36' );
				
				foreach( $widget as $widgetID => $value ) {
					$color = array_key_exists( 'color', $value ) ? $value['color'] : '';
					if( businessx_cdefault( $color, $default ) ) {
						$wid = '#bx-item-features-' . $widgetID;
						$custom_css .= $wid . ' .ac-btn-alt{border-color:' . businessx_sanitize_hex( $color ) . ';}';
						$custom_css .= $wid . ' .sec-feature-figure i{border-color:' . businessx_sanitize_hex( $color ) . '; color:' . businessx_sanitize_hex( $color ) . ';}';
						$custom_css .= $wid . ' a:not(.ac-btn-alt),' . $wid . ' a:not(.ac-btn-alt):hover,' . $wid . ' a:not(.ac-btn-alt):focus,' . $wid . ' a:not(.ac-btn-alt):active{color:' . businessx_sanitize_hex( $color ) . ';}';
					}
				}
				
				if( ! is_customize_preview() ) {
				wp_add_inline_style( 'businessx-style', businessx_sanitize_css( $custom_css ) ); }
			
			}
		}
		
	}
}
add_action( 'wp_enqueue_scripts', 'businessx_features_css_output', 100 );


/*  Actions section
/* ------------------------------------ */
if ( ! function_exists( 'businessx_actions_css_output' ) ) {
	function businessx_actions_css_output() {
		
		$disabled = get_theme_mod( 'actions_section_hide', false );
		$widget = get_option( 'widget_bx-item-actions' );
			unset( $widget['_multiwidget'] );
		
		if( ! $disabled ) {
			if ( count( $widget ) >= 1 ) {
				
				$custom_css = '';
				$btn_1_bg_def 			= apply_filters( 'businessx_extensions_actions_item___btn1bg', '#eeb120' );
				$btn_1_hover_def 		= apply_filters( 'businessx_extensions_actions_item___btn1hover', '#ffbc21' );
				$btn_1_active_def 		= apply_filters( 'businessx_extensions_actions_item___btn1active', '#dba21d' );
				$btn_2_bg_def 			= apply_filters( 'businessx_extensions_actions_item___btn2bg', '#eeb120' );
				$btn_2_hover_def 		= apply_filters( 'businessx_extensions_actions_item___btn2hover', '#ffbc21' );
				$btn_2_active_def 		= apply_filters( 'businessx_extensions_actions_item___btn2active', '#dba21d' );
				$title_color_def		= apply_filters( 'businessx_extensions_actions_item___titlecolor', '#ffffff' );
				$links_color_def		= apply_filters( 'businessx_extensions_actions_item___linkscolor', '#ffeb3b' );
				$excerpt_color_def		= apply_filters( 'businessx_extensions_actions_item___excerptcolor', '#ffffff' );
				$background_color_def	= apply_filters( 'businessx_extensions_actions_item___backgroundcolor', '#df3034' );
				$background_image_def	= '';
				$overlay_color_def		= apply_filters( 'businessx_extensions_actions_item___overlaycolor', '#000000' );
				$parallax_def			= false;
				
				foreach( $widget as $widgetID => $value ) {
					$wid = '#bx-item-actions-' . $widgetID; 
					
					$btn_1_bg = array_key_exists( 'btn_1_bg', $value ) ? $value['btn_1_bg'] : '';
					$btn_1_hover = array_key_exists( 'btn_1_hover', $value ) ? $value['btn_1_hover'] : '';
					$btn_1_active = array_key_exists( 'btn_1_active', $value ) ? $value['btn_1_active'] : '';
					$btn_2_bg = array_key_exists( 'btn_2_bg', $value ) ? $value['btn_2_bg'] : '';
					$btn_2_hover = array_key_exists( 'btn_2_hover', $value ) ? $value['btn_2_hover'] : '';
					$btn_2_active = array_key_exists( 'btn_2_active', $value ) ? $value['btn_2_active'] : '';
					$title_color = array_key_exists( 'title_color', $value ) ? $value['title_color'] : '';
					$excerpt_color = array_key_exists( 'excerpt_color', $value ) ? $value['excerpt_color'] : '';
					$links_color = array_key_exists( 'links_color', $value ) ? $value['links_color'] : '';
					$background_color = array_key_exists( 'background_color', $value ) ? $value['background_color'] : '';
					$background_image = array_key_exists( 'background_image', $value ) ? $value['background_image'] : '';
					$overlay_color = array_key_exists( 'overlay_color', $value ) ? $value['overlay_color'] : '';
					$parallax = array_key_exists( 'parallax', $value ) ? $value['parallax'] : '';

					// Background
					if( ! $parallax ) {
						if( businessx_cdefault( $background_color, $background_color_def ) ) {
							$custom_css .= $wid . '{background-color:' . businessx_sanitize_hex( $background_color ) . '}'; }
						if( businessx_cdefault( $background_image, $background_image_def ) ) {
							$custom_css .= $wid . '{background-image:url("' . esc_url( $background_image ) . '")}'; }
					} else {
						$custom_css .= $wid . '{background-color:transparent!important;}'; }
					if( businessx_cdefault( $overlay_color, $overlay_color_def ) ) {
						$custom_css .= $wid . ' .grid-overlay {background-color:' . businessx_sanitize_hex( $overlay_color ) . '}'; }
						
					// Heading + text
					if( businessx_cdefault( $excerpt_color, $excerpt_color_def ) ) {
						$custom_css .= $wid . '{color:' . businessx_sanitize_hex( $excerpt_color ) . '}'; }
					if( businessx_cdefault( $title_color, $title_color_def ) ) {
						$custom_css .= $wid . ' h2{color:' . businessx_sanitize_hex( $title_color ) . '}'; }
					if( businessx_cdefault( $links_color, $links_color_def ) ) {
						$custom_css .= $wid . ' a:not(.ac-btn), ' . $wid . ' a:not(.ac-btn):hover, ' . $wid . ' a:not(.ac-btn):focus, ' . $wid . ' a:not(.ac-btn):active { color: ' . businessx_sanitize_hex( $links_color ) . ' }'; }
						
					// Button #1
					if( businessx_cdefault( $btn_1_bg, $btn_1_bg_def ) ) {
						$custom_css .= $wid . ' .btn-1{background-color:' . businessx_sanitize_hex( $btn_1_bg ) . '}'; }
					if( businessx_cdefault( $btn_1_hover, $btn_1_hover_def ) ) {
						$custom_css .= $wid . ' .btn-1:hover{background-color:' . businessx_sanitize_hex( $btn_1_hover ) . '}'; }
					if( businessx_cdefault( $btn_1_active, $btn_1_active_def ) ) {
						$custom_css .= $wid . ' .btn-1:focus,' .$wid . ' .btn-1:active{background-color:' . businessx_sanitize_hex( $btn_1_active ) . '}'; }
					
					// Button #2	
					if( businessx_cdefault( $btn_2_bg, $btn_2_bg_def ) ) {
						$custom_css .= $wid . ' .btn-2{background-color:' . businessx_sanitize_hex( $btn_2_bg ) . '}'; }
					if( businessx_cdefault( $btn_2_hover, $btn_2_hover_def ) ) {
						$custom_css .= $wid . ' .btn-2:hover{background-color:' . businessx_sanitize_hex( $btn_2_hover ) . '}'; }
					if( businessx_cdefault( $btn_2_active, $btn_2_active_def ) ) {
						$custom_css .= $wid . ' .btn-2:focus,' . $wid . ' .btn-2:active{background-color:' . businessx_sanitize_hex( $btn_2_active ) . '}'; }
						
				}
				
				if( ! is_customize_preview() ) {
				wp_add_inline_style( 'businessx-style', businessx_sanitize_css( $custom_css ) ); }
			
			}
		}
		
	}
}
add_action( 'wp_enqueue_scripts', 'businessx_actions_css_output', 100 );


/*  Pricing section
/* ------------------------------------ */
if ( ! function_exists( 'businessx_pricing_css_output' ) ) {
	function businessx_pricing_css_output() {
		
		$disabled = get_theme_mod( 'pricing_section_hide', false );
		$widget = get_option( 'widget_bx-item-pricing' );
			unset( $widget['_multiwidget'] );
		
		if( ! $disabled ) {
			if ( count( $widget ) >= 1 ) {

				$custom_css = '';
				$item_bg_def 			= apply_filters( 'businessx_extensions_pricing_item___bg_color', '#4eb5d5' );
				$item_btn_def			= apply_filters( 'businessx_extensions_pricing_item___btn_bg', '#76bc1c' );
				$item_btn_hover_def		= apply_filters( 'businessx_extensions_pricing_item___btn_hover_bg', '#82cf1f' );
				$item_btn_active_def	= apply_filters( 'businessx_extensions_pricing_item___btn_active_bg', '#69a619' );
				$item_icon_av_def		= apply_filters( 'businessx_extensions_pricing_item___icon_av', '#c3ef93' );
				$item_icon_unav_def		= apply_filters( 'businessx_extensions_pricing_item___icon_unav', '#ef9393' );
				$item_badge_def			= apply_filters( 'businessx_extensions_pricing_item___badge', '#c17ee0' );
				$item_badge_text_def	= apply_filters( 'businessx_extensions_pricing_item___badge_text', '#ffffff' );
				$list_bg_def			= apply_filters( 'businessx_extensions_pricing_list___bg', '#ffffff' );
				$list_color_def			= apply_filters( 'businessx_extensions_pricing_list___color', '#636363' );
				$details_def			= apply_filters( 'businessx_extensions_pricing_box___details', '#ffffff' );
				
				foreach( $widget as $widgetID => $value ) {
					$wid = '#bx-item-pricing-' . $widgetID; 
					
					$item_bg 			= array_key_exists( 'item_bg', $value ) ? $value['item_bg'] : '';
					$item_btn 			= array_key_exists( 'item_btn', $value ) ? $value['item_btn'] : '';
					$item_btn_hover 	= array_key_exists( 'item_btn_hover', $value ) ? $value['item_btn_hover'] : '';
					$item_btn_active 	= array_key_exists( 'item_btn_active', $value ) ? $value['item_btn_active'] : '';
					$item_icon_av 		= array_key_exists( 'item_icon_av', $value ) ? $value['item_icon_av'] : '';
					$item_icon_unav 	= array_key_exists( 'item_icon_unav', $value ) ? $value['item_icon_unav'] : '';
					$item_badge 		= array_key_exists( 'item_badge', $value ) ? $value['item_badge'] : '';
					$item_badge_text 	= array_key_exists( 'item_badge_text', $value ) ? $value['item_badge_text'] : '';
					$list_bg 			= array_key_exists( 'list_bg', $value ) ? $value['list_bg'] : '';
					$list_color 		= array_key_exists( 'list_color', $value ) ? $value['list_color'] : '';
					$details			= array_key_exists( 'details', $value ) ? $value['details'] : '';
						
					// Box background color
					if( businessx_cdefault( $item_bg, $item_bg_def ) ) {
						$custom_css .= $wid . '.sec-pricing-box { background-color:' . businessx_sanitize_hex( $item_bg ) . '}'; }
					
					// Button colors
					if( businessx_cdefault( $item_btn, $item_btn_def ) ) {
						$custom_css .= $wid . ' .ac-btn { background-color:' . businessx_sanitize_hex( $item_btn ) . '; }'; }
					if( businessx_cdefault( $item_btn_hover, $item_btn_hover_def ) ) {
						$custom_css .= $wid . ' .ac-btn:hover { background-color:' . businessx_sanitize_hex( $item_btn_hover ) . '; }'; }
					if( businessx_cdefault( $item_btn_active, $item_btn_active_def ) ) {
						$custom_css .= $wid . ' .ac-btn:focus, ' . $wid . ' .ac-btn:active { background-color:' . businessx_sanitize_hex( $item_btn_active ) . '; }'; }
						
					// Icons colors
					if( businessx_cdefault( $item_icon_av, $item_icon_av_def ) ) {
						$custom_css .= $wid . '.sec-pricing-box ul i.fa-check { color:' . businessx_sanitize_hex( $item_icon_av ) . '; }'; }
					if( businessx_cdefault( $item_icon_unav, $item_icon_unav_def ) ) {
						$custom_css .= $wid . '.sec-pricing-box ul i.fa-remove { color:' . businessx_sanitize_hex( $item_icon_unav ) . '; }'; }
						
					// Badge color
					if( businessx_cdefault( $item_badge, $item_badge_def ) ) {
						$custom_css .= $wid . '.sec-pricing-box .package-badge .badge { background-color:' . businessx_sanitize_hex( $item_badge ) . '; }'; }
					if( businessx_cdefault( $item_badge_text, $item_badge_text_def ) ) {
						$custom_css .= $wid . '.sec-pricing-box .package-badge .badge { color:' . businessx_sanitize_hex( $item_badge_text ) . '; }'; }
					
					// List colors
					if( businessx_cdefault( $list_bg, $list_bg_def ) ) {
						$custom_css .= $wid . '.sec-pricing-box .package-contents { background-color:' . businessx_sanitize_hex( $list_bg ) . '; }'; }	
					if( businessx_cdefault( $list_color, $list_color_def ) ) {
						$custom_css .= $wid . '.sec-pricing-box { color:' . businessx_sanitize_hex( $list_color ) . '; }'; }
					
					// Details colors	
					if( businessx_cdefault( $details, $details_def ) ) {
						$custom_css .= $wid . '.sec-pricing-box .package-info, ' . $wid . '.sec-pricing-box .package-info h4 { color:' . businessx_sanitize_hex( $details ) . '; }';
						$custom_css .= $wid . '.sec-pricing-box .package-info h4 { border-color: rgba(' . businessx_hex2rgb( businessx_sanitize_hex( $details ) ) . ',0.5); }'; }
						
				}
				
				if( ! is_customize_preview() ) {
				wp_add_inline_style( 'businessx-style', businessx_sanitize_css( $custom_css ) ); }
			
			}
		}
		
	}
}
add_action( 'wp_enqueue_scripts', 'businessx_pricing_css_output', 100 );


/*  Slider section
/* ------------------------------------ */
if ( ! function_exists( 'businessx_slider_css_output' ) ) {
	function businessx_slider_css_output() {
		
		$disabled = get_theme_mod( 'slider_section_hide', false );
		$widget = get_option( 'widget_bx-item-slider' );
			unset( $widget['_multiwidget'] );
		
		if( ! $disabled ) {
			if ( count( $widget ) >= 1 ) {

				$custom_css = '';
				$background_def 		= '';
				$btn_1_bg_def			= apply_filters( 'businessx_extensions_slider_item___btn_1_bg', '#76bc1c' );
				$btn_1_bgh_def			= apply_filters( 'businessx_extensions_slider_item___btn_1_bg_hover', '#82cf1f' );
				$btn_1_bgf_def			= apply_filters( 'businessx_extensions_slider_item___btn_1_bg_focus', '#69a619' );
				$btn_2_bg_def			= apply_filters( 'businessx_extensions_slider_item___btn_2_bg', '#1c82bc' );
				$btn_2_bgh_def			= apply_filters( 'businessx_extensions_slider_item___btn_2_bg_hover', '#1c82bc' );
				$btn_2_bgf_def			= apply_filters( 'businessx_extensions_slider_item___btn_2_bg_focus', '#1972a6' );
				$btn_2_border_def		= apply_filters( 'businessx_extensions_slider_item___btn_2_border', '#1c82bc' );
				$btn_2_bgo_def			= '0.5';
				$h2_color_def			= apply_filters( 'businessx_extensions_slider_item___h2_color', '#ffffff' );
				$p_color_def			= apply_filters( 'businessx_extensions_slider_item___p_color', '#ffffff' );
				$p_opacity_def			= '0.9';
				$text_shadow_def		= '0.7';

				foreach( $widget as $widgetID => $value ) {
					$wid = '#bx-item-slider-' . $widgetID; 
					
					$background 		= array_key_exists( 'background', $value ) ? $value['background'] : '';
					$btn_1_bg			= array_key_exists( 'btn_1_bg', $value ) ? $value['btn_1_bg'] : '';
					$btn_1_bgh			= array_key_exists( 'btn_1_bgh', $value ) ? $value['btn_1_bgh'] : '';
					$btn_1_bgf			= array_key_exists( 'btn_1_bgf', $value ) ? $value['btn_1_bgf'] : '';
					$btn_2_bg			= array_key_exists( 'btn_2_bg', $value ) ? $value['btn_2_bg'] : '';
					$btn_2_bgh			= array_key_exists( 'btn_2_bgh', $value ) ? $value['btn_2_bgh'] : '';
					$btn_2_bgf			= array_key_exists( 'btn_2_bgf', $value ) ? $value['btn_2_bgf'] : '';
					$btn_2_border		= array_key_exists( 'btn_2_border', $value ) ? $value['btn_2_border'] : '';
					$btn_2_bgo			= array_key_exists( 'btn_2_bgo', $value ) ? $value['btn_2_bgo'] : '';
					$h2_color			= array_key_exists( 'h2_color', $value ) ? $value['h2_color'] : '';
					$p_color			= array_key_exists( 'p_color', $value ) ? $value['p_color'] : '';
					$p_opacity			= array_key_exists( 'p_opacity', $value ) ? $value['p_opacity'] : '';
					$text_shadow		= array_key_exists( 'text_shadow', $value ) ? $value['text_shadow'] : '';
						
					// Slide background image
					if( businessx_cdefault( $background, $background_def ) ) {
					$custom_css .= $wid . ' { background-image: url("' . esc_url( $background ) . '"); }'; }
					
					// Button #1 options
					if( businessx_cdefault( $btn_1_bg, $btn_1_bg_def ) ) {
					$custom_css .= $wid . ' .ac-btn-1st { background-color: ' . businessx_sanitize_hex( $btn_1_bg ) . '; }'; }
					if( businessx_cdefault( $btn_1_bgh, $btn_1_bgh_def ) ) {
					$custom_css .= $wid . ' .ac-btn-1st:hover { background-color: ' . businessx_sanitize_hex( $btn_1_bgh ) . '; }'; }
					if( businessx_cdefault( $btn_1_bgf, $btn_1_bgf_def ) ) {
					$custom_css .= $wid . ' .ac-btn-1st:focus, ' . $wid . ' .ac-btn-1st:active { background-color: ' . businessx_sanitize_hex( $btn_1_bgf ) . '; }'; }
					
					// Button #2 options
					if( businessx_cdefault( $btn_2_bg, $btn_2_bg_def ) || businessx_cdefault( $btn_2_bgo, $btn_2_bgo_def ) ) {
					$custom_css .= $wid . ' .ac-btn-2nd { background-color: rgba(' . esc_html( businessx_hex2rgb( $btn_2_bg ) ) . ',' . esc_html( $btn_2_bgo ) . '); }'; }
					if( businessx_cdefault( $btn_2_bgh, $btn_2_bgh_def ) ) {
					$custom_css .= $wid . ' .ac-btn-2nd:hover { background-color: ' . businessx_sanitize_hex( $btn_2_bgh ) . '; }'; }
					if( businessx_cdefault( $btn_2_bgf, $btn_2_bgf_def ) ) {
					$custom_css .= $wid . ' .ac-btn-2nd:focus, ' . $wid . ' .ac-btn-2nd:active { background-color: ' . businessx_sanitize_hex( $btn_2_bgf ) . '; }'; }
					if( businessx_cdefault( $btn_2_border, $btn_2_border_def ) ) {
					$custom_css .= $wid . ' .ac-btn-2nd { box-shadow: inset 0 0 0 3px rgba(' . esc_html( businessx_hex2rgb( $btn_2_border ) ) . ',1); }'; }
					
					// Other options
					if( businessx_cdefault( $h2_color, $h2_color_def ) ) {
					$custom_css .= $wid . ' .sec-hs-elements .hs-primary-large { color: ' . esc_html( $h2_color ) . '; }'; }
					if( businessx_cdefault( $p_color, $p_color_def ) ) {
					$custom_css .= $wid . ' .sec-hs-elements .sec-hs-description, ' . $wid . ' .sec-hs-elements .ac-btns-or  { color: ' . esc_html( $p_color ) . '; }'; }
					if( businessx_cdefault( $p_opacity, $p_opacity_def ) ) {
					$custom_css .= $wid . ' .sec-hs-elements .sec-hs-description, ' . $wid . ' .sec-hs-elements .ac-btns-or  { opacity: ' . esc_html( $p_opacity ) . '; }'; }
					if( businessx_cdefault( $text_shadow, $text_shadow_def ) ) {
					$custom_css .= $wid . ' .sec-hs-elements .hs-primary-large, ' . $wid . ' .sec-hs-elements .sec-hs-description, ' . $wid . ' .sec-hs-elements .ac-btns-or { text-shadow: 0 1px 2px rgba(0,0,0,' . esc_html( $text_shadow ) . '); }'; }
		
				}
				
				if( ! is_customize_preview() ) {
				wp_add_inline_style( 'businessx-style', businessx_sanitize_css( $custom_css ) ); }
			
			}
		}
		
	}
}
add_action( 'wp_enqueue_scripts', 'businessx_slider_css_output', 100 );