<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'AWSM_Job_Openings_Settings' ) ) :

	class AWSM_Job_Openings_Pro_Settings extends AWSM_Job_Openings_Settings {
		private static $instance = null;

		public function __construct( $awsm_core ) {
			$this->cpath = untrailingslashit( plugin_dir_path( __FILE__ ) );

			add_action( 'admin_init', array( $this, 'register_pro_settings' ) );

			add_filter( 'awsm_jobs_settings_tab_menus', array( $this, 'pro_tab_menus' ) );
			add_action( 'awsm_jobs_settings_tab_section', array( $this, 'pro_tab_section' ) );
			add_filter( 'awsm_jobs_settings_subtabs', array( $this, 'pro_setting_subtabs' ), 10, 2 );
			add_action( 'after_awsm_settings_main_content', array( $this, 'subtab_section_content' ) );
			add_filter( 'awsm_job_template_tags', array( $this, 'custom_template_tags' ) );
		}

		public static function init( $awsm_core = null ) {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self( $awsm_core );
			}
			return self::$instance;
		}

		public function pro_tab_menus( $tab_menus ) {
			$tab_menus['shortcodes'] = esc_html__( 'Shortcodes', 'pro-pack-for-wp-job-openings' );
			$tab_menus['license']    = esc_html__( 'License', 'pro-pack-for-wp-job-openings' );
			return $tab_menus;
		}

		public function pro_tab_section() {
			$current_tab = isset( $_GET['tab'] ) ? sanitize_title( $_GET['tab'] ) : 'general';
			if ( $current_tab === 'license' ) {
				include_once $this->cpath . '/templates/settings/license.php';
			} elseif ( $current_tab === 'shortcodes' ) {
				include_once $this->cpath . '/templates/settings/shortcodes.php';
			}
		}

		public function pro_setting_subtabs( $subtabs, $section ) {
			if ( $section === 'notification' ) {
				$subtabs = array(
					'general'   => array(
						'target' => 'awsm-job-notification-options-container',
						'label'  => esc_html__( 'General', 'pro-pack-for-wp-job-openings' ),
					),
					'templates' => array(
						'label' => esc_html__( 'Templates', 'pro-pack-for-wp-job-openings' ),
					),
				);
			} elseif ( $section === 'form' ) {
				$subtabs['builder'] = array(
					'label' => esc_html__( 'Form Builder', 'pro-pack-for-wp-job-openings' ),
				);
			}
			return $subtabs;
		}

		public function subtab_section_content( $group ) {
			if ( $group === 'form' ) {
				include_once $this->cpath . '/templates/settings/form-builder.php';
			} elseif ( $group === 'notification' ) {
				include_once $this->cpath . '/templates/settings/mail-templates.php';
			}
		}

		private function settings() {
			$settings = array(
				'form'         => array(
					array(
						'option_name' => 'awsm_jobs_form_builder',
						'callback'    => array( $this, 'form_builder_handler' ),
					),
					array(
						'option_name' => 'awsm_jobs_form_builder_other_options',
						'callback'    => array( $this, 'form_builder_other_options_handler' ),
					),
				),
				'notification' => array(
					array(
						'option_name' => 'awsm_jobs_pro_mail_templates',
						'callback'    => array( $this, 'email_template_handler' ),
					),
				),
				'license'      => array(
					array(
						'option_name' => 'awsm_jobs_pro_license',
						'callback'    => array( $this, 'license_handler' ),
					),
				),
			);
			return $settings;
		}

		public function register_pro_settings() {
			$settings = $this->settings();
			foreach ( $settings as $group => $settings_args ) {
				foreach ( $settings_args as $setting_args ) {
					register_setting( 'awsm-jobs-' . $group . '-settings', $setting_args['option_name'], isset( $setting_args['callback'] ) ? $setting_args['callback'] : 'sanitize_text_field' );
				}
			}
		}

		private static function default_settings() {
			$options = array(
				'awsm_jobs_pro_version'  => AWSM_JOBS_PRO_PLUGIN_VERSION,
				'awsm_jobs_form_builder' => self::form_builder_default_options(),
			);
			foreach ( $options as $option => $value ) {
				if ( ! get_option( $option ) ) {
					update_option( $option, $value );
				}
			}
		}

		public static function register_pro_defaults() {
			if ( intval( get_option( 'awsm_register_pro_default_settings' ) ) === 1 ) {
				return;
			}
			self::default_settings();
			update_option( 'awsm_register_pro_default_settings', 1 );
		}

		public static function form_builder_default_options() {
			$default_options = array(
				array(
					'super_field' => true,
					'name'        => 'awsm_applicant_name',
					'label'       => esc_html__( 'Full Name', 'wp-job-openings' ),
					'field_type'  => 'text',
				),
				array(
					'super_field' => true,
					'name'        => 'awsm_applicant_email',
					'label'       => esc_html__( 'Email', 'wp-job-openings' ),
					'field_type'  => 'email',
				),
				array(
					'name'       => 'awsm_applicant_phone',
					'label'      => esc_html__( 'Phone', 'wp-job-openings' ),
					'field_type' => 'tel',
				),
				array(
					'name'       => 'awsm_applicant_letter',
					'label'      => esc_html__( 'Cover Letter', 'wp-job-openings' ),
					'field_type' => 'textarea',
				),
				array(
					'name'       => 'awsm_file',
					'label'      => esc_html__( 'Upload CV/Resume', 'wp-job-openings' ),
					'field_type' => 'resume',
				),
			);
			foreach ( $default_options as $key => $default_option ) {
				$default_options[ $key ]['super_field']   = isset( $default_option['super_field'] ) ? $default_option['super_field'] : false;
				$default_options[ $key ]['required']      = 'required';
				$default_options[ $key ]['active']        = 'active';
				$default_options[ $key ]['default_field'] = true;
			}
			return $default_options;
		}

		public static function form_builder_field_types() {
			return array(
				'text'     => esc_html__( 'Text', 'pro-pack-for-wp-job-openings' ),
				'email'    => esc_html__( 'Email', 'pro-pack-for-wp-job-openings' ),
				'number'   => esc_html__( 'Number', 'pro-pack-for-wp-job-openings' ),
				'tel'      => esc_html__( 'Phone', 'pro-pack-for-wp-job-openings' ),
				'textarea' => esc_html__( 'Textarea', 'pro-pack-for-wp-job-openings' ),
				'select'   => esc_html__( 'Dropdown', 'pro-pack-for-wp-job-openings' ),
				'radio'    => esc_html__( 'Radio', 'pro-pack-for-wp-job-openings' ),
				'checkbox' => esc_html__( 'Checkbox', 'pro-pack-for-wp-job-openings' ),
				'resume'   => esc_html__( 'Resume', 'pro-pack-for-wp-job-openings' ),
				'photo'    => esc_html__( 'Photo', 'pro-pack-for-wp-job-openings' ),
				'file'     => esc_html__( 'File', 'pro-pack-for-wp-job-openings' ),
			);
		}

		public function generate_unique_name( $field_type, $options ) {
			$new_number = 1;
			$prefix     = "awsm_{$field_type}_";
			$names      = array();
			foreach ( $options as $option ) {
				if ( isset( $option['name'] ) && ! $option['default_field'] ) {
					if ( strpos( $option['name'], $prefix ) !== false ) {
						$names[] = $option['name'];
					}
				}
			}
			if ( ! empty( $names ) ) {
				natsort( $names );
				$last_name = end( $names );
				$number    = str_replace( $prefix, '', $last_name );
				if ( intval( $number ) ) {
					$new_number = (int) $number + 1;
				}
			}
			return sanitize_text_field( $prefix . $new_number );
		}

		public function form_builder_handler( $fb_options ) {
			$old_options         = get_option( 'awsm_jobs_form_builder' );
			$is_error            = false;
			$count_resume_fields = $count_photo_fields = 0; // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments.Found
			if ( ! empty( $fb_options ) ) {
				foreach ( $fb_options as $key => $fb_option ) {
					$field_type                          = sanitize_text_field( $fb_option['field_type'] );
					$default_field                       = isset( $fb_option['default_field'] ) && ( strval( $fb_option['default_field'] ) === 'default' || $fb_option['default_field'] === true ) ? true : false;
					$default_field                       = $field_type === 'resume' ? true : $default_field;
					$fb_options[ $key ]['default_field'] = $default_field;
					if ( $field_type === 'resume' || $field_type === 'photo' ) {
						/* translators: %s: form field type */
						$unique_field_msg = esc_html__( 'Sorry! You can only have one %s field', 'pro-pack-for-wp-job-openings' );
						if ( $field_type === 'resume' ) {
							$count_resume_fields ++;
						} else {
							$count_photo_fields ++;
						}
						if ( $count_resume_fields > 1 || $count_photo_fields > 1 ) {
							add_settings_error( 'awsm_jobs_form_builder', 'awsm-jobs-fb-settings', sprintf( $unique_field_msg, $field_type ) );
							$is_error = true;
							break;
						}
					}
					$field_name = '';
					if ( ! isset( $fb_option['name'] ) ) {
						if ( ! $default_field ) {
							if ( $field_type === 'photo' ) {
								$field_name = 'awsm_applicant_photo';
							} else {
								$field_name = $this->generate_unique_name( $field_type, $fb_options );
							}
						} else {
							if ( $field_type === 'resume' ) {
								$field_name = 'awsm_file';
							}
						}
					} else {
						$field_name = sanitize_text_field( $fb_option['name'] );
					}
					$fb_options[ $key ]['name'] = $field_name;
					$label                      = isset( $fb_option['label'] ) ? sanitize_text_field( $fb_option['label'] ) : '';
					if ( empty( $label ) ) {
						add_settings_error( 'awsm_jobs_form_builder', 'awsm-jobs-fb-settings', esc_html__( '"Label" cannot be empty!', 'pro-pack-for-wp-job-openings' ) );
						$is_error = true;
						break;
					}
					$fb_options[ $key ]['label']      = $label;
					$fb_options[ $key ]['field_type'] = $field_type;
					$field_options                    = isset( $fb_option['field_options'] ) ? sanitize_text_field( $fb_option['field_options'] ) : '';
					if ( $field_type === 'select' || $field_type === 'checkbox' || $field_type === 'radio' ) {
						if ( empty( $field_options ) ) {
							add_settings_error( 'awsm_jobs_form_builder', 'awsm-jobs-fb-settings', esc_html__( 'Please enter options for the selected field type.', 'pro-pack-for-wp-job-openings' ) );
							$is_error = true;
							break;
						}
					}
					$fb_options[ $key ]['field_options'] = $field_options;
					$fb_options[ $key ]['required']      = isset( $fb_option['required'] ) ? sanitize_text_field( $fb_option['required'] ) : '';
					$fb_options[ $key ]['active']        = 'active';
					// handle miscellaneous options for all fields.
					$misc_options = isset( $fb_option['misc_options'] ) && is_array( $fb_option['misc_options'] ) ? $fb_option['misc_options'] : array();
					if ( ! empty( $misc_options ) ) {
						$default_tmpl_tags = array( 'applicant', 'application-id', 'applicant-email', 'applicant-phone', 'applicant-resume', 'applicant-cover', 'job-title', 'job-id', 'job-expiry', 'admin-email', 'hr-email', 'company' );
						foreach ( $misc_options  as $misc_option_key => $misc_option ) {
							$misc_options[ $misc_option_key ] = sanitize_text_field( $misc_option );
							if ( $misc_option_key === 'template_tag' && ! empty( $misc_option ) ) {
								if ( in_array( $misc_option, $default_tmpl_tags ) ) {
									/* translators: %s: template tag */
									add_settings_error( 'awsm_jobs_form_builder', 'awsm-jobs-fb-settings', sprintf( esc_html__( '%s is a Reserved Template Tag! Please specify a different value.', 'pro-pack-for-wp-job-openings' ), '<em>' . esc_html( $misc_option ) . '</em>' ) );
									unset( $misc_options[ $misc_option_key ] );
								} else {
									if ( ! preg_match( '/^([a-z0-9]+(-|_))*[a-z0-9]+$/', $misc_option ) ) {
										add_settings_error( 'awsm_jobs_form_builder', 'awsm-jobs-fb-settings', esc_html__( 'The template tag should only contain alphanumeric, latin characters separated by hyphen/underscore', 'pro-pack-for-wp-job-openings' ) );
										unset( $misc_options[ $misc_option_key ] );
									} else {
										if ( is_array( $old_options ) ) {
											$is_valid_tag = true;
											foreach ( $old_options as $old_option ) {
												$old_tag = isset( $old_option['misc_options'] ) && isset( $old_option['misc_options']['template_tag'] ) ? $old_option['misc_options']['template_tag'] : '';
												if ( $field_name !== $old_option['name'] && $old_tag === $misc_option ) {
													$is_valid_tag = false;
													break;
												}
											}
											if ( ! $is_valid_tag ) {
												/* translators: %s: template tag */
												add_settings_error( 'awsm_jobs_form_builder', 'awsm-jobs-fb-settings', sprintf( esc_html__( 'Template Tag %s is already in use! Please specify a different value.', 'pro-pack-for-wp-job-openings' ), '<em>' . esc_html( $misc_option ) . '</em>' ) );
												unset( $misc_options[ $misc_option_key ] );
											}
										}
									}
								}
							}
						}
					}
					$fb_options[ $key ]['misc_options'] = $misc_options;

					// handle super fields.
					if ( $field_name === 'awsm_applicant_name' || $field_name === 'awsm_applicant_email' ) {
						$fb_options[ $key ]['super_field']   = true;
						$fb_options[ $key ]['default_field'] = true;
						$fb_options[ $key ]['required']      = 'required';
					} else {
						$fb_options[ $key ]['super_field'] = false;
					}
				}
				$fb_options = array_values( $fb_options );
			}
			if ( $is_error === true ) {
				$fb_options = $old_options;
			}
			return $fb_options;
		}

		public function form_builder_other_options_handler( $options ) {
			if ( ! empty( $options ) ) {
				$options['form_title']       = isset( $options['form_title'] ) ? sanitize_text_field( $options['form_title'] ) : '';
				$options['form_description'] = isset( $options['form_description'] ) ? awsm_jobs_sanitize_textarea( $options['form_description'] ) : '';
				$options['btn_text']         = isset( $options['btn_text'] ) ? sanitize_text_field( $options['btn_text'] ) : '';
				if ( empty( $options['btn_text'] ) ) {
					$options['btn_text'] = esc_html__( 'Submit', 'wp-job-openings' );
				}
			}
			return $options;
		}

		public function email_template_handler( $et_options ) {
			if ( ! empty( $et_options ) ) {
				$options_count = count( $et_options );
				foreach ( $et_options as $index => $et_option ) {
					$template_name = isset( $et_option['name'] ) ? sanitize_text_field( $et_option['name'] ) : '';
					if ( empty( $template_name ) ) {
						unset( $et_options[ $index ] );
						if ( $options_count > 1 ) {
							add_settings_error( 'awsm_jobs_pro_mail_templates', 'awsm-jobs-mail-templates-settings', esc_html__( 'Template Name cannot be empty!', 'pro-pack-for-wp-job-openings' ) );
						}
						continue;
					}
					$template_key = isset( $et_option['key'] ) ? sanitize_text_field( $et_option['key'] ) : str_replace( ' ', '-', strtolower( $template_name ) );
					if ( ! isset( $et_option['key'] ) ) {
						$template_keys = wp_list_pluck( $et_options, 'key' );
						if ( in_array( $template_key, $template_keys, true ) ) {
							unset( $et_options[ $index ] );
							/* translators: %s: user supplied template name */
							add_settings_error( 'awsm_jobs_pro_mail_templates', 'awsm-jobs-mail-templates-settings', sprintf( esc_html__( 'Template Name: "%s" already exists!', 'pro-pack-for-wp-job-openings' ), $template_name ) );
							continue;
						}
					}
					$et_options[ $index ]['key']     = $template_key;
					$et_options[ $index ]['name']    = $template_name;
					$et_options[ $index ]['subject'] = isset( $et_option['subject'] ) ? sanitize_text_field( $et_option['subject'] ) : '';
					$et_options[ $index ]['content'] = isset( $et_option['content'] ) ? awsm_jobs_sanitize_textarea( $et_option['content'] ) : '';
				}
				$et_options = array_values( $et_options );
			}
			return $et_options;
		}

		public function license_handler( $license_key ) {
			if ( ! empty( $license_key ) ) {
				$license_key  = sanitize_text_field( $license_key );
				$options      = array(
					'timeout' => 10,
					'headers' => array(
						'Accept' => 'application/json',
					),
				);
				$args['code'] = rawurlencode( $license_key );
				if ( method_exists( 'AWSM_Job_Openings_Pro_Pack', 'get_kernl_url' ) ) {
					$url    = add_query_arg( $args, AWSM_Job_Openings_Pro_Pack::get_kernl_url() );
					$result = wp_remote_get( $url, $options );
					if ( ! is_wp_error( $result ) && isset( $result['response'] ) && isset( $result['response']['code'] ) && ( $result['response']['code'] === 200 ) ) {
						return $license_key;
					} else {
						add_settings_error( 'awsm_jobs_pro_license', 'awsm-jobs-pro-license-settings', esc_html__( 'Invalid Envato purchase key!', 'pro-pack-for-wp-job-openings' ) );
						return false;
					}
				}
			} else {
				add_settings_error( 'awsm_jobs_pro_license', 'awsm-jobs-pro-license-settings', esc_html__( 'License key cannot be empty!', 'pro-pack-for-wp-job-openings' ) );
				return false;
			}
			return $license_key;
		}

		public function fb_field_options_template( $index, $fb_option = array() ) {
			?>
			<p>
				<label for="awsm-jobs-form-builder-type-options-<?php echo esc_attr( $index ); ?>"><?php esc_html_e( 'Field Options:', 'pro-pack-for-wp-job-openings' ); ?>
					<textarea class="awsm-job-fb-options-control" id="awsm-jobs-form-builder-type-options-<?php esc_attr( $index ); ?>" name="awsm_jobs_form_builder[<?php echo esc_attr( $index ); ?>][field_options]" cols="25" rows="2" placeholder="<?php echo esc_attr__( 'Please enter options separated by commas', 'pro-pack-for-wp-job-openings' ); ?>" required><?php echo isset( $fb_option['field_options'] ) ? esc_textarea( $fb_option['field_options'] ) : ''; ?></textarea>
				</label>
			</p>
			<?php
		}

		public function fb_file_type_options_template( $index, $fb_option = array() ) {
			?>
			<p>
				<input type="checkbox" id="awsm-jobs-form-builder-mail-attachment-<?php echo esc_attr( $index ); ?>" name="awsm_jobs_form_builder[<?php echo esc_attr( $index ); ?>][misc_options][mail_attachment]" value="attach"
				<?php
					checked(
						isset( $fb_option['misc_options'] ) && isset( $fb_option['misc_options']['mail_attachment'] ) ? $fb_option['misc_options']['mail_attachment'] : '',
						'attach'
					);
				?>
				 />
				<label for="awsm-jobs-form-builder-mail-attachment-<?php echo esc_attr( $index ); ?>">
					<?php esc_html_e( 'Attach the file with email notifications', 'pro-pack-for-wp-job-openings' ); ?>
				</label>
			</p>
			<?php
		}

		public function fb_field_tag_template( $index, $fb_option = array() ) {
			?>
				<p>
					<label for="awsm-jobs-form-builder-template-tag-<?php echo esc_attr( $index ); ?>"><?php esc_html_e( 'Template Tag:', 'pro-pack-for-wp-job-openings' ); ?>
						<input type="text" class="widefat awsm-jobs-form-builder-template-tag" id="awsm-jobs-form-builder-template-tag-<?php echo esc_attr( $index ); ?>" name="awsm_jobs_form_builder[<?php echo esc_attr( $index ); ?>][misc_options][template_tag]" placeholder="<?php echo esc_attr__( 'Template Tag to be used in the notification', 'pro-pack-for-wp-job-openings' ); ?>" value="<?php echo isset( $fb_option['misc_options'] ) && isset( $fb_option['misc_options']['template_tag'] ) ? esc_attr( $fb_option['misc_options']['template_tag'] ) : ''; ?>" >
					</label>
				</p>
			<?php
		}

		public function fb_template( $index, $fb_option = array() ) {
			if ( ! empty( $fb_option ) && ! is_numeric( $index ) ) {
				return;
			}

			$field_types = self::form_builder_field_types();
			$main_class  = ! is_numeric( $index ) ? ' open' : '';
			$title       = esc_html__( 'New input field', 'pro-pack-for-wp-job-openings' );
			$super_field = $default_field = false; // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments.Found
			$field_type  = 'text';
			$label       = $field_type_label = $hidden_fields = ''; // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments.Found

			if ( ! empty( $fb_option ) ) {
				$super_field      = $fb_option['super_field'];
				$default_field    = $fb_option['default_field'];
				$title            = $fb_option['label'];
				$field_type       = $fb_option['field_type'];
				$label            = $fb_option['label'];
				$field_type_label = isset( $field_types[ $field_type ] ) ? $field_types[ $field_type ] : '';
				$hidden_fields    = sprintf( '<input type="hidden" name="awsm_jobs_form_builder[%s][name]" value="%s" />', esc_attr( $index ), esc_attr( $fb_option['name'] ) );
				if ( $super_field ) {
					$hidden_fields .= sprintf( '<input type="hidden" name="awsm_jobs_form_builder[%s][super_field]" value="super" />', esc_attr( $index ) );
				}
				if ( $default_field ) {
					$hidden_fields .= sprintf( '<input type="hidden" name="awsm_jobs_form_builder[%s][default_field]" value="default" />', esc_attr( $index ) );
				}
			}
			?>
			<div class="awsm-jobs-form-element-main<?php echo esc_attr( $main_class ); ?>">
				<div class="awsm-jobs-form-element-head">
					<div class="awsm-jobs-form-element-head-title">
						<h3>
							<span class="awm-jobs-form-builder-title">
								<?php echo esc_html( $title ); ?>
							</span>
							<span class="awm-jobs-form-builder-input-type">
								<?php echo esc_html( $field_type_label ); ?>
							</span>
						</h3>
					</div>
				</div><!-- .awsm-jobs-form-element-head -->
				<div class="awsm-jobs-form-element-content">
					<div class="awsm-jobs-form-element-content-in">
						<?php echo $hidden_fields; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<p>
							<div class="awsm-jobs-form-builder-type-wrapper">
								<label for="awsm-jobs-form-builder-type-<?php echo esc_attr( $index ); ?>"><?php esc_html_e( 'Field Type:', 'pro-pack-for-wp-job-openings' ); ?>
									<select class="awsm-builder-field-select-control awsm-select-control" name="awsm_jobs_form_builder[<?php echo esc_attr( $index ); ?>][field_type]" id="awsm-jobs-form-builder-type-<?php echo esc_attr( $index ); ?>" style="width: 100%;" data-index="<?php echo esc_attr( $index ); ?>">
									<?php
									foreach ( $field_types as $value => $text ) {
										$attrs = $value === $field_type ? ' selected' : '';
										if ( $default_field || $field_type === 'photo' ) {
											$attrs .= $field_type !== $value ? ' disabled' : '';
										}
										printf( '<option value="%1$s"%3$s>%2$s</option>', esc_attr( $value ), esc_html( $text ), esc_attr( $attrs ) );
									}
									?>
									</select>
								</label>
								<div class="awsm-job-fb-options-container">
									<?php
									if ( $field_type === 'select' || $field_type === 'radio' || $field_type === 'checkbox' ) {
										$this->fb_field_options_template( $index, $fb_option );
									} elseif ( $field_type === 'file' || $field_type === 'resume' || $field_type === 'photo' ) {
										$this->fb_file_type_options_template( $index, $fb_option );
									}
									?>
								</div>
							</div>
						</p>
						<p>
							<label for="awsm-jobs-form-builder-label-<?php echo esc_attr( $index ); ?>"><?php esc_html_e( 'Label:', 'pro-pack-for-wp-job-openings' ); ?>
								<input type="text" class="widefat awsm_jobs_form_builder_label" id="awsm-jobs-form-builder-label-<?php echo esc_attr( $index ); ?>" name="awsm_jobs_form_builder[<?php echo esc_attr( $index ); ?>][label]" value="<?php echo esc_attr( $label ); ?>" required />
							</label>
						</p>
						<div class="awsm-job-fb-template-key">
						<?php
						if ( ! $default_field && $field_type !== 'resume' && $field_type !== 'file' && $field_type !== 'photo' ) {
							$this->fb_field_tag_template( $index, $fb_option );
						}
						?>
						</div>
						<p>
							<label for="awsm-jobs-form-builder-required-field-<?php echo esc_attr( $index ); ?>">
									<?php
									$attrs = '';
									if ( ! empty( $fb_option ) ) {
										$attrs = ' ' . $this->is_settings_field_checked( $fb_option['required'], 'required' );
										if ( $super_field ) {
											$attrs .= ' disabled';
										}
									}
									?>
								<input type="checkbox" name="awsm_jobs_form_builder[<?php echo esc_attr( $index ); ?>][required]" class="awsm-form-builder-required-field" id="awsm-jobs-form-builder-required-field-<?php echo esc_attr( $index ); ?>" value="required"<?php echo esc_attr( $attrs ); ?> /><?php esc_html_e( 'Required Field', 'pro-pack-for-wp-job-openings' ); ?>
							</label>
						</p>
						<p>
								<?php if ( ! $super_field ) : ?>
									<a class="button-link awsm-text-red awsm-form-field-remove-row" href="#" ><?php esc_html_e( 'Delete', 'pro-pack-for-wp-job-openings' ); ?></a>
									<span> | </span>
							<?php endif; ?>

							<button type="button" class="button-link awsm-jobs-form-element-close"><?php esc_html_e( 'Close', 'pro-pack-for-wp-job-openings' ); ?></button>
						</p>
					</div><!-- .awsm-jobs-form-element-content-in -->
				</div><!-- .awsm-jobs-form-element-content -->
			</div><!-- .awsm-jobs-form-element-main -->
			<?php
		}

		public function mail_template( $index, $template = array() ) {
			if ( ! empty( $template ) && ! is_numeric( $index ) ) {
				return;
			}

			$title_format = '<span class="awsm-jobs-pro-mail-template-title">%s</span>%s';
			$subtitle     = sprintf( '<span class="awsm-jobs-pro-mail-template-subtitle hidden">%s</span>', esc_html__( '(Not Saved...)', 'pro-pack-for-wp-job-openings' ) );
			$title        = sprintf( $title_format, esc_html__( 'New Template', 'pro-pack-for-wp-job-openings' ), $subtitle );

			$name          = $subject = $content = $hidden_fields = ''; // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments.Found
			$header_class  = ' on';
			$content_style = ! is_numeric( $index ) ? ' style="display: block;"' : '';
			if ( ! empty( $template ) ) {
				$name          = $template['name'];
				$header_class  = $index === 0 ? $header_class : '';
				$title         = sprintf( $title_format, esc_html( $name ), '' );
				$subject       = $template['subject'];
				$content       = $template['content'];
				$hidden_fields = sprintf( '<input type="hidden" name="awsm_jobs_pro_mail_templates[%s][key]" value="%s" />', esc_attr( $index ), esc_attr( $template['key'] ) );
			}
			?>
			<div class="awsm-acc-main">
				<div class="awsm-jobs-pro-mail-template-header awsm-acc-head<?php echo esc_attr( $header_class ); ?>">
					<h3>
						<?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</h3>
				</div><!-- .awsm-acc-head -->
				<div class="awsm-acc-content"<?php echo $content_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
					<div class="form-group-1 col-md-6">
						<div class="awsm-row" data-index="<?php echo esc_attr( $index ); ?>">
							<div class="awsm-col awsm-form-group awsm-col-full">
								<label for="awsm-jobs-pro-mail-name-<?php echo esc_attr( $index ); ?>"><?php esc_html_e( 'Template Name', 'pro-pack-for-wp-job-openings' ); ?></label>
								<input type="text" name="awsm_jobs_pro_mail_templates[<?php echo esc_attr( $index ); ?>][name]" class="awsm-form-control awsm-jobs-pro-mail-template-name" id="awsm-jobs-pro-mail-name-<?php echo esc_attr( $index ); ?>" value="<?php echo esc_attr( $name ); ?>" data-required="required" />
								<?php echo $hidden_fields; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div><!-- .col -->
							<div class="awsm-col awsm-form-group awsm-col-full">
								<label for="awsm-jobs-pro-mail-subject-<?php echo esc_attr( $index ); ?>"><?php esc_html_e( 'Subject ', 'pro-pack-for-wp-job-openings' ); ?></label>
									<input type="text" class="awsm-form-control" id="awsm-jobs-pro-mail-subject-<?php echo esc_attr( $index ); ?>" name="awsm_jobs_pro_mail_templates[<?php echo esc_attr( $index ); ?>][subject]" value="<?php echo esc_attr( $subject ); ?>"  />
							</div><!-- .col -->
							<div class="awsm-col awsm-form-group awsm-col-full">
								<label for="awsm-jobs-pro-mail-content-<?php echo esc_attr( $index ); ?>"><?php esc_html_e( 'Content ', 'pro-pack-for-wp-job-openings' ); ?></label>
									<textarea class="awsm-form-control" id="awsm-jobs-pro-mail-content-<?php echo esc_attr( $index ); ?>" name="awsm_jobs_pro_mail_templates[<?php echo esc_attr( $index ); ?>][content]" rows="5" cols="50"><?php echo esc_textarea( $content ); ?></textarea>
							</div><!-- .col -->
						</div><!-- row -->
					</div>
					<ul class="awsm-list-inline">
						<li><?php echo apply_filters( 'awsm_job_settings_submit_btn', get_submit_button( esc_html__( 'Save', 'pro-pack-for-wp-job-openings' ) ), 'notification' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></li>
						<li><a href="#" class="awsm-text-red awsm-remove-mail-template"><?php esc_html_e( 'Delete template', 'pro-pack-for-wp-job-openings' ); ?></a></li>
					</ul>
				</div><!-- .awsm-acc-content -->
			</div><!-- .awsm-acc-main -->
			<?php
		}

		public function custom_template_tags( $tags ) {
			$fb_options = get_option( 'awsm_jobs_form_builder' );
			if ( is_array( $fb_options ) ) {
				$removable_tags = array(
					'{applicant-phone}'  => 'awsm_applicant_phone',
					'{applicant-resume}' => 'awsm_file',
					'{applicant-cover}'  => 'awsm_applicant_letter',
				);
				foreach ( $fb_options as $fb_option ) {
					if ( $fb_option['default_field'] !== true && $fb_option['field_type'] !== 'photo' && $fb_option['field_type'] !== 'file' ) {
							$template_tag = isset( $fb_option['misc_options'] ) && isset( $fb_option['misc_options']['template_tag'] ) ? $fb_option['misc_options']['template_tag'] : '';
						if ( ! empty( $template_tag ) ) {
							$key          = sprintf( '{%s}', $template_tag );
							$tags[ $key ] = $fb_option['label'] . ':';
						}
					} else {
						if ( $fb_option['super_field'] !== true ) {
							$field_name = $fb_option['name'];
							$tag        = array_search( $field_name, $removable_tags );
							if ( $tag !== false ) {
								unset( $removable_tags[ $tag ] );
							}
						}
					}
				}
				if ( ! empty( $removable_tags ) ) {
					foreach ( $removable_tags as $removable_tag => $field_name ) {
						unset( $tags[ $removable_tag ] );
					}
				}
			}
			return $tags;
		}
	}

	AWSM_Job_Openings_Pro_Settings::init();

endif; // end of class check
