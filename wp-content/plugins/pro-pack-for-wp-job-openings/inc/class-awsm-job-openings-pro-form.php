<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'AWSM_Job_Openings_Form' ) ) :

	class AWSM_Job_Openings_Pro_Form extends AWSM_Job_Openings_Form {
		private static $instance = null;

		public function __construct() {
			$this->cpath = untrailingslashit( plugin_dir_path( __FILE__ ) );
			add_action( 'wp_loaded', array( $this, 'remove_hooks' ) );
			add_filter( 'awsm_application_form_fields_order', array( $this, 'pro_form_fields_order' ), 100 );
			add_filter( 'awsm_application_form_fields', array( $this, 'pro_form_fields' ), 100 );
			add_filter( 'awsm_application_form_title', array( $this, 'application_form_title' ) );
			add_action( 'awsm_application_form_description', array( $this, 'application_form_description' ) );
			add_filter( 'awsm_application_form_submit_btn_text', array( $this, 'application_btn_text' ) );
			add_action( 'before_awsm_job_details', array( $this, 'insert_application' ) );
			add_action( 'wp_ajax_awsm_applicant_form_submission', array( $this, 'ajax_handle' ) );
			add_action( 'wp_ajax_nopriv_awsm_applicant_form_submission', array( $this, 'ajax_handle' ) );
			add_filter( 'awsm_jobs_admin_notification_mail_attachments', array( $this, 'admin_notification_mail_attachments' ), 10, 2 );
			add_filter( 'awsm_jobs_admin_notification_mail_headers', array( $this, 'job_forward_notification_email' ), 10, 2 );
			add_filter( 'awsm_jobs_mail_template_tags', array( $this, 'pro_mail_template_tags' ), 10, 2 );
		}

		public static function init() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function remove_hooks() {
			remove_action( 'before_awsm_job_details', array( AWSM_Job_Openings_Form::init(), 'insert_application' ) );
			remove_action( 'wp_ajax_awsm_applicant_form_submission', array( AWSM_Job_Openings_Form::init(), 'ajax_handle' ) );
			remove_action( 'wp_ajax_nopriv_awsm_applicant_form_submission', array( AWSM_Job_Openings_Form::init(), 'ajax_handle' ) );
		}

		public function pro_form_fields_order( $form_fields_order ) {
			$fb_options = get_option( 'awsm_jobs_form_builder' );
			if ( ! empty( $fb_options ) ) {
				$form_fields_order = array();
				foreach ( $fb_options as $fb_option ) {
					$form_fields_order[] = $fb_option['name'];
				}
			}
			return $form_fields_order;
		}

		public function get_field_options( $options_list ) {
			$field_options = array();
			if ( ! empty( $options_list ) ) {
				$options = explode( ',', $options_list );
				foreach ( $options as $option ) {
					$option          = trim( $option );
					$field_options[] = $option;
				}
			}
			return $field_options;
		}

		public function pro_form_fields( $fields ) {
			$fb_options = get_option( 'awsm_jobs_form_builder' );
			if ( ! empty( $fb_options ) ) {
				foreach ( $fb_options as $fb_option ) {
					$name                     = $fb_option['name'];
					$fields[ $name ]['label'] = apply_filters( 'wpml_translate_single_string', $fb_option['label'], 'pro-pack-for-wp-job-openings', 'Application Form: Label for ' . $name );
					if ( ! $fb_option['super_field'] ) {
						$fields[ $name ]['show_field'] = $fb_option['active'] === 'active' ? true : false;
						$fields[ $name ]['required']   = $fb_option['required'] === 'required' ? true : false;
						if ( $fb_option['default_field'] === false ) {
							$field_type = $fb_option['field_type'];
							if ( $field_type === 'textarea' ) {
								$fields[ $name ]['field_type']['tag'] = 'textarea';
							} elseif ( $field_type === 'select' ) {
								$fields[ $name ]['field_type']['tag'] = 'select';
							} else {
								$fields[ $name ]['field_type']['tag'] = 'input';
								if ( $field_type === 'photo' ) {
									$field_type           = 'file';
									$allowed_file_types   = array(
										'jpg' => 'jpg|jpeg|jpe',
										'png' => 'png',
									);
									$allowed_file_content = '';
									if ( is_array( $allowed_file_types ) && ! empty( $allowed_file_types ) ) {
										$allowed_file_types = '.' . join( ', .', array_keys( $allowed_file_types ) );
										/* translators: %1$s: allowed file types */
										$allowed_file_content                    = '<small>' . sprintf( esc_html__( 'Allowed Type(s): %1$s', 'wp-job-openings' ), $allowed_file_types ) . '</small>';
										$fields[ $name ]['field_type']['accept'] = $allowed_file_types;
										$fields[ $name ]['content']              = $allowed_file_content;
									}
								}
								$fields[ $name ]['field_type']['type'] = $field_type;
							}
							$fields[ $name ]['class'] = array( 'awsm-job-form-control' );
							if ( $field_type === 'photo' || $field_type === 'file' ) {
								$fields[ $name ]['class'][] = 'awsm-form-file-control';
							}
							if ( $field_type === 'select' || $field_type === 'checkbox' || $field_type === 'radio' ) {
								$options_list                             = isset( $fb_option['field_options'] ) ? $fb_option['field_options'] : '';
								$fields[ $name ]['field_type']['options'] = $this->get_field_options( $options_list );
								if ( $field_type === 'select' ) {
									$fields[ $name ]['class'][] = 'awsm-job-select-control';
								} else {
									$fields[ $name ]['class'] = array( 'awsm-job-form-options-control' );
								}
							}
						}
					}
				}
			}
			return $fields;
		}

		public function application_form_title( $title ) {
			$options = get_option( 'awsm_jobs_form_builder_other_options' );
			if ( ! empty( $options ) && isset( $options['form_title'] ) ) {
				$title = apply_filters( 'wpml_translate_single_string', $options['form_title'], 'pro-pack-for-wp-job-openings', 'Application Form: Form Title' );
			}
			return $title;
		}

		public function application_form_description() {
			$options          = get_option( 'awsm_jobs_form_builder_other_options' );
			$form_description = apply_filters( 'wpml_translate_single_string', $options['form_description'], 'pro-pack-for-wp-job-openings', 'Application Form: Form Description' );
			if ( ! empty( $options ) && isset( $form_description ) && ! empty( $form_description ) ) {
				printf(
					'<div class="awsm-job-form-description">%s</div>',
					wp_kses(
						wpautop( $form_description ),
						array(
							'p'  => array(),
							'br' => array(),
						)
					)
				);
			}
		}

		public function application_btn_text( $text ) {
			$options  = get_option( 'awsm_jobs_form_builder_other_options' );
			$btn_text = apply_filters( 'wpml_translate_single_string', $options['btn_text'], 'pro-pack-for-wp-job-openings', 'Application Form: Btn Text' );
			if ( ! empty( $options ) && isset( $btn_text ) ) {
				$text = $btn_text;
			}
			return $text;
		}

		public function handle_file_upload( $type, $file ) {
			if ( ! function_exists( 'wp_handle_upload' ) ) {
				require_once ABSPATH . 'wp-admin/includes/file.php';
			}
			if ( ! function_exists( 'wp_crop_image' ) ) {
				require_once ABSPATH . 'wp-admin/includes/image.php';
			}

			$allowed_types      = array();
			$allowed_mime_types = get_allowed_mime_types();

			if ( $type === 'resume' ) {
				$allowed_types = get_option( 'awsm_jobs_admin_upload_file_ext' );
			} elseif ( $type === 'photo' ) {
				$allowed_types = array( 'jpg|jpeg|jpe', 'png' );
			}

			$mimes = array();
			if ( ! empty( $allowed_types ) ) {
				foreach ( $allowed_types as $allowed_type ) {
					if ( isset( $allowed_mime_types[ $allowed_type ] ) ) {
						$mimes[ $allowed_type ] = $allowed_mime_types[ $allowed_type ];
					}
				}
			}

			$upload_overrides = array(
				'test_form'                => false,
				'mimes'                    => $mimes,
				'unique_filename_callback' => array( $this, 'hashed_file_name' ),
			);

			add_filter( 'upload_dir', array( $this, 'upload_dir' ) );
			$movefile = wp_handle_upload( $file, $upload_overrides );
			remove_filter( 'upload_dir', array( $this, 'upload_dir' ) );
			return $movefile;
		}

		public function insert_application() {
			global $awsm_response;

			$awsm_response = array(
				'success' => array(),
				'error'   => array(),
			);
			// phpcs:disable WordPress.Security.NonceVerification.Missing
			if ( $_SERVER['REQUEST_METHOD'] === 'POST' && ! empty( $_POST['action'] ) && $_POST['action'] === 'awsm_applicant_form_submission' ) {
				$job_id               = intval( $_POST['awsm_job_id'] );
				$agree_privacy_policy = false;
				$generic_err_msg      = esc_html__( 'Error in submitting your application. Please refresh the page and retry.', 'wp-job-openings' );
				if ( $this->is_recaptcha_set() ) {
					$is_human = false;
					if ( isset( $_POST['g-recaptcha-response'] ) ) {
						$is_human = $this->validate_captcha_field( $_POST['g-recaptcha-response'] );
					}
					if ( ! $is_human ) {
						$awsm_response['error'][] = esc_html__( 'Please verify that you are not a robot.', 'wp-job-openings' );
					}
				}
				if ( $this->get_gdpr_field_label() !== false ) {
					if ( ! isset( $_POST['awsm_form_privacy_policy'] ) || $_POST['awsm_form_privacy_policy'] !== 'yes' ) {
						$awsm_response['error'][] = esc_html__( 'Please agree to our privacy policy.', 'wp-job-openings' );
					} else {
						$agree_privacy_policy = sanitize_text_field( $_POST['awsm_form_privacy_policy'] );
					}
				}
				if ( get_post_type( $job_id ) !== 'awsm_job_openings' ) {
					$awsm_response['error'][] = esc_html__( 'Error occurred: Invalid Job.', 'wp-job-openings' );
				}
				if ( get_post_status( $job_id ) === 'expired' ) {
					$awsm_response['error'][] = esc_html__( 'Sorry! This job is expired.', 'wp-job-openings' );
				}

				$fields          = array();
				$generic_req_msg = esc_html__( 'Please fill the required field.', 'pro-pack-for-wp-job-openings' );
				/* translators: %s: application form field label */
				$req_msg = esc_html__( '%s is required.', 'pro-pack-for-wp-job-openings' );

				$fb_options = get_option( 'awsm_jobs_form_builder' );
				if ( empty( $fb_options ) ) {
					$fb_options = array();
					if ( method_exists( 'AWSM_Job_Openings_Pro_Settings', 'form_builder_default_options' ) ) {
						$fb_options = AWSM_Job_Openings_Pro_Settings::form_builder_default_options();
					}
				}

				foreach ( $fb_options as $fb_option ) :
					if ( $fb_option['active'] === 'active' ) {
						$field_value = '';
						$field_label = $fb_option['label'];
						$field_name  = $fb_option['name'];
						$field_type  = $fb_option['field_type'];

						if ( ( $field_type !== 'resume' || $field_type !== 'photo' || $field_type !== 'file' ) && isset( $_POST[ $field_name ] ) ) {
							switch ( $field_type ) {
								case 'email':
									$field_value = sanitize_email( $_POST[ $field_name ] );
									break;
								case 'number':
									$field_value = intval( $_POST[ $field_name ] );
									break;
								case 'url':
									$field_value = esc_url_raw( $_POST[ $field_name ] );
									break;
								case 'checkbox':
									$field_value = is_array( $_POST[ $field_name ] ) ? sanitize_text_field( join( ', ', $_POST[ $field_name ] ) ) : '';
									break;
								case 'textarea':
									$field_value = awsm_jobs_sanitize_textarea( $_POST[ $field_name ] );
									break;
								default:
									$field_value = sanitize_text_field( $_POST[ $field_name ] );
									break;
							}
						} else {
							$field_value = isset( $_FILES[ $field_name ] ) ? $_FILES[ $field_name ] : '';
						}

						if ( $fb_option['required'] === 'required' ) {
							if ( empty( $field_value ) && ! is_numeric( $field_value ) ) {
								$awsm_response['error'][] = ! empty( $field_label ) ? sprintf( $req_msg, $field_label ) : $generic_req_msg;
							} else {
								$field_error = '';
								if ( $field_type === 'email' && ! filter_var( $field_value, FILTER_VALIDATE_EMAIL ) ) {
									$field_error = esc_html__( 'Invalid email format.', 'wp-job-openings' );
								} elseif ( $field_type === 'tel' && ! preg_match( '%^[+]?[0-9()/ -]*$%', trim( $field_value ) ) ) {
									$field_error = esc_html__( 'Invalid phone number.', 'wp-job-openings' );
								} elseif ( $field_type === 'resume' || $field_type === 'photo' || $field_type === 'file' ) {
									if ( $field_value['error'] > 0 ) {
										/* translators: %s: application form field type */
										$field_error = sprintf( esc_html__( 'Please select %s.', 'pro-pack-for-wp-job-openings' ), $field_type );
									}
								}
								if ( ! empty( $field_error ) ) {
									$awsm_response['error'][] = $field_error;
								}
							}
						}

						if ( $field_type === 'resume' || $field_type === 'photo' || $field_type === 'file' ) {
							if ( count( $awsm_response['error'] ) > 0 ) {
								continue;
							}

							if ( ! isset( $field_value['error'] ) || $field_value['error'] > 0 ) {
								$field_value = '';
							} else {
								$movefile = $this->handle_file_upload( $field_type, $field_value );
								if ( $movefile && ! isset( $movefile['error'] ) ) {
									$field_value = $movefile;
								} else {
									$awsm_response['error'][] = $movefile['error'];
									break;
								}
							}
						}

						$fields[ $field_name ] = array(
							'value' => $field_value,
							'type'  => $field_type,
							'spec'  => 'default',
						);
						if ( $fb_option['default_field'] === false ) {
							$fields[ $field_name ]['label'] = $field_label;
							$fields[ $field_name ]['spec']  = 'custom';
						}
					}
				endforeach;

				do_action( 'awsm_job_application_submitting' );

				// Check if super fields exist. If not, return generic error message.
				if ( ! isset( $fields['awsm_applicant_name'] ) || ! isset( $fields['awsm_applicant_email'] ) ) {
					$awsm_response['error'][] = $generic_err_msg;
				}

				if ( count( $awsm_response['error'] ) === 0 ) {
					$applicant_name   = $fields['awsm_applicant_name']['value'];
					$post_base_data   = array(
						'post_title'     => $applicant_name,
						'post_content'   => '',
						'post_status'    => 'publish',
						'comment_status' => 'closed',
					);
					$application_data = array_merge(
						$post_base_data,
						array(
							'post_type'   => 'awsm_job_application',
							'post_parent' => $job_id,
						)
					);
					$application_id   = wp_insert_post( $application_data );

					if ( ! empty( $application_id ) && ! is_wp_error( $application_id ) ) {
						foreach ( $fields as $field_name => $field ) {
							if ( $field['type'] === 'resume' || $field['type'] === 'photo' || $field['type'] === 'file' ) {
								if ( ! empty( $field['value'] ) && isset( $field['value']['file'] ) ) {
									$attachment_data = array_merge(
										$post_base_data,
										array(
											'post_mime_type' => $field['value']['type'],
											'guid' => $field['value']['url'],
										)
									);
									$attach_id       = wp_insert_attachment( $attachment_data, $field['value']['file'], $application_id );

									if ( ! empty( $attach_id ) && ! is_wp_error( $attach_id ) ) {
											$attach_data = wp_generate_attachment_metadata( $attach_id, $field['value']['file'] );
											wp_update_attachment_metadata( $attach_id, $attach_data );
											$fields[ $field_name ]['value'] = $attach_id;
									} else {
										$awsm_response['error'][] = $generic_err_msg;
										break;
									}
								}
							}
						}

						if ( count( $awsm_response['error'] ) === 0 ) {
							$custom_fields     = array();
							$applicant_details = array(
								'awsm_job_id'       => $job_id,
								'awsm_apply_for'    => esc_html( get_the_title( $job_id ) ),
								'awsm_applicant_ip' => isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( $_SERVER['REMOTE_ADDR'] ) : '',
							);

							if ( ! empty( $agree_privacy_policy ) ) {
								$applicant_details['awsm_agree_privacy_policy'] = $agree_privacy_policy;
							}

							foreach ( $fields as $field_name => $field ) {
								if ( $field['type'] === 'resume' ) {
									$applicant_details['awsm_attachment_id'] = $field['value'];
								} else {
									if ( $field['spec'] === 'default' ) {
										$applicant_details[ $field_name ] = $field['value'];
									} else {
										$custom_fields[ $field_name ] = array(
											'label' => $field['label'],
											'type'  => $field['type'],
											'value' => $field['value'],
										);
									}
								}
							}

							foreach ( $applicant_details as $meta_key => $meta_value ) {
								update_post_meta( $application_id, $meta_key, $meta_value );
							}

							if ( ! empty( $custom_fields ) ) {
								update_post_meta( $application_id, 'awsm_applicant_custom_fields', $custom_fields );
								$applicant_details['custom_fields'] = $custom_fields;
							}

							// Now, send notification email
							$applicant_details['application_id'] = $application_id;
							$this->notification_email( $applicant_details );

							$awsm_response['success'][] = esc_html__( 'Your application has been submitted.', 'wp-job-openings' );

							do_action( 'awsm_job_application_submitted', $application_id );

						}
					} else {
						$awsm_response['error'][] = $generic_err_msg;
					}
				}
				add_action( 'awsm_application_form_notices', array( $this, 'awsm_form_submit_notices' ) );
			}
			// phpcs:enable
			return $awsm_response;
		}

		public function ajax_handle() {
			$response = $this->insert_application();
			wp_send_json( $response );
		}

		public function pro_mail_template_tags( $tags, $applicant_details ) {
			$custom_fields = isset( $applicant_details['custom_fields'] ) && is_array( $applicant_details['custom_fields'] ) ? $applicant_details['custom_fields'] : array();
			$fb_options    = get_option( 'awsm_jobs_form_builder' );
			foreach ( $fb_options as $fb_option ) {
				$field_type = $fb_option['field_type'];
				if ( $fb_option['default_field'] !== true && $field_type !== 'photo' && $field_type !== 'file' && $field_type !== 'resume' ) {
					$field_name = $fb_option['name'];
					if ( isset( $custom_fields[ $field_name ] ) ) {
						$template_tag = isset( $fb_option['misc_options'] ) && isset( $fb_option['misc_options']['template_tag'] ) ? $fb_option['misc_options']['template_tag'] : '';
						if ( ! empty( $template_tag ) ) {
							$key          = sprintf( '{%s}', $template_tag );
							$tags[ $key ] = $custom_fields[ $field_name ]['value'];
						}
					}
				}
			}
			return $tags;
		}

		public function admin_notification_mail_attachments( $attachments, $applicant_details ) {
			$attachment_ids = array();
			$fb_options     = get_option( 'awsm_jobs_form_builder' );
			$custom_fields  = isset( $applicant_details['custom_fields'] ) && is_array( $applicant_details['custom_fields'] ) ? $applicant_details['custom_fields'] : array();

			if ( is_array( $fb_options ) ) {
				foreach ( $fb_options as $fb_option ) {
					if ( $fb_option['field_type'] === 'resume' || $fb_option['field_type'] === 'photo' || $fb_option['field_type'] === 'file' ) {
						if ( isset( $fb_option['misc_options'] ) && isset( $fb_option['misc_options']['mail_attachment'] ) && $fb_option['misc_options']['mail_attachment'] === 'attach' ) {
							$field_name = $fb_option['name'];
							if ( $field_name === 'awsm_file' ) {
								if ( isset( $applicant_details['awsm_attachment_id'] ) && $applicant_details['awsm_attachment_id'] ) {
									$attachment_ids[] = array(
										'id'   => $applicant_details['awsm_attachment_id'],
										'type' => 'resume',
									);
								}
							} else {
								if ( array_key_exists( $field_name, $custom_fields ) ) {
									$custom_attachment_ids = array(
										'id'   => $custom_fields[ $field_name ]['value'],
										'type' => $custom_fields[ $field_name ]['type'],
									);
									if ( $fb_option['field_type'] === 'file' ) {
										$custom_attachment_ids['label'] = $fb_option['label'];
									}
									$attachment_ids[] = $custom_attachment_ids;
								}
							}
						}
					}
				}
			}

			if ( ! empty( $attachment_ids ) ) {
				foreach ( $attachment_ids as $attachment_id ) {
					$attachment_file = get_attached_file( $attachment_id['id'] );
					if ( file_exists( $attachment_file ) ) {
						$path_info     = pathinfo( $attachment_file );
						$new_file_name = $applicant_details['application_id'];
						if ( isset( $attachment_id['label'] ) ) {
							$new_file_name .= '-' . sanitize_title( $applicant_details['awsm_applicant_name'] . ' ' . $attachment_id['label'] );
						} else {
							$new_file_name .= '-' . sanitize_title( $applicant_details['awsm_applicant_name'] ) . '-' . $attachment_id['type'];
						}
						$new_file = $path_info['dirname'] . '/' . $new_file_name . '.' . $path_info['extension'];
						if ( copy( $attachment_file, $new_file ) ) {
							$attachments[] = array(
								'file' => $new_file,
								'temp' => true,
							);
						}
					}
				}
			}
			return $attachments;
		}

		public function job_forward_notification_email( $admin_headers, $applicant_details ) {
			$admin_cc     = get_option( 'awsm_jobs_admin_hr_notification' );
			$cc_addresses = get_post_meta( $applicant_details['awsm_job_id'], 'awsm_job_cc_email_addresses', true );
			if ( ! empty( $cc_addresses ) ) {
				$admin_headers['cc'] = ! empty( $admin_cc ) ? $admin_headers['cc'] . ',' . $cc_addresses : 'Cc: ' . $cc_addresses;
			}
			return $admin_headers;
		}
	}

	AWSM_Job_Openings_Pro_Form::init();

endif; // end of class check
