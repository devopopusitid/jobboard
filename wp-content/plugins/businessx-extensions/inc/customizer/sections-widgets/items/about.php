<?php
/* ------------------------------------------------------------------------- *
 *
 *  About Section Item
 *  ________________
 *
 *	Adds an "About Us" box - title, a few lines of text
 *	________________
 *
/* ------------------------------------------------------------------------- */

if( ! class_exists( 'Businessx_Extensions_About_Item' ) ) {
	class Businessx_Extensions_About_Item extends Businessx_Extensions_Base {

		protected $defaults;
		protected $allowed_html = array(
			'a' => array(
				'href' => array(),
				'title' => array()
			),
			'em' => array(),
			'strong' => array(),
		);


		/*  Constructor
		/* ------------------------------------ */
		function __construct() {

			// Variables
			$this->widget_title = __( 'BX: About Box' , 'businessx-extensions' );
			$this->widget_id = 'about';

			// Settings
			$widget_ops = array(
				'classname' => 'sec-about-box',
				'description' => esc_html__( 'Adds an "About Us" box - title, a few lines of text', 'businessx-extensions' ),
				'customize_selective_refresh' => true
			);

			// Control settings
			$control_ops = array( 'width' => NULL, 'height' => NULL, 'id_base' => 'bx-item-' . $this->widget_id );

			// Create the widget
			parent::__construct( 'bx-item-' . $this->widget_id, $this->widget_title, $widget_ops, $control_ops );

			// Set some widget defaults
			$this->defaults = array (
				'title'			=> '',
				'excerpt'		=> ''
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

			// Some variables
			$wid          = $this->number; set_query_var( 'wid', $wid );
			$title_output = ! empty( $title ) ? $args['before_title'] . $title . $args['after_title'] : '';
			$allowed_html = apply_filters( 'businessx_extensions_about_item___allowed_html', $allowed_html = $this->allowed_html );
			set_query_var( 'title_output', $title_output );
			set_query_var( 'allowed_html', $allowed_html );

			// Add more widget classes
			$css_class = array();
			$css_class[] = 'grid-col';
			$css_class[] = 'grid-2x-col';
			$css_class = apply_filters( 'businessx_extensions_about_item___css_classes', $css_class );
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

				businessx_extensions_get_template_part( 'sections-items/item', 'about' );

				echo ob_get_clean();

			echo $args['after_widget'];

		}


		/*  Update Widget
		/* ------------------------------------ */
		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			// Variables
			$allowed_html = apply_filters( 'businessx_extensions_about_item___allowed_html', $allowed_html = $this->allowed_html );

			// Fields
			$instance[ 'title' ] 		= sanitize_text_field( $new_instance[ 'title' ] );

			// Text Area
			if ( current_user_can('unfiltered_html') ) {
				$instance[ 'excerpt' ] =  businessx_ext_sanitize_content_filtered( $new_instance[ 'excerpt' ] );
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

			// Form output

			/* Title */
			parent::text_input( $title, 'title', __( 'Add a title:', 'businessx-extensions' ) );

			/* Excerpt */
			parent::text_area( $excerpt, 'excerpt', __( 'Text:', 'businessx-extensions' ), '', '' );

		}


	} // Businessx_Extensions_About_Item .END

	// Register this widget
	register_widget( 'Businessx_Extensions_About_Item' );

}
