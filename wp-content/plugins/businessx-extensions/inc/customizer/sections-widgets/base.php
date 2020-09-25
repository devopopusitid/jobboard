<?php
/* ------------------------------------------------------------------------- *
 *  Basic - Parent Functions :)
/* ------------------------------------------------------------------------- */

if( ! class_exists( 'Businessx_Extensions_Base' ) ) {
	class Businessx_Extensions_Base extends WP_Widget {


		/*  Select type field
		/* ------------------------------------ */
		public function select_type( $sel_instance, $sel_attr, $sel_options = array(), $sel_title = '', $pclass = '', $sclass = '' ) {
			$css_class = $pclass;
			if( $sel_title == '' ) { $sel_title_display = __( 'Select:', 'businessx-extensions' ); } else { $sel_title_display = $sel_title; }
			if( $sclass != '' ) { $css_sclass = $sclass; } else { $css_sclass = ''; }
			?>
            	<p<?php if( $css_class != '' ) { ?> class="<?php echo esc_html( $css_class ); ?>"<?php } ?>>
                    <label for="<?php echo $this->get_field_id( $sel_attr ); ?>"><?php echo esc_html( $sel_title_display ); ?></label>
                    <select name="<?php echo $this->get_field_name( $sel_attr ); ?>" id="<?php echo $this->get_field_id( $sel_attr ); ?>" class="widefat<?php echo esc_attr( $css_sclass ); ?>">
                        <?php
							foreach( $sel_options as $sel_arrays => $sel_option ) {
								$svalue 	= $sel_option[ 'value' ];
								$stitle		= $sel_option[ 'title' ];
								$sdisabled 	= $sel_option[ 'disabled' ];
								if( $sdisabled ) { $sdis = ' disabled'; } else { $sdis = ''; }

								echo '<option' . $sdis . ' value="' . esc_attr( $svalue ) . '"' . selected( $sel_instance, $svalue, false ) . '>' . esc_html( $stitle ) . '</option>';
							}
						?>
                    </select>
                </p>
            <?php
		}


		/*  Select between multiple choices and
		/*	show/hide elements
		/* ------------------------------------ */
		public function select_type_reveal( $sel_instance, $sel_attr, $data_class, $sel_options = array(), $sel_title = '', $pclass = '', $sclass = '' ) {
			$css_class = $pclass;
			if( $sel_title == '' ) { $sel_title_display = __( 'Select:', 'businessx-extensions' ); } else { $sel_title_display = $sel_title; }
			if( $sclass == '' ) { $css_sclass = 'bx-select-type'; } else { $css_sclass = $sclass; }
			?>
            	<p class="bx-st-wrap<?php echo esc_html( $css_class ); ?>">
                    <label for="<?php echo $this->get_field_id( $sel_attr ); ?>"><?php echo esc_html( $sel_title_display ); ?></label>
                    <select name="<?php echo $this->get_field_name( $sel_attr ); ?>" id="<?php echo $this->get_field_id( $sel_attr ); ?>" class="widefat <?php echo esc_attr( $css_sclass ); ?>" data-bx-select-class="<?php echo esc_attr( $data_class ); ?>">
                        <?php
							foreach( $sel_options as $sel_arrays => $sel_option ) {
								$svalue = $sel_option[ 'value' ];
								$stitle = $sel_option[ 'title' ];
								$sdisabled 	= $sel_option[ 'disabled' ];
								if( $sdisabled ) { $sdis = ' disabled'; } else { $sdis = ''; }

								echo '<option' . $sdis . ' value="' . esc_attr( $svalue ) . '"' . selected( $sel_instance, $svalue, false ) . '>' . esc_html( $stitle ) . '</option>';
							}
						?>
                    </select>
                </p>
            <?php
		}


		/*  Diplay/hide selected option
		/*	- check above
		/* ------------------------------------ */
		public function option_display( $op_instance, $op_value ) {
			if( $op_instance == $op_value ) {
				return;
			} else {
				echo ' style="display: none;"';
			}
		}


		/*  Select field with all the icons
		/*	available
		/* ------------------------------------ */
		public function select_icon( $icon, $ico_attr, $label = '', $placeholder = '', $pclass = '', $default_icon = '' ) {
			$ph	= __( 'Search and select an icon', 'businessx-extensions' );
			$lh	= __( 'Icon:', 'businessx-extensions' );
			$css_class = $pclass;
			if( $placeholder != '' ) { $ph = $placeholder; }
			if( $label != '' ) { $lh = $label; }
			if( $default_icon == '' ) { $default_icon = 'fa-arrow-circle-o-left'; }
			if( $icon == '' ) { $display_icon = $default_icon; } else { $display_icon = $icon; }
			?>
			<p class="bx-is-autocomplete-wrap bx-clearfix<?php echo esc_html( $css_class ); ?>">
				<label class="bx-is-autocomplete-label"><?php echo esc_html( $lh ); ?></label>
				<input type="text" value="<?php echo esc_attr( $icon ); ?>" id="<?php echo $this->get_field_id( $ico_attr ); ?>" name="<?php echo $this->get_field_name( $ico_attr ); ?>"  placeholder="<?php echo esc_attr( $ph ); ?>" class="bx-is-autocomplete">
                <strong class="bx-is-autocomplete-icon"><i class="fa <?php echo esc_html( $display_icon ); ?>"></i></strong>
                <span class="bx-fields-description bx-bs">
					<?php printf(
						esc_html__( 'If the autocomplete feature does not help you, you can find the full %s. Just remember to prefix with "fa-", fa-feed for example.', 'businessx-extensions' ),
						'<a href="//fontawesome.io/icons/" target="_blank">' . esc_html__( 'list of icons here', 'businessx-extensions') . '</a>' ); ?>
				</span>
			</p>
            <?php
		}


		/*  Select an image - template
		/* ------------------------------------ */
		public function select_image( $image_url, $img_attr, $pclass = '', $label = '', $description = '' ) {
			$is_image 	= $image_url;
			$image_id 	= $this->image_id( $image_url );
			$image_attr = wp_get_attachment_image_src( $image_id, 'medium' );
			$css_class = $pclass;
			if( $label != '' ) { echo '<label class="bx-is-autocomplete-label">' . $label . '</label><br />'; }
           	?>
            <div class="bx-iu-wrap<?php echo esc_html( $css_class ); ?>">
				<p>
					<img class="bx-iu-image" src="<?php if ( ! empty( $image_attr[0] ) ) {
					echo esc_url( $image_attr[0] ); } ?>"
                    style="margin: 0 auto; padding:0; max-width:100%;<?php if( ! empty( $image_attr[0] ) ) { echo 'display:block;'; } else { echo 'display:none;'; }; ?>" />
				</p>
				<p style="text-align: center;">
					<input type="url" class="hidden widefat bx-iu-image-url" name="<?php echo esc_attr( $this->get_field_name( $img_attr ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( $img_attr ) ); ?>" value="<?php echo esc_attr( $image_url ); ?>"  style="margin-bottom:5px;" /><?php
					if ( ! $is_image ) { ?>
						<a href="#" class="button-secondary bx-iu-image-upload"><?php esc_html_e( 'Add image', 'businessx-extensions' ); ?></a>
						<a href="#" class="button-secondary bx-iu-image-remove hidden"><?php esc_html_e( 'Remove image', 'businessx-extensions' ); ?></a><?php
					} else { ?>
						<a href="#" class="button-secondary bx-iu-image-upload hidden"><?php esc_html_e( 'Add image', 'businessx-extensions' ); ?></a>
						<a href="#" class="button-secondary bx-iu-image-remove"><?php esc_html_e( 'Remove image', 'businessx-extensions' ); ?></a><?php
					}; ?>
				</p>
			</div>
            <?php if( $description != '' ) { ?><p><span class="bx-fields-description bx-bs"><?php echo esc_html( $description ); ?></span></p><?php } ?>
            <?php
		}


		/*  Get image ID from attachment src
		/* ------------------------------------ */
		public function image_id( $image_url ) {
			global $wpdb;
			$id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE guid='%s'", esc_url_raw( $image_url ) ) );
			return absint( $id );
		}


		/*  Color Picker input template
		/* ------------------------------------ */
		public function color_picker( $color_instance, $color_attr, $color_default, $color_label = '', $pclass = '', $color_description = '' ) {
			$attr = esc_html( $color_attr );
			if( $pclass != '' ) { $css_class = $pclass; } else { $css_class = ''; }
			if( $color_description != '' ) { $color_desc = $color_description; } else { $color_desc = ''; }
			?>
            	<p<?php if( $pclass != '' ) { echo ' class="' . esc_html( $css_class ) . '"'; } ?>>
                	<?php if( $color_label != '') { ?><label for="<?php echo $this->get_field_id( $color_attr ); ?>"><?php echo esc_html( $color_label ); ?></label><br /><?php }; ?>
					<input class="widefat bx-widget-color-piker" id="<?php echo $this->get_field_id( $attr ); ?>" name="<?php echo $this->get_field_name( $attr ); ?>" type="text" value="<?php echo businessx_sanitize_hex( $color_instance ); ?>" data-default-color="<?php echo businessx_sanitize_hex( $color_default ); ?>">
                    <?php if( $color_desc != '') { ?><span class="bx-fields-description bx-bs"><?php echo esc_html( $color_desc ); ?></span><?php }; ?>
				</p>
            <?php
		}


		/*  Text input template
		/* ------------------------------------ */
		public function text_input( $text_instance, $text_attr, $text_label = '', $text_type = '', $pclass = '', $text_placeholder = '', $text_description = '', $disabled = FALSE ) {
			if( $text_type == '' ) { $type_attr = 'text'; } else { $type_attr = $text_type; }
			if( $pclass != '' ) { $css_class = $pclass; } else { $css_class = ''; }
			if( $text_placeholder != '' ) { $text_ph = $text_placeholder; } else { $text_ph = ''; }
			if( $text_description != '' ) { $text_desc = $text_description; } else { $text_desc = ''; }
			if( $disabled ) { $dis = ' disabled'; } else { $dis = ''; }
			?>
            	<p<?php if( $pclass != '' ) { echo ' class="' . esc_html( $css_class ) . '"'; } ?>>
                    <?php if( $text_label != '') { ?><label for="<?php echo $this->get_field_id( $text_attr ); ?>"><?php echo esc_html( $text_label ); ?></label><?php }; ?>
                    <input<?php echo $dis; ?> class="widefat" id="<?php echo $this->get_field_id( $text_attr ); ?>" name="<?php echo $this->get_field_name( $text_attr ); ?>"
                    	type="<?php echo esc_attr( $type_attr ) ?>"
                        <?php
							if( $type_attr == 'text' ) {
								echo 'value="' . esc_attr( $text_instance ) . '" ';
							} elseif ( $type_attr == 'email' ) {
								echo 'value="' . sanitize_email( $text_instance ) . '" ';
							} elseif ( $type_attr == 'url' ) {
								echo 'value="' . esc_url( $text_instance ) . '" ';
							}
						?>
						<?php if( $text_ph != '' ) { echo 'placeholder="' . esc_attr( $text_ph ) . '"'; } ?>/>
                    <?php if( $text_desc != '') { ?><span class="bx-fields-description bx-bs"><?php echo esc_html( $text_desc ); ?></span><?php }; ?>
                </p>
            <?php
		}


		/*  Text input template
		/* ------------------------------------ */
		public function text_area( $textarea_instance, $textarea_attr, $textarea_label = '', $pclass = '', $textarea_placeholder = '', $textarea_description = '', $disabled = FALSE ) {
			if( $pclass != '' ) { $css_class = $pclass; } else { $css_class = ''; }
			if( $textarea_placeholder != '' ) { $textarea_ph = $textarea_placeholder; } else { $textarea_ph = ''; }
			if( $textarea_description != '' ) { $textarea_desc = $textarea_description; } else { $textarea_desc = ''; }
			if( $disabled ) { $dis = ' disabled'; } else { $dis = ''; }
			?>
				<p<?php if( $pclass != '' ) { echo ' class="' . esc_html( $css_class ) . '"'; } ?>>
					<?php if( $textarea_label != '') { ?><label for="<?php echo $this->get_field_id( $textarea_attr ); ?>"><?php echo esc_html( $textarea_label ); ?></label><?php }; ?><br />
                    <textarea<?php echo $dis; ?> id="<?php echo $this->get_field_id( $textarea_attr ); ?>" name="<?php echo $this->get_field_name( $textarea_attr ); ?>" class="widefat" rows="5" cols="5" <?php if( $textarea_ph != '' ) { echo 'placeholder="' . esc_attr( $textarea_ph ) . '"'; } ?>><?php if( $textarea_instance != '' ) { echo esc_textarea( $textarea_instance ); } ?></textarea>
                    <?php if( $textarea_desc != '') { ?><span class="bx-fields-description bx-bs"><?php echo esc_html( $textarea_desc ); ?></span><?php }; ?>
                </p>
			<?php
		}


		/*  Checkbox template
		/* ------------------------------------ */
		public function check_box( $checkbox_instance, $checkbox_attr, $checkbox_label = '', $pclass = '', $checkbox_description = '', $checkbox_wrapper = TRUE, $disabled = FALSE ) {
			if( $pclass != '' ) { $css_class = $pclass; } else { $css_class = ''; }
			if( $checkbox_description != '' ) { $checkbox_desc = $checkbox_description; } else { $checkbox_desc = ''; }
			if( $disabled ) { $dis = ' disabled'; } else { $dis = ''; }
			if( $checkbox_wrapper ) { echo '<p class="' . esc_html( $css_class )  . '">'; }
			?>
				<input<?php echo $dis; ?> class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( $checkbox_attr ); ?>" name="<?php echo $this->get_field_name( $checkbox_attr ); ?>" value="1" <?php checked( $checkbox_instance, 1 ); ?>>
                <label for="<?php echo $this->get_field_id( $checkbox_attr ); ?>"><?php echo esc_html( $checkbox_label ); ?></label><br/>
            	<?php if( $checkbox_desc != '') { ?><span class="bx-fields-description bx-bs"><?php echo esc_html( $checkbox_desc ); ?></span><?php } ?>
            <?php
			if( $checkbox_wrapper ) { echo '</p>'; }
		}


		/*  Check default
		/* ------------------------------------ */
		public function cd( $current, $default ) {
			if( isset( $current ) && $current != '' && $current != $default ) {
				return true;
			}
		}


		/*  Link target options
		/* ------------------------------------ */
		public function link_target() {
			$btn_target_options = apply_filters( 'businessx_extensions_widget_target___options', array(
				array(
					'value' 	=> '_self',
					'title' 	=> __( 'Same window', 'businessx-extensions'),
					'disabled'	=> false
				),
				array(
					'value' 	=> '_blank',
					'title' 	=> __( 'New window', 'businessx-extensions'),
					'disabled'	=> false
				),
			) );

			return $btn_target_options;
		}


	} // Businessx_Extensions_Base .END
}
