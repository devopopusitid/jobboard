<?php
if( ! class_exists( 'Businessx_Extensions_Team_Item' ) ) {
	/**
	 * Team Item
	 * Adds a Team member - name, avatar, position, description, social buttons
	 *
	 * @since 1.0.0
	 */
	class Businessx_Extensions_Team_Item extends Businessx_Extensions_Base {

		/**
		 * Widget defaults
		 *
		 * @var    array
		 * @since  1.0.0
		 * @access protected
		 */
		protected $defaults;

		/**
		 * Allowed HTML
		 *
		 * @var    array
		 * @since  1.0.0
		 * @access protected
		 */
		protected $allowed_html = array(
			'a' => array(
				'href'  => array(),
				'title' => array()
			),
			'em'     => array(),
			'strong' => array(),
		);

		/**
		 * Widget instance
		 *
		 * @since  1.0.0
		 * @access public
		 */
		function __construct() {

			// Variables
			$this->widget_title = __( 'BX: Team Member' , 'businessx-extensions' );
			$this->widget_id    = 'team';

			// Settings
			$widget_ops = array(
				'classname'   => 'sec-team-member',
				'description' => esc_html__( 'Adds a Team member - name, avatar, position, description, social buttons', 'businessx-extensions' ),
				'customize_selective_refresh' => true
			);

			// Control settings
			$control_ops = array(
				'width'   => NULL,
				'height'  => NULL,
				'id_base' => 'bx-item-' . $this->widget_id
			);

			// Create the widget
			parent::__construct(
				'bx-item-' . $this->widget_id,
				$this->widget_title,
				$widget_ops,
				$control_ops
			);

			// Set some widget defaults
			$this->defaults = array (
				'title'         => '',
				'position'      => '',
				'description'   => '',
				'avatar'        => '',
				'avatar_url'    => '',
				'avatar_trg'    => false,
				'social_links'  => array(),
			);

			// Underscore template for repeating fields
			add_action( 'customize_controls_print_footer_scripts', array( $this, 'repeating_tmpl' ), 0 );

		}

		/**
		 * Widget output
		 *
		 * @since  1.0.0
		 * @access public
		 */
		public function widget( $args, $instance ) {
			// Turn $args array into variables.
			extract( $args );

			// $instance Defaults
			$instance_defaults = $this->defaults;

			// Parse $instance
			$instance = wp_parse_args( $instance, $instance_defaults );

			// Options
			$title          = apply_filters( 'widget_title', empty( $instance[ 'title' ] ) ? '' : $instance[ 'title' ], $instance, $this->id_base );
			$position       = ! empty( $instance[ 'position' ] ) ? $instance[ 'position' ] : '';
			$description    = ! empty( $instance[ 'description' ] ) ? $instance[ 'description' ] : '';
			$avatar         = ! empty( $instance[ 'avatar' ] ) ? $instance[ 'avatar' ] : '';
			$avatar_url     = ! empty( $instance[ 'avatar_url' ] ) ? $instance[ 'avatar_url' ] : '';
			$avatar_trg     = ! empty( $instance[ 'avatar_trg' ] ) ? 1 : 0;
			$social_links   = ! empty( $instance[ 'social_links' ] ) ? $instance[ 'social_links' ] : array();

			// Some variables
			$wid = $this->number;
			$title_output = ( ! empty( $title ) ) ? $args['before_title'] . $title . $args['after_title'] : '';
			$allowed_html = $this->allowed_html();

			// Template vars
			set_query_var( 'wid', $wid );
			set_query_var( 'title', $title );
			set_query_var( 'position', $position );
			set_query_var( 'description', $description );
			set_query_var( 'avatar', $avatar );
			set_query_var( 'avatar_url', $avatar_url );
			set_query_var( 'avatar_trg', $avatar_trg );
			set_query_var( 'social_links', $social_links );
			set_query_var( 'title_output', $title_output );
			set_query_var( 'allowed_html', $allowed_html );

			// Add more widget classes
			$css_class   = array();
			$css_class[] = 'grid-col';
			$css_class[] = 'grid-1x-col';
			$css_class   = apply_filters( 'businessx_extensions_team_item___css_classes', $css_class );
			$css_classes = join( ' ', $css_class );

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

				businessx_extensions_get_template_part( 'sections-items/item', 'team' );

				echo ob_get_clean();

			echo $args['after_widget'];

		}

		/**
		 * Allowed HTML
		 *
		 * @since  1.0.4.3
		 * @access public
		 */
		public function allowed_html() {
			$allowed_html = $this->allowed_html;
			return apply_filters( 'businessx_extensions_team_item___allowed_html', $allowed_html );
		}

		/**
		 * Widget update
		 *
		 * @since  1.0.0
		 * @access public
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			// Variables
			$allowed_html = $this->allowed_html();

			// Fields
			$instance[ 'title' ]        = sanitize_text_field( $new_instance[ 'title' ] );
			$instance[ 'position' ]     = sanitize_text_field( $new_instance[ 'position' ] );
			$instance[ 'avatar' ]       = esc_url_raw( $new_instance[ 'avatar' ] );
			$instance[ 'avatar_url' ]   = esc_url_raw( $new_instance[ 'avatar_url' ] );

			// Checkboxes
			$instance[ 'avatar_trg' ] = ! empty( $new_instance[ 'avatar_trg' ] ) ? 1 : 0;

			// Social Links
			$instance[ 'social_links' ] = businessx_sanitize_array_map( 'esc_url_raw', $new_instance[ 'social_links' ] );

			// Text Area
			if ( current_user_can('unfiltered_html') ) {
				$instance[ 'description' ] =  businessx_content_filter( $new_instance[ 'description' ], $allowed_html );
			} else {
				$instance[ 'description' ] = wp_kses_post( stripslashes( $new_instance[ 'description' ] ) );
			}

			// Return
			return $instance;
		}

		/**
		 * Repeating field Underscore template
		 *
		 * @since  1.0.4.3
		 * @access public
		 */
		public function repeating_tmpl() {
			?>
			<script type="text/template" id="tmpl-<?php echo $this->id_base ?>-repeater">

					<input type="url" name="{{ data.name }}[{{ data.key }}][url]"  value="{{ data.value }}" class="widefat" id="{{ data.wid }}[{{ data.key }}][url]" />
					<span class="bx-team-repeatable-helper"><a class="bx-widget-repeater-remove-item" href="#"><span class="dashicons dashicons-trash"></span></a></span>
					<span class="bx-team-repeatable-helper"><span class="dashicons dashicons-sort"></span></span>

					<input type="hidden" class="bx-widget-repeater-el-key" data-acb-el-key="{{ data.key }}" />

			</script>
			<?php
		}

		/**
		 * Widget form
		 *
		 * @since  1.0.0
		 * @access public
		 */
		public function form( $instance ) {
			// Parse $instance
			$instance_defaults = $this->defaults;
			$instance = wp_parse_args( $instance, $instance_defaults );
			extract( $instance, EXTR_SKIP );

			// Variables
			$title          = $instance[ 'title' ];
			$position       = $instance[ 'position' ];
			$description    = $instance[ 'description' ];
			$avatar         = $instance[ 'avatar' ];
			$avatar_url     = $instance[ 'avatar_url' ];
			$avatar_trg     = isset( $instance[ 'avatar_trg' ] ) ? (bool) $instance[ 'avatar_trg' ] : false;
			$social_links   = $instance[ 'social_links' ];

			// Form output

			/* Title */
			parent::text_input( $title, 'title', __( 'Member name:', 'businessx-extensions' ), '', 'p-widget-title' );

			/* Position */
			parent::text_input( $position, 'position', __( 'Position/Job:', 'businessx-extensions' ) );

			/* Excerpt */
			parent::text_area( $description, 'description', __( 'Description:', 'businessx-extensions' ), '', '', __( 'Allowed html tags: <a>, <strong>, <em>.', 'businessx-extensions' ) );

			/* Avatar */
			parent::select_image( $avatar, 'avatar', '', __( 'Avatar - suggested size: 250x250px', 'businessx-extensions' ) );

			/* Avatar URL */
			parent::text_input( $avatar_url, 'avatar_url', __( 'Link on avatar', 'businessx-extensions' ), 'url', '', esc_attr__( 'https://google.com', 'businessx-extensions' ) );

			/* Avatar URL target */
			parent::check_box( $avatar_trg, 'avatar_trg', __( 'Open link in a new window', 'businessx-extensions' ) );

			/* Tabs */
			?>
			<div class="bx-widget-tabs bx-bs">

				<div class="bx-wt-tab-wrap bx-bs">

				<a href="#" class="bx-wt-tab-toggle bx-bs"><?php _e( 'Social Profiles', 'businessx-extensions' ); ?></a>

					<div class="bx-wt-tab-contents bx-bs">

						<p><?php _e( 'Enter your social profile URL, for example: https://twitter.com/acosmin/', 'businessx-extensions' ); ?></p>
						<p><?php _e( 'If the theme has an icon for your social profile, it will display it.', 'businessx-extensions' ); ?></p>

						<ul class="bx-widget-repeatable-items bx-clearfix">
							<?php
							if ( ! empty( $social_links ) ) :
								foreach ( $social_links as $key => $value ) :
							?>
								<li class="bx-item-team-repeatable-item bx-bs bx-clearfix">
									<input type="url" name="<?php echo $this->get_field_name( 'social_links' ); ?>[<?php echo esc_attr( $key ); ?>][url]"  value="<?php echo esc_url( $value['url'] ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'social_links' ); ?>[<?php echo esc_attr( $key ); ?>][url]" />
									<span class="bx-team-repeatable-helper"><a class="bx-widget-repeater-remove-item" href="#"><span class="dashicons dashicons-trash"></span></a></span>
									<span class="bx-team-repeatable-helper"><span class="dashicons dashicons-sort"></span></span>
									<input type="hidden" class="bx-widget-repeater-el-key" data-acb-el-key="<?php echo esc_attr( $key ); ?>" />
								</li>
							<?php
								endforeach;
							endif;
							?>
						</ul>

						<p><a class="button bx-widget-repeater-add" href="#"><?php _e( 'Add another profile', 'businessx-extensions' ); ?></a></p>

						<input type="hidden" class="bx-widget-repeatable-change" name="bx-widget-repeatable-change" />
						<input type="hidden" class="bx-widget-repeater-el" data-acb-el="social_links" />

					</div>
				</div>

			</div> <!-- Tabs -->
			<?php
		}


	} // Businessx_Extensions_Team_Item .END

	// Register this widget
	register_widget( 'Businessx_Extensions_Team_Item' );

}
