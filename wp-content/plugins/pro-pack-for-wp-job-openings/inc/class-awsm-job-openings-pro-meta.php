<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AWSM_Job_Openings_Pro_Meta {
	private static $instance = null;

	public function __construct() {
		$this->cpath = untrailingslashit( plugin_dir_path( __FILE__ ) );
		add_action( 'add_meta_boxes', array( $this, 'register_meta_boxes' ) );
		add_filter( 'awsm_jobs_applicant_meta', array( $this, 'applicant_meta' ), 10, 2 );
		add_action( 'wp_ajax_awsm_applicant_mail', array( $this, 'ajax_mail_handle' ) );
		add_action( 'wp_ajax_awsm_job_et_data', array( $this, 'ajax_mail_templates_handle' ) );
		add_action( 'wp_ajax_awsm_job_pro_notes', array( $this, 'ajax_notes_handle' ) );
		add_action( 'wp_ajax_awsm_job_pro_remove_note', array( $this, 'ajax_remove_note_handle' ) );
	}

	public static function init() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function register_meta_boxes() {
		// Job openings related meta boxes.
		add_meta_box( 'awsm-job-cc-email-meta', esc_html__( 'CC Email Notifications', 'pro-pack-for-wp-job-openings' ), array( $this, 'email_notification_meta_handler' ), 'awsm_job_openings', 'side', 'low' );

		// Job application related meta boxes.
		add_meta_box( 'awsm-application-actions-meta', esc_html__( 'Actions', 'pro-pack-for-wp-job-openings' ), array( $this, 'application_actions_meta_handler' ), 'awsm_job_application', 'side', 'high' );
		add_meta_box( 'awsm-application-notes-meta', esc_html__( 'Notes', 'pro-pack-for-wp-job-openings' ), array( $this, 'application_notes_handler' ), 'awsm_job_application', 'side', 'low' );
		add_meta_box( 'awsm-application-activity-log-meta', esc_html__( 'Activity Log', 'pro-pack-for-wp-job-openings' ), array( $this, 'activity_log_handler' ), 'awsm_job_application', 'side', 'low' );
		add_meta_box( 'awsm-application-mail-meta', esc_html__( 'Emails', 'pro-pack-for-wp-job-openings' ), array( $this, 'awsm_job_application_email_handler' ), 'awsm_job_application', 'normal', 'low' );
	}

	public function email_notification_meta_handler( $post ) {
		include $this->cpath . '/templates/meta/forward-mail.php';
	}

	public function application_actions_meta_handler( $post ) {
		include $this->cpath . '/templates/meta/application-actions.php';
	}

	public function activity_log_handler( $post ) {
		include $this->cpath . '/templates/meta/activity-log.php';
	}

	public function application_notes_handler( $post ) {
		include $this->cpath . '/templates/meta/application-notes.php';
	}

	public function awsm_job_application_email_handler( $post ) {
		include $this->cpath . '/templates/meta/application-email.php';
	}

	public function applicant_meta( $meta_details, $post_id ) {
		$fb_options = get_option( 'awsm_jobs_form_builder' );
		// handle default fields
		if ( ! empty( $fb_options ) ) {
			foreach ( $fb_options as $fb_option ) {
				if ( $fb_option['default_field'] === true && $fb_option['field_type'] !== 'resume' ) {
					$meta_name = $fb_option['name'];
					if ( ! empty( $fb_option['label'] ) ) {
						$meta_details[ $meta_name ]['label'] = $fb_option['label'];
					}
				}
			}
		}
		// handle custom fields
		$custom_fields = get_post_meta( $post_id, 'awsm_applicant_custom_fields', true );
		if ( ! empty( $custom_fields ) ) {
			foreach ( $custom_fields as $key => $custom_field ) {
				if ( $custom_field['type'] !== 'photo' ) {
					$meta_details[ $key ] = array(
						'label' => $custom_field['label'],
						'value' => $custom_field['value'],
					);
					if ( $custom_field['type'] === 'textarea' ) {
						$meta_details[ $key ]['multi-line'] = true;
					}
					if ( $custom_field['type'] === 'file' || $custom_field['type'] === 'url' ) {
						$meta_details[ $key ]['type'] = $custom_field['type'];
					}
				}
			}
		}
		// now order these fields
		if ( ! empty( $fb_options ) ) {
			$ordered_details = array();
			foreach ( $fb_options as $fb_option ) {
				$key = $fb_option['name'];
				if ( isset( $meta_details[ $key ] ) ) {
					$ordered_details[ $key ] = $meta_details[ $key ];
				}
			}
			$meta_details = array_merge( $ordered_details, $meta_details );
		}
		return $meta_details;
	}

	public function get_job_application_error( $application_id ) {
		$error = array();
		if ( get_post_type( $application_id ) !== 'awsm_job_application' ) {
			$response['error'][] = esc_html__( 'Invalid Job Application ID', 'pro-pack-for-wp-job-openings' );
		}
		if ( ! current_user_can( 'edit_post', $application_id ) ) {
			$response['error'][] = esc_html__( 'You do not have sufficient permissions to edit job applications!', 'pro-pack-for-wp-job-openings' );
		}
		return $error;
	}

	public function get_view_activity() {
		$user_id = get_current_user_id();
		return array(
			'user'          => $user_id,
			'activity_date' => current_time( 'timestamp' ),
			'viewed'        => true,
		);
	}

	public function is_applicant_viewed( $activities ) {
		$current_user_id = get_current_user_id();
		$is_viewed       = false;
		foreach ( $activities as $activity ) {
			$user_id = intval( $activity['user'] );
			if ( $user_id && $user_id === $current_user_id && isset( $activity['viewed'] ) ) {
				$is_viewed = true;
				break;
			}
		}
		return $is_viewed;
	}

	public function get_username( $user_id, $user_data = null ) {
		$user_info = empty( $user_data ) ? get_userdata( $user_id ) : $user_data;
		$user      = $user_info->display_name;
		if ( empty( $user ) ) {
			$user = $user_info->user_login;
		}
		return $user;
	}

	public function get_applicant_meta_details( $application_id ) {
		$applicant_details = array();
		$meta_keys         = array( 'awsm_applicant_name', 'awsm_applicant_email', 'awsm_applicant_phone', 'awsm_applicant_letter', 'awsm_job_id', 'awsm_apply_for', 'awsm_attachment_id' );
		foreach ( $meta_keys as $meta_key ) {
			$applicant_details[ $meta_key ] = get_post_meta( $application_id, $meta_key, true );
		}
		$applicant_details['application_id'] = $application_id;
		return $applicant_details;
	}

	public function ajax_mail_templates_handle() {
		 $response         = array(
			 'subject' => '',
			 'content' => '',
			 'error'   => array(),
		 );
		$post_id           = intval( $_GET['awsm_application_id'] );
		$response['error'] = $this->get_job_application_error( $post_id );
		if ( count( $response['error'] ) === 0 && isset( $_GET['awsm_template_key'] ) ) {
			$template_key = sanitize_text_field( $_GET['awsm_template_key'] );
			$templates    = get_option( 'awsm_jobs_pro_mail_templates' );
			if ( ! empty( $templates ) ) {
				$tags = array();
				if ( class_exists( 'AWSM_Job_Openings_Form' ) ) {
					$form              = AWSM_Job_Openings_Form::init();
					$applicant_details = $this->get_applicant_meta_details( $post_id );
					$tags              = $form->get_mail_template_tags( $applicant_details );
				}
				$tag_names  = array_keys( $tags );
				$tag_values = array_values( $tags );
				foreach ( $templates as $template ) {
					if ( $template['key'] === $template_key ) {
						$response['subject'] = str_replace( $tag_names, $tag_values, $template['subject'] );
						$response['content'] = str_replace( $tag_names, $tag_values, $template['content'] );
					}
				}
			}
		}
		wp_send_json( $response );
	}

	public function ajax_mail_handle() {
		$response        = array(
			'content' => '',
			'success' => array(),
			'error'   => array(),
		);
		$generic_err_msg = esc_html__( 'Error sending mail!', 'pro-pack-for-wp-job-openings' );

		if ( ! wp_verify_nonce( $_POST['nonce'], 'awsm-pro-admin-nonce' ) ) {
			$response['error'][] = $generic_err_msg;
		}
		$post_id           = intval( $_POST['awsm_application_id'] );
		$response['error'] = array_merge( $response['error'], $this->get_job_application_error( $post_id ) );

		$cc           = sanitize_text_field( $_POST['awsm_mail_meta_applicant_cc'] );
		$subject      = sanitize_text_field( $_POST['awsm_mail_meta_applicant_subject'] );
		$mail_content = awsm_jobs_sanitize_textarea( $_POST['awsm_mail_meta_applicant_content'] );
		if ( empty( $subject ) || empty( $mail_content ) ) {
			$response['error'][] = esc_html__( 'Subject and mail content required!', 'pro-pack-for-wp-job-openings' );
		}

		if ( count( $response['error'] ) === 0 ) {
			$user_id      = get_current_user_id();
			$current_time = current_time( 'timestamp' );
			$mails_meta   = get_post_meta( $post_id, 'awsm_application_mails', true );
			$mails        = ! empty( $mails_meta ) && is_array( $mails_meta ) ? $mails_meta : array();
			$mail_data    = array(
				'send_by'      => $user_id,
				'mail_date'    => $current_time,
				'cc'           => $cc,
				'subject'      => $subject,
				'mail_content' => $mail_content,
			);
			$mails[]      = $mail_data;
			$is_sent      = $this->applicant_notification( $post_id, $mail_data );
			if ( $is_sent ) {
				$updated = update_post_meta( $post_id, 'awsm_application_mails', $mails );
				if ( $updated ) {
					// update activity log.
					$activities   = get_post_meta( $post_id, 'awsm_application_activity_log', true );
					$activities   = ! empty( $activities ) && is_array( $activities ) ? $activities : array();
					$activities[] = array(
						'user'          => $user_id,
						'activity_date' => $current_time,
						'mail'          => true,
					);
					update_post_meta( $post_id, 'awsm_application_activity_log', $activities );

					// send the response.
					$response['success'][] = esc_html__( 'Your message has been successfully sent to the applicant.', 'pro-pack-for-wp-job-openings' );
					$response['content']   = array(
						'author'    => $this->get_username( $mail_data['send_by'] ),
						'date_i18n' => esc_html( date_i18n( __( 'M j, Y @ H:i', 'default' ), $mail_data['mail_date'] ) ),
						'subject'   => $mail_data['subject'],
						'content'   => wpautop( $mail_data['mail_content'] ),
					);
				} else {
					$response['error'][] = $generic_err_msg;
				}
			} else {
				$response['error'][] = $generic_err_msg;
			}
		}
		wp_send_json( $response );
	}

	public function applicant_notification( $post_id, $mail_data ) {
		$admin_email  = get_option( 'admin_email' );
		$from_email   = get_option( 'awsm_jobs_from_email_notification', $admin_email );
		$company_name = get_option( 'awsm_job_company_name', '' );
		$from         = ! empty( $company_name ) ? $company_name : get_option( 'blogname' );
		$user_info    = get_userdata( $mail_data['send_by'] );
		$to           = get_post_meta( $post_id, 'awsm_applicant_email', true );
		$cc           = $mail_data['cc'];
		$subject      = $mail_data['subject'];
		$message      = nl2br( $mail_data['mail_content'] );

		// Additional headers.
		$headers   = array();
		$headers[] = 'Content-Type: text/html; charset=UTF-8';
		$headers[] = apply_filters( 'awsm_jobs_pro_applicant_notification_mail_from', sprintf( 'From: %1$s <%2$s>', $from, $from_email ), $from );
		$headers[] = apply_filters( 'awsm_jobs_pro_applicant_notification_mail_reply_to', sprintf( 'Reply-To: %1$s <%2$s>', $this->get_username( $mail_data['send_by'], $user_info ), $user_info->user_email ), $mail_data['send_by'] );
		if ( ! empty( $cc ) ) {
			$headers[] = 'Cc: ' . $cc;
		}

		$is_sent = wp_mail( $to, $subject, $message, $headers );
		return $is_sent;
	}

	public function ajax_notes_handle() {
		$response        = array(
			'update'     => false,
			'notes_data' => '',
			'error'      => array(),
		);
		$generic_err_msg = esc_html__( 'Error in submitting notes!', 'pro-pack-for-wp-job-openings' );
		if ( ! wp_verify_nonce( $_POST['nonce'], 'awsm-pro-admin-nonce' ) ) {
			$response['error'][] = $generic_err_msg;
		}
		$post_id           = intval( $_POST['awsm_application_id'] );
		$response['error'] = array_merge( $response['error'], $this->get_job_application_error( $post_id ) );
		$notes_content     = isset( $_POST['awsm_application_notes'] ) ? sanitize_text_field( $_POST['awsm_application_notes'] ) : '';
		if ( ! empty( $notes_content ) ) {
			$user_id    = get_current_user_id();
			$notes_time = current_time( 'timestamp' );
			$notes      = get_post_meta( $post_id, 'awsm_application_notes', true );
			$notes      = ( ! empty( $notes ) && is_array( $notes ) ) ? $notes : array();
			$notes_data = array(
				'author_id'     => $user_id,
				'notes_date'    => $notes_time,
				'notes_content' => $notes_content,
			);
			$notes[]    = $notes_data;

			$updated = update_post_meta( $post_id, 'awsm_application_notes', $notes );
			if ( $updated ) {
				$response['update']     = true;
				$keys                   = array_keys( $notes );
				$index                  = max( $keys );
				$author_name            = $this->get_username( $user_id );
				$data                   = array(
					'index'     => $index,
					'username'  => $author_name,
					'time'      => $notes_time,
					'date_i18n' => esc_html( date_i18n( __( 'M j, Y @ H:i', 'default' ), $notes_time ) ),
				);
				$response['notes_data'] = $data;
			} else {
				$response['error'][] = $generic_err_msg;
			}
		} else {
			$response['error'][] = $generic_err_msg;
		}
		wp_send_json( $response );
	}

	public function ajax_remove_note_handle() {
		$response        = array(
			'delete' => false,
			'error'  => array(),
		);
		$generic_err_msg = esc_html__( 'Error in deleting notes!', 'pro-pack-for-wp-job-openings' );
		if ( ! wp_verify_nonce( $_POST['nonce'], 'awsm-pro-admin-nonce' ) ) {
			$response['error'][] = $generic_err_msg;
		}
		$post_id           = intval( $_POST['awsm_application_id'] );
		$response['error'] = array_merge( $response['error'], $this->get_job_application_error( $post_id ) );
		if ( isset( $_POST['awsm_note_key'] ) && isset( $_POST['awsm_note_time'] ) ) {
			$key = $_POST['awsm_note_key'];
			if ( ! is_numeric( $key ) ) {
				$response['error'][] = esc_html__( 'Invalid key supplied!', 'pro-pack-for-wp-job-openings' );
			} else {
				$key = intval( $key );
			}
			$supplied_time = intval( $_POST['awsm_note_time'] );
			if ( ! $supplied_time ) {
				$response['error'][] = esc_html__( 'Invalid timestamp supplied!', 'pro-pack-for-wp-job-openings' );
			}
			$notes = get_post_meta( $post_id, 'awsm_application_notes', true );
			if ( empty( $notes ) || ! is_array( $notes ) ) {
				$response['error'][] = esc_html__( 'No notes to delete!', 'pro-pack-for-wp-job-openings' );
			}
			if ( count( $response['error'] ) === 0 ) {
				$time = intval( $notes[ $key ]['notes_date'] );
				if ( $time === $supplied_time ) {
					array_splice( $notes, $key, 1 );
					$updated = update_post_meta( $post_id, 'awsm_application_notes', $notes );
					if ( $updated ) {
						$response['key']    = $key;
						$response['delete'] = true;
					} else {
						$response['error'][] = $generic_err_msg;
					}
				} else {
					$response['error'][] = $generic_err_msg;
				}
			}
		}
		wp_send_json( $response );
	}

	public function applicant_mail_template( $data = array() ) {
		$template_data = wp_parse_args(
			$data,
			array(
				'author'    => '{{data.author}}',
				'date_i18n' => '{{data.date_i18n}}',
				'subject'   => '{{data.subject}}',
				'content'   => '{{{data.content}}}',
			)
		);
		?>
		<div class="awsm-jobs-applicant-mail">
			<div class="awsm-jobs-applicant-mail-header">
				<h3><?php echo esc_html( $template_data['subject'] ); ?></h3>
				<p class="awsm-jobs-applicant-mail-meta">
					<span><?php echo esc_html( $template_data['author'] ); ?></span>
					<span><?php echo esc_html( $template_data['date_i18n'] ); ?></span>
				</p>
			</div>
			<div class="awsm-jobs-applicant-mail-content">
				<?php
					echo wp_kses(
						$template_data['content'],
						array(
							'p'  => array(),
							'br' => array(),
						)
					);
				?>
			</div>
		</div>
		<?php
	}

	public function notes_template( $data = array() ) {
		$template_data = wp_parse_args(
			$data,
			array(
				'index'     => '{{data.index}}',
				'time'      => '{{data.time}}',
				'date_i18n' => '{{data.date_i18n}}',
				'author'    => '{{data.author}}',
				'content'   => '{{data.content}}',
			)
		);
		?>
		<li class="awsm-jobs-note" data-index="<?php echo esc_attr( $template_data['index'] ); ?>" data-time="<?php echo esc_attr( $template_data['time'] ); ?>">
			<div class="awsm-jobs-note-content-wrapper">
				<span class="awsm-jobs-note-content">
					<?php echo esc_html( $template_data['content'] ); ?>
				</span>

				<span class="awsm-jobs-note-remove">
					<button type="button" class="awsm-jobs-note-remove-btn ntdelbutton">
						<span class="remove-tag-icon" aria-hidden="true"></span>
						<span class="screen-reader-text"><?php esc_html_e( 'Remove Note', 'pro-pack-for-wp-job-openings' ); ?></span>
					</button>
				</span>
			</div>
			<div class="awsm-jobs-note-details">
				<p class="description"><span><?php echo esc_html( $template_data['author'] ); ?></span>, <span><?php echo esc_html( $template_data['date_i18n'] ); ?></span></p>
			</div>
		</li>
		<?php
	}
}

AWSM_Job_Openings_Pro_Meta::init();
