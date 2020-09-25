<?php
/* ------------------------------------------------------------------------- *
 *
 *  Features Section Item
 *  ________________
 *
 *	Adds a "Feature" - title, icon or image, a few lines of text and a
 *	button
 *	________________
 *
/* ------------------------------------------------------------------------- */

if( ! class_exists( 'Businessx_Extensions_Features_Item' ) ) {
	class Businessx_Extensions_Features_Item extends Businessx_Extensions_Base {

		protected $defaults;
		protected $allowed_html = array(
			'a' => array(
				'href' => array(),
				'title' => array()
			),
			'br' => array(),
			'em' => array(),
			'strong' => array(),
		);


		/*  Constructor
		/* ------------------------------------ */
		function __construct() {

			// Variables
			$this->widget_title = __( 'BX: Feature' , 'businessx-extensions' );
			$this->widget_id = 'features';

			// Settings
			$widget_ops = array(
				'classname' => 'sec-feature',
				'description' => esc_html__( 'Adds a "Feature" - title, icon or image, a few lines of text and a button', 'businessx-extensions' ),
				'customize_selective_refresh' => true
			);

			// Control settings
			$control_ops = array( 'width' => NULL, 'height' => NULL, 'id_base' => 'bx-item-' . $this->widget_id );

			// Create the widget
			parent::__construct( 'bx-item-' . $this->widget_id, $this->widget_title, $widget_ops, $control_ops );

			// Set some widget defaults
			$this->defaults = array (
				'title'			=> '',
				'excerpt'		=> '',
				'show_figure'	=> true,
				'figure_type'	=> 'ft-icon',
				'figure_icon'	=> '',
				'figure_image'	=> '',
				'btn_anchor'	=> '',
				'btn_url'		=> '',
				'btn_target'	=> '_self',
				'color'			=> apply_filters( 'businessx_extensions_features_item___color', '#bc1c36' )
			);

		}


		/*  Front-end display
		/* ------------------------------------ */
		public function widget( $args, $instance ) {
			// Turn $args array into variables.
			extract( $args );

			// $instance Defaults
			$instance_defaults = $this->defaults;

			// Parse $instance
			$instance = wp_parse_args( $instance, $instance_defaults );

			// Options
			$title 			= apply_filters( 'widget_title', empty( $instance[ 'title' ] ) ? '' : $instance[ 'title' ], $instance, $this->id_base ); set_query_var( 'title', $title );
			$excerpt	 	= ! empty( $instance[ 'excerpt' ] ) ? $instance[ 'excerpt' ] : ''; set_query_var( 'excerpt', $excerpt );
			$show_figure	= ! empty( $instance[ 'show_figure' ] ) ? 1 : 0; set_query_var( 'show_figure', $show_figure );
			$figure_type	= ! empty( $instance[ 'figure_type' ] ) ? $instance[ 'figure_type' ] : 'ft-icon'; set_query_var( 'figure_type', $figure_type );
			$figure_icon	= ! empty( $instance[ 'figure_icon' ] ) ? $instance[ 'figure_icon' ] : ''; set_query_var( 'figure_icon', $figure_icon );
			$figure_image	= ! empty( $instance[ 'figure_image' ] ) ? $instance[ 'figure_image' ] : ''; set_query_var( 'figure_image', $figure_image );
			$btn_anchor		= ! empty( $instance[ 'btn_anchor' ] ) ? $instance[ 'btn_anchor' ] : ''; set_query_var( 'btn_anchor', $btn_anchor );
			$btn_url		= ! empty( $instance[ 'btn_url' ] ) ? $instance[ 'btn_url' ] : ''; set_query_var( 'btn_url', $btn_url );
			$btn_target		= ! empty( $instance[ 'btn_target' ] ) ? $instance[ 'btn_target' ] : '_self'; set_query_var( 'btn_target', $btn_target );
			$color			= ! empty( $instance[ 'color' ] ) ? $instance[ 'color' ] : ''; set_query_var( 'color', $color );

			// Some variables
			$wid = $this->number; set_query_var( 'wid', $wid );
			$title_output = ! empty( $title ) ? $args['before_title'] . $title . $args['after_title'] : '';
			$allowed_html = apply_filters( 'businessx_extensions_features_item___allowed_html', $allowed_html = $this->allowed_html );
			set_query_var( 'title_output', $title_output );
			set_query_var( 'allowed_html', $allowed_html );

			// Add more widget classes
			$css_class = array();
			$css_class[] = 'grid-col';
			$css_class[] = 'grid-1x-col';
			$css_class = apply_filters( 'businessx_extensions_features_item___css_classes', $css_class );
			$css_classes = join(' ', $css_class);

			if ( ! empty( $css_classes ) ) {
				if( strpos($args['before_widget'], 'class') === false ) {
					$args[ 'before_widget' ] = str_replace( '>', 'class="'. esc_attr( $css_classes ) . '"', $args[ 'before_widget' ] );
				} else {
					$args[ 'before_widget' ] = str_replace( 'class="', 'class="'. esc_attr( $css_classes ) . ' ', $args[ 'before_widget' ] );
				}
			}

			// Widget template output
			echo $args['before_widget'];

				ob_start();

				businessx_extensions_get_template_part( 'sections-items/item', 'features' );

				echo ob_get_clean();

				self::customizer_css( $instance ); // Output styles just for the customizer/selective refresh

			echo $args['after_widget'];

		}


		/*  Update Widget
		/* ------------------------------------ */
		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			// Variables
			$allowed_html = apply_filters( 'businessx_extensions_features_item___allowed_html', $allowed_html = $this->allowed_html );

			// Fields
			$instance[ 'title' ] 		= sanitize_text_field( $new_instance[ 'title' ] );
			$instance[ 'btn_anchor' ] 	= sanitize_text_field( $new_instance[ 'btn_anchor' ] );
			$instance[ 'btn_url' ] 		= esc_url_raw( $new_instance[ 'btn_url' ] );
			$instance[ 'figure_icon' ] 	= sanitize_text_field( $new_instance[ 'figure_icon' ] );
			$instance[ 'figure_image' ] = esc_url_raw( $new_instance[ 'figure_image' ] );
			$instance[ 'color' ] 		= sanitize_text_field( $new_instance[ 'color' ] );

			// Checkboxes
			$instance[ 'show_figure' ]	= ! empty( $new_instance[ 'show_figure' ] ) ? 1 : 0;

			// Select
			$instance[ 'figure_type'] 	= businessx_sanitize_select( $new_instance[ 'figure_type' ], array( 'ft-icon', 'ft-image' ), $this->defaults[ 'figure_type' ], false  );
			$instance[ 'btn_target'] 	= businessx_sanitize_select( $new_instance[ 'btn_target' ], array( '_self', '_blank' ), $this->defaults[ 'btn_target' ], false  );

			// Text Area
			if ( current_user_can('unfiltered_html') ) {
				$instance[ 'excerpt' ] =  businessx_content_filter( $new_instance[ 'excerpt' ], $allowed_html );
			} else {
				$instance[ 'excerpt' ] = wp_kses_post( stripslashes( $new_instance[ 'excerpt' ] ) );
			}

			// Return
			return $instance;
		}


		/*  Widget's Form
		/* ------------------------------------ */
		public function form( $instance ) {
			// Parse $instance
			$instance_defaults = $this->defaults;
			$instance = wp_parse_args( $instance, $instance_defaults );
			extract( $instance, EXTR_SKIP );

			// Variables
			$title 			= $instance[ 'title' ];
			$excerpt 		= $instance[ 'excerpt' ];
			$show_figure 	= isset( $instance['show_figure'] ) ? (bool) $instance['show_figure'] : false;
			$figure_type	= $instance[ 'figure_type' ];
			$figure_icon	= $instance[ 'figure_icon' ];
			$figure_image	= $instance[ 'figure_image' ];
			$btn_anchor 	= $instance[ 'btn_anchor' ];
			$btn_url 		= $instance[ 'btn_url' ];
			$btn_target		= $instance[ 'btn_target' ];
			$color			= $instance[ 'color' ];
			$default_color	= $this->defaults[ 'color' ];
			$target			= parent::link_target();

			// Some options for select fields
			$figure_type_options = array(
				array(
					'value' 	=> 'ft-icon',
					'title' 	=> __( 'Icon', 'businessx-extensions'),
					'disabled'	=> false
				),
				array(
					'value' => 'ft-image',
					'title' => __( 'Image', 'businessx-extensions'),
					'disabled'	=> false
				),
			);

			// Form output

			/* Title */
			parent::text_input( $title, 'title', __( 'Add a title:', 'businessx-extensions' ) );

			/* Excerpt */
			parent::text_area( $excerpt, 'excerpt', __( 'Excerpt:', 'businessx-extensions' ), '', '', __( 'Allowed html tags: <a>, <strong>, <em>, <br />.', 'businessx-extensions' ) );

			/* Tabs */
			?>
            <div class="bx-widget-tabs bx-bs">

            	<div class="bx-wt-tab-wrap bx-bs">
                    <a href="#" class="bx-wt-tab-toggle bx-bs"><?php _e( 'Icon or Image', 'businessx-extensions' ); ?></a>
                    <div class="bx-wt-tab-contents bx-bs">
                        <?php
						/* Figure Options */
						parent::check_box( $show_figure, 'show_figure', __( 'Display icon/image', 'businessx-extensions' ) );
						parent::select_type_reveal( $figure_type, 'figure_type', 'ft-', $figure_type_options, __( 'What do you want to display?', 'businessx-extensions' ) );
						?>

                        <div class="ft-icon"<?php parent::option_display( $figure_type, 'ft-icon' ); ?>>
							<?php parent::select_icon( $figure_icon, 'figure_icon', __( 'Icon:', 'businessx-extensions' ), __( 'Search and select an icon', 'businessx-extensions' ), ' bx-is-nmt' ); ?>
                        </div>
                        <div class="ft-image"<?php parent::option_display($figure_type, 'ft-image' ); ?>>
                            <?php parent::select_image( $figure_image, 'figure_image', '', __( 'Suggested size: 250x250px', 'businessx-extensions' ) ); ?>
                        </div>

                    </div>
                </div>

                <div class="bx-wt-tab-wrap bx-bs">
                    <a href="#" class="bx-wt-tab-toggle bx-bs"><?php _e( 'Button', 'businessx-extensions' ); ?></a>
                    <div class="bx-wt-tab-contents bx-bs">
                        <?php
						/* Button Options */
						parent::text_input( $btn_anchor, 'btn_anchor', __( 'Anchor text:', 'businessx-extensions' ), '', '', __( 'E.g: Read more', 'businessx-extensions' ) );
						parent::text_input( $btn_url, 'btn_url', __( 'URL:', 'businessx-extensions' ), 'url', '', __( 'E.g: https://www.google.com', 'businessx-extensions' ) );
						parent::select_type( $btn_target, 'btn_target', $target, __( 'Open in the:', 'businessx-extensions' ) );
						?>
                    </div>
                </div>

                <div class="bx-wt-tab-wrap bx-bs">
                    <a href="#" class="bx-wt-tab-toggle bx-bs"><?php _e( 'Colors', 'businessx-extensions' ); ?></a>
                    <div class="bx-wt-tab-contents bx-bs">
                        <?php parent::color_picker( $color, 'color', $default_color, __( 'Select a color:', 'businessx-extensions' ), '', __( 'This will change colors for your icon, icon border, button border and any link in the excerpt.', 'businessx-extensions' ) ) ?>
                    </div>
                </div>

            </div><!-- Tabs -->
            <?php
		}


		/*  Customizer CSS
		/* ------------------------------------ */
		private function customizer_css( $instance ) {
			// Parse $instance
			$instance_defaults = $this->defaults;
			$instance = wp_parse_args( $instance, $instance_defaults );
			extract( $instance, EXTR_SKIP );

			// Variables
			$wid = esc_html( '#' . $this->id );
			$color = $instance[ 'color' ];
			$custom_css = '';
			$default = $this->defaults[ 'color' ];

			// Style Output
			if ( is_customize_preview() ) {
				if( parent::cd( $color, $default ) ) {
					$custom_css .= '<style type="text/css">';
					$custom_css .= $wid . ' .ac-btn-alt { border-color:' . sanitize_hex_color( $color ) . '; }';
					$custom_css .= $wid . ' .sec-feature-figure i { border-color:' . sanitize_hex_color( $color ) . '; color:' . sanitize_hex_color( $color ) . '; }';
					$custom_css .= $wid . ' a:not(.ac-btn-alt), ' . $wid . ' a:not(.ac-btn-alt):visited, ' . $wid . ' a:not(.ac-btn-alt):hover { color:' . sanitize_hex_color( $color ) . '; }';
					$custom_css .= '</style>';
				}
				echo $custom_css;
			}

		}


	} // Businessx_Extensions_Features_Item .END

	// Register this widget
	register_widget( 'Businessx_Extensions_Features_Item' );

}
