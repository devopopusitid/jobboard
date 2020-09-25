<?php
/* ------------------------------------------------------------------------- *
 *
 *  Testimonials Item
 *  ________________
 *
 *	Adds a "Testimonial" - avatar, testimonial text, url
 *	________________
 *
/* ------------------------------------------------------------------------- */

if( ! class_exists( 'Businessx_Extensions_Testimonials_Item' ) ) {
	class Businessx_Extensions_Testimonials_Item extends Businessx_Extensions_Base {

		protected $defaults;
			
		
		/*  Constructor
		/* ------------------------------------ */
		function __construct() {
			
			// Variables
			$this->widget_title = __( 'BX: Testimonial' , 'businessx-extensions' );
			$this->widget_id = 'testimonials';
			
			// Settings
			$widget_ops = array( 
				'classname' => 'sec-testimonial-wrap', 
				'description' => esc_html__( 'Adds a "Testimonial" - avatar, testimonial text, url', 'businessx-extensions' ),
				'customize_selective_refresh' => true 
			);

			// Control settings
			$control_ops = array( 'width' => NULL, 'height' => NULL, 'id_base' => 'bx-item-' . $this->widget_id );
			
			// Create the widget
			parent::__construct( 'bx-item-' . $this->widget_id, $this->widget_title, $widget_ops, $control_ops );
			
			// Set some widget defaults
			$this->defaults = array (
				'title'			=> '',
				'avatar'		=> '',
				'testimonial'	=> '',
				'btn_text'		=> '',
				'btn_url'		=> '#',
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
			$avatar			= ! empty( $instance[ 'avatar' ] ) ? $instance[ 'avatar' ] : ''; set_query_var( 'avatar', $avatar );
			$testimonial	= ! empty( $instance[ 'testimonial' ] ) ? $instance[ 'testimonial' ] : ''; set_query_var( 'testimonial', $testimonial );
			$btn_text		= ! empty( $instance[ 'btn_text' ] ) ? $instance[ 'btn_text' ] : ''; set_query_var( 'btn_text', $btn_text );
			$btn_url		= ! empty( $instance[ 'btn_url' ] ) ? $instance[ 'btn_url' ] : ''; set_query_var( 'btn_url', $btn_url );
			
			// Some variables
			$wid = $this->number; set_query_var( 'wid', $wid ); 
			$target = apply_filters( 'businessx_extensions_testimonials_item___btn_target', $target = '_blank' ); set_query_var( 'target', $target );

			// Add more widget classes
			$css_class = array();
			$css_class[] = '';
			$css_class = apply_filters( 'businessx_extensions_testimonials_item___css_classes', $css_class );
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
				
				businessx_extensions_get_template_part( 'sections-items/item', 'testimonials' );
				
				echo ob_get_clean();
			
			echo $args['after_widget'];

		}
		
		
		/*  Update Widget
		/* ------------------------------------ */
		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			
			// Fields
			$instance[ 'title' ] 		= sanitize_text_field( $new_instance[ 'title' ] );
			$instance[ 'avatar' ] 		= esc_url_raw( $new_instance[ 'avatar' ] );
			$instance[ 'testimonial' ] 	= businessx_content_filter( $new_instance[ 'testimonial' ], array() );
			$instance[ 'btn_text' ] 	= sanitize_text_field( $new_instance[ 'btn_text' ] );
			$instance[ 'btn_url' ] 		= esc_url_raw( $new_instance[ 'btn_url' ] );
			
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
			$avatar 		= $instance[ 'avatar' ];
			$testimonial 	= $instance[ 'testimonial' ];
			$btn_text 		= $instance[ 'btn_text' ];
			$btn_url 		= $instance[ 'btn_url' ];
			
			// Form output
			
			/* Title */
			parent::text_input( $title, 'title', __( 'Client name:', 'businessx-extensions' ) );
			
			/* Avatar upload */
			parent::select_image( $avatar, 'avatar', '', __( 'Avatar - suggested size: 132x132px', 'businessx-extensions' ) );
			
			/* Excerpt */
			parent::text_area( $testimonial, 'testimonial', __( 'Testimonial:', 'businessx-extensions' ) );
			
			/* Button Text */
			parent::text_input( $btn_text, 'btn_text', __( 'Button anchor:', 'businessx-extensions' ) );
			
			/* Button URL */
			parent::text_input( $btn_url, 'btn_url', __( 'Button URL:', 'businessx-extensions' ), 'url' );
			
		}
		
		
	} // Businessx_Extensions_Testimonials_Item .END
	
	// Register this widget
	register_widget( 'Businessx_Extensions_Testimonials_Item' );
	
}