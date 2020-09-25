<?php
if( ! class_exists( 'Businessx_Extensions_Pricing_Item' ) ) {
	/**
	 * Pricing Item
	 * Adds a Pricing package
	 *
	 * @since 1.0.0
	 */
	class Businessx_Extensions_Pricing_Item extends Businessx_Extensions_Base {

		/**
		 * Widget defaults
		 *
		 * @var    array
		 * @since  1.0.0
		 * @access protected
		 */
		protected $defaults;

		/**
		 * Widget instance
		 *
		 * @since  1.0.0
		 * @access public
		 */
		function __construct() {

			// Variables
			$this->widget_title = __( 'BX: Pricing Package' , 'businessx-extensions' );
			$this->widget_id    = 'pricing';

			// Settings
			$widget_ops = array(
				'classname'   => 'sec-pricing-box',
				'description' => esc_html__( 'Adds a Pricing package', 'businessx-extensions' ),
				'customize_selective_refresh' => true
			);

			// Control settings
			$control_ops = array(
				'width'   => NULL,
				'height'  => NULL,
				'id_base' => 'bx-item-' . $this->widget_id
			);

			// Create the widget
			parent::__construct( 'bx-item-' . $this->widget_id, $this->widget_title, $widget_ops, $control_ops );

			// Set some widget defaults
			$this->defaults = apply_filters( 'businessx_extensions_pricing_item___defaults', array(
				'title'           => '',
				'price'           => '',
				'period'          => '',
				'badge'           => '',
				'btn_anchor'      => '',
				'btn_url'         => '',
				'btn_target'      => '_self',
				'list'            => array(),
				'icos'            => true,
				'item_bg'         => '#4eb5d5',
				'item_btn'        => '#76bc1c',
				'item_btn_hover'  => '#82cf1f',
				'item_btn_active' => '#69a619',
				'item_icon_av'    => '#c3ef93',
				'item_icon_unav'  => '#ef9393',
				'item_badge'      => '#c17ee0',
				'item_badge_text' => '#ffffff',
				'list_bg'         => '#ffffff',
				'list_color'      => '#636363',
				'details'         => '#ffffff',
			) );

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
			$title      = apply_filters( 'widget_title', empty( $instance[ 'title' ] ) ? '' : $instance[ 'title' ], $instance, $this->id_base );
			$price      = ! empty( $instance[ 'price' ] ) ? $instance[ 'price' ] : '';
			$period     = ! empty( $instance[ 'period' ] ) ? $instance[ 'period' ] : '';
			$badge      = ! empty( $instance[ 'badge' ] ) ? $instance[ 'badge' ] : '';
			$btn_anchor = ! empty( $instance[ 'btn_anchor' ] ) ? $instance[ 'btn_anchor' ] : '';
			$btn_url    = ! empty( $instance[ 'btn_url' ] ) ? $instance[ 'btn_url' ] : '';
			$btn_target = ! empty( $instance[ 'btn_target' ] ) ? $instance[ 'btn_target' ] : '_self';
			$list       = ! empty( $instance[ 'list' ] ) ? $instance[ 'list' ] : array();
			$icos       = ! empty( $instance[ 'icos' ] ) ? 1 : 0;

			// Some variables
			$wid = $this->number;
			$title_output = ! empty( $title ) ? $args['before_title'] . $title . $args['after_title'] : '';

			$column_type = get_theme_mod(
				'pricing_section_columns',
				apply_filters( 'businessx_extensions_pricing_columns_type', 'grid-2x3-col'
			) );

			$badge_class = ( ! empty( $badge ) ) ? 'with-badge' : '';

			// Query variables
			set_query_var( 'title', $title );
			set_query_var( 'title_output', $title_output );
			set_query_var( 'price', $price );
			set_query_var( 'period', $period );
			set_query_var( 'badge', $badge );
			set_query_var( 'btn_anchor', $btn_anchor );
			set_query_var( 'btn_url', $btn_url );
			set_query_var( 'btn_target', $btn_target );
			set_query_var( 'list', $list );
			set_query_var( 'icos', $icos );
			set_query_var( 'wid', $wid );

			// Add more widget classes
			$css_class   = array();
			$css_class[] = 'grid-col';
			$css_class[] = $column_type;
			$css_class[] = $badge_class;
			$css_class   = apply_filters( 'businessx_extensions_pricing_item___css_classes', $css_class );
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

				businessx_extensions_get_template_part( 'sections-items/item', 'pricing' );

				echo ob_get_clean();

				self::customizer_css( $instance ); // Output styles just for the customizer/selective refresh

			echo $args['after_widget'];

		}


		/**
		 * Widget update instance
		 *
		 * @since  1.0.0
		 * @access public
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			// Fields
			$instance[ 'title' ]           = sanitize_text_field( $new_instance[ 'title' ] );
			$instance[ 'price' ]           = sanitize_text_field( $new_instance[ 'price' ] );
			$instance[ 'period' ]          = sanitize_text_field( $new_instance[ 'period' ] );
			$instance[ 'badge' ]           = sanitize_text_field( $new_instance[ 'badge' ] );
			$instance[ 'btn_anchor' ]      = sanitize_text_field( $new_instance[ 'btn_anchor' ] );
			$instance[ 'btn_url' ]         = esc_url_raw( $new_instance[ 'btn_url' ] );
			$instance[ 'item_bg' ]         = sanitize_text_field( $new_instance[ 'item_bg' ] );
			$instance[ 'item_btn' ]        = sanitize_text_field( $new_instance[ 'item_btn' ] );
			$instance[ 'item_btn_hover' ]  = sanitize_text_field( $new_instance[ 'item_btn_hover' ] );
			$instance[ 'item_btn_active' ] = sanitize_text_field( $new_instance[ 'item_btn_active' ] );
			$instance[ 'item_icon_av' ]    = sanitize_text_field( $new_instance[ 'item_icon_av' ] );
			$instance[ 'item_icon_unav' ]  = sanitize_text_field( $new_instance[ 'item_icon_unav' ] );
			$instance[ 'item_badge' ]      = sanitize_text_field( $new_instance[ 'item_badge' ] );
			$instance[ 'item_badge_text' ] = sanitize_text_field( $new_instance[ 'item_badge_text' ] );
			$instance[ 'list_bg' ]         = sanitize_text_field( $new_instance[ 'list_bg' ] );
			$instance[ 'list_color' ]      = sanitize_text_field( $new_instance[ 'list_color' ] );
			$instance[ 'details' ]         = sanitize_text_field( $new_instance[ 'details' ] );

			// Repeatable
			$instance[ 'list' ]      = $this->sanitize_list( $new_instance[ 'list' ] );

			// Checkboxes
			$instance[ 'icos' ]      = ! empty( $new_instance[ 'icos' ] ) ? 1 : 0;

			// Select
			$instance[ 'btn_target'] = businessx_sanitize_select( $new_instance[ 'btn_target' ], array( '_self', '_blank' ), $this->defaults[ 'btn_target' ], false  );

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
				<div class="bx-pricing-repeatable-top bx-bs bx-clearfix">

					<select name="{{ data.name }}[{{ data.key }}][status]" class="widefat" id="{{ data.wid }}[{{ data.key }}][status]">
						<option value="available" {{ (data.value == 'available') ? 'selected' : '' }}><?php _e( 'Available', 'businessx-extensions' ) ?></option>
						<option value="unavailable" {{ (data.value == 'unavailable') ? 'selected' : '' }}><?php _e( 'Unavailable', 'businessx-extensions' ) ?></option>
					</select>

					<span class="bx-pricing-repeatable-helper"><a class="bx-widget-repeater-remove-item" href="#"><span class="dashicons dashicons-trash"></span></a></span>
					<span class="bx-pricing-repeatable-helper"><span class="dashicons dashicons-sort"></span></span>

				</div>

				<input placeholder="<?php _e( 'Item title', 'businessx-extensions' ); ?>" type="text" name="{{ data.name }}[{{ data.key }}][item]"  value="{{ data.value }}" class="widefat" id="{{ data.wid }}[{{ data.key }}][item]" />

				<input type="hidden" class="bx-widget-repeater-el-key" data-acb-el-key="{{ data.key }}" />
			</script>
			<?php
		}


		/**
		 * Widget form
		 *
		 * @since  1.0.0.
		 * @access public
		 */
		public function form( $instance ) {
			// Parse $instance
			$instance_defaults = $this->defaults;
			$instance = wp_parse_args( $instance, $instance_defaults );
			extract( $instance, EXTR_SKIP );

			// Variables
			$title           = $instance[ 'title' ];
			$price           = $instance[ 'price' ];
			$period          = $instance[ 'period' ];
			$badge           = $instance[ 'badge' ];
			$btn_anchor      = $instance[ 'btn_anchor' ];
			$btn_url         = $instance[ 'btn_url' ];
			$btn_target      = $instance[ 'btn_target' ];
			$list            = $instance[ 'list' ];
			$traget          = parent::link_target();
			$icos            = isset( $instance[ 'icos' ] ) ? (bool) $instance[ 'icos' ] : false;
			$item_bg         = $instance[ 'item_bg' ];
			$item_bg_def     = $this->defaults[ 'item_bg' ];
			$item_btn        = $instance[ 'item_btn' ];
			$item_btn_hover  = $instance[ 'item_btn_hover' ];
			$item_btn_active = $instance[ 'item_btn_active' ];
			$item_icon_av    = $instance[ 'item_icon_av' ];
			$item_icon_unav  = $instance[ 'item_icon_unav' ];
			$item_badge      = $instance[ 'item_badge' ];
			$item_badge_text = $instance[ 'item_badge_text' ];
			$list_bg         = $instance[ 'list_bg' ];
			$list_color      = $instance[ 'list_color' ];
			$details         = $instance[ 'details' ];


			// Form output

			/* Title */
			parent::text_input( $title, 'title', __( 'Package name:', 'businessx-extensions' ), '', 'p-widget-title' );

			/* Price */
			parent::text_input( $price, 'price', __( 'Package price:', 'businessx-extensions' ) );

			/* Period */
			parent::text_input( $period, 'period', __( 'Package period:', 'businessx-extensions' ) );

			/* Tabs */
			?>
				<div class="bx-widget-tabs bx-bs">

					<div class="bx-wt-tab-wrap bx-bs">
						<a href="#" class="bx-wt-tab-toggle bx-bs"><?php _e( 'Package Badge', 'businessx-extensions' ); ?></a>
						<div class="bx-wt-tab-contents bx-bs">
						<?php
							/* Badge */
							parent::text_input( $badge, 'badge', __( 'Title:', 'businessx-extensions' ), '', '', __( 'Eg: Recommended', 'businessx-extensions' ) );
							parent::color_picker( $item_badge, 'item_badge', $this->defaults['item_badge'], __( 'Background color:', 'businessx-extensions' ) );
							parent::color_picker( $item_badge_text, 'item_badge_text', $this->defaults['item_badge_text'], __( 'Text color:', 'businessx-extensions' ) );
						?>
					</div>
				</div>

				<div class="bx-wt-tab-wrap bx-bs">
					<a href="#" class="bx-wt-tab-toggle bx-bs"><?php _e( 'Package List', 'businessx-extensions' ); ?></a>
					<div class="bx-wt-tab-contents bx-bs">

						<?php
							/* Items */
							parent::check_box( $icos, 'icos', __( 'Show icons', 'businessx-extensions' ) );
						?>

						<ul class="bx-widget-repeatable-items bx-clearfix">
							<?php
							if ( ! empty( $list ) ) :
								foreach ( $list as $key => $value ) :
							?>
								<li class="bx-item-pricing-repeatable-item bx-bs bx-clearfix">
									<div class="bx-pricing-repeatable-top bx-bs bx-clearfix">
										<select name="<?php echo $this->get_field_name( 'list' ); ?>[<?php echo esc_attr( $key ); ?>][status]" class="widefat" id="<?php echo $this->get_field_id( 'list'); ?>[<?php echo esc_attr( $key ); ?>][status]">
										<option value="available"<?php selected($value[ 'status' ], 'available'); ?>><?php _e( 'Available', 'businessx-extensions' ) ?></option>
										<option value="unavailable"<?php selected($value[ 'status' ], 'unavailable'); ?>><?php _e( 'Unavailable', 'businessx-extensions' ) ?></option>
										</select>
										<span class="bx-pricing-repeatable-helper"><a class="bx-widget-repeater-remove-item" href="#"><span class="dashicons dashicons-trash"></span></a></span>
										<span class="bx-pricing-repeatable-helper"><span class="dashicons dashicons-sort"></span></span>
									</div>
									<input placeholder="<?php _e( 'Item title', 'businessx-extensions' ); ?>" type="text" name="<?php echo $this->get_field_name( 'list' ); ?>[<?php echo esc_attr( $key ); ?>][item]"  value="<?php echo esc_attr( $value['item'] ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'list' ); ?>[<?php echo esc_attr( $key ); ?>][item]" />
									<input type="hidden" class="bx-widget-repeater-el-key" data-acb-el-key="<?php echo esc_attr( $key ); ?>" />
								</li>
							<?php
								endforeach;
							endif;
							?>
						</ul>

						<p><a class="button bx-widget-repeater-add" href="#"><?php _e( 'Add another item', 'businessx-extensions' ); ?></a></p>

						<input type="hidden" class="bx-widget-repeatable-change" name="bx-widget-repeatable-change" />
						<input type="hidden" class="bx-widget-repeater-el" data-acb-el="list" />
					</div>
				</div>

				<div class="bx-wt-tab-wrap bx-bs">
					<a href="#" class="bx-wt-tab-toggle bx-bs"><?php _e( 'Package Button', 'businessx-extensions' ); ?></a>
					<div class="bx-wt-tab-contents bx-bs">
						<?php
							/* Button Options */
							parent::text_input( $btn_anchor, 'btn_anchor', __( 'Anchor text:', 'businessx-extensions' ), '', '', __( 'E.g: Buy Now', 'businessx-extensions' ) );
							parent::text_input( $btn_url, 'btn_url', __( 'URL:', 'businessx-extensions' ), 'url' );
							parent::select_type( $btn_target, 'btn_target', $traget, __( 'Open in the:', 'businessx-extensions' ) );

							/* Button colors */
							parent::color_picker( $item_btn, 'item_btn', $this->defaults['item_btn'], __( 'Button color:', 'businessx-extensions' ) );
							parent::color_picker( $item_btn_hover, 'item_btn_hover', $this->defaults['item_btn_hover'], __( 'Button hover color:', 'businessx-extensions' ) );
							parent::color_picker( $item_btn_active, 'item_btn_active', $this->defaults['item_btn_active'], __( 'Button active color:', 'businessx-extensions' ) );
						?>
					</div>
				</div>

				<div class="bx-wt-tab-wrap bx-bs">
					<a href="#" class="bx-wt-tab-toggle bx-bs"><?php _e( 'Package Colors', 'businessx-extensions' ); ?></a>
						<div class="bx-wt-tab-contents bx-bs">
						<?php
							/* Color schemes */
							parent::color_picker( $item_bg, 'item_bg', $item_bg_def, __( 'Item background color:', 'businessx-extensions' ) );
							parent::color_picker( $item_icon_av, 'item_icon_av', $this->defaults['item_icon_av'], __( 'Available icon color:', 'businessx-extensions' ) );
							parent::color_picker( $item_icon_unav, 'item_icon_unav', $this->defaults['item_icon_unav'], __( 'Unvailable icon color:', 'businessx-extensions' ) );
							parent::color_picker( $list_bg, 'list_bg', $this->defaults['list_bg'], __( 'List background-color:', 'businessx-extensions' ) );
							parent::color_picker( $list_color, 'list_color', $this->defaults['list_color'], __( 'List text color:', 'businessx-extensions' ) );
							parent::color_picker( $details, 'details', $this->defaults['details'], __( 'Details color:', 'businessx-extensions' ) );
						?>
						</div>
					</div>

				</div><!-- Tabs -->

			<?php
		}


		/**
		 * Customizer CSS
		 *
		 * Outputs CSS just for the previewer to keep changes on
		 * selective refresh
		 *
		 * @since  1.0.0
		 * @access private
		 */
		private function customizer_css( $instance ) {
			// Parse $instance
			$instance_defaults = $this->defaults;
			$instance = wp_parse_args( $instance, $instance_defaults );
			extract( $instance, EXTR_SKIP );

			// Variables
			$wid             = esc_html( '#' . $this->id );
			$custom_css      = '';
			$item_bg         = $instance[ 'item_bg' ];
			$item_bg_def     = $this->defaults[ 'item_bg' ];
			$item_btn        = $instance[ 'item_btn' ];
			$item_btn_hover  = $instance[ 'item_btn_hover' ];
			$item_btn_active = $instance[ 'item_btn_active' ];
			$item_icon_av    = $instance[ 'item_icon_av' ];
			$item_icon_unav  = $instance[ 'item_icon_unav' ];
			$item_badge      = $instance[ 'item_badge' ];
			$item_badge_text = $instance[ 'item_badge_text' ];
			$list_bg         = $instance[ 'list_bg' ];
			$list_color      = $instance[ 'list_color' ];
			$details         = $instance[ 'details' ];

			// Style Output
			if ( is_customize_preview() ) {
				$custom_css .= '<style type="text/css">';

					if( parent::cd( $item_bg, $item_bg_def ) ) {
						$custom_css .= $wid . '.sec-pricing-box { background-color:' . sanitize_hex_color( $item_bg ) . '; }'; }

					if( parent::cd( $item_btn, $this->defaults['item_btn'] ) ) {
						$custom_css .= $wid . ' .ac-btn { background-color:' . sanitize_hex_color( $item_btn ) . '; }'; }

					if( parent::cd( $item_btn_hover, $this->defaults['item_btn_hover'] ) ) {
						$custom_css .= $wid . ' .ac-btn:hover { background-color:' . sanitize_hex_color( $item_btn_hover ) . '; }'; }

					if( parent::cd( $item_btn_active, $this->defaults['item_btn_active'] ) ) {
						$custom_css .= $wid . ' .ac-btn:focus,' . $wid . ' .ac-btn:active { background-color:' . sanitize_hex_color( $item_btn_active ) . '; }'; }

					if( parent::cd( $item_icon_av, $this->defaults['item_icon_av'] ) ) {
						$custom_css .= $wid . '.sec-pricing-box ul i.fa-check { color:' . sanitize_hex_color( $item_icon_av ) . '; }'; }

					if( parent::cd( $item_icon_unav, $this->defaults['item_icon_unav'] ) ) {
						$custom_css .= $wid . '.sec-pricing-box ul i.fa-remove { color:' . sanitize_hex_color( $item_icon_unav ) . '; }'; }

					if( parent::cd( $item_badge, $this->defaults['item_badge'] ) ) {
						$custom_css .= $wid . '.sec-pricing-box .package-badge .badge { background-color:' . sanitize_hex_color( $item_badge ) . '; }'; }

					if( parent::cd( $item_badge_text, $this->defaults['item_badge_text'] ) ) {
						$custom_css .= $wid . '.sec-pricing-box .package-badge .badge { color:' . sanitize_hex_color( $item_badge_text ) . '; }'; }

					if( parent::cd( $list_bg, $this->defaults['list_bg'] ) ) {
						$custom_css .= $wid . '.sec-pricing-box .package-contents { background-color:' . sanitize_hex_color( $list_bg ) . '; }'; }

					if( parent::cd( $list_color, $this->defaults['list_color'] ) ) {
						$custom_css .= $wid . '.sec-pricing-box { color:' . sanitize_hex_color( $list_color ) . '; }'; }

					if( parent::cd( $details, $this->defaults['details'] ) ) {
						$custom_css .= $wid . '.sec-pricing-box .package-info, ' . $wid . '.sec-pricing-box .package-info h4 { color:' . sanitize_hex_color( $details ) . '; }';
						$custom_css .= $wid . '.sec-pricing-box .package-info h4 { border-color: rgba(' . businessx_hex2rgb( sanitize_hex_color( $details ) ) . ',0.5); }'; }

				$custom_css .= '</style>';

				echo $custom_css;
			}

		}


		/**
		 * Sanitize repeating fields
		 *
		 * @since  1.0.4.3
		 * @access public
		 */
		public function sanitize_list( $the_array ) {
			$newArr = array();

			foreach( $the_array as $key => $value ) :
				$newArr[ $key ] = $value;
				foreach( $value as $new_key => $new_value ) :
					if( $new_key == 'status' ) {
						$newArr[ $key ][ $new_key ]	= in_array( $new_value, array( 'available', 'unavailable' ) ) ? $new_value : 'available';
					}
					if( $new_key == 'item' ) {
						$newArr[ $key ][ $new_key ] = sanitize_text_field( $new_value );
					}
				endforeach;
			endforeach;

			return $newArr;
		}


	} // Businessx_Extensions_Pricing_Item .END

	// Register this widget
	register_widget( 'Businessx_Extensions_Pricing_Item' );

}
