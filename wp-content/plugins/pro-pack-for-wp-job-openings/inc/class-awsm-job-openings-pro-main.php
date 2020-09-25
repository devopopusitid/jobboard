<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AWSM_Job_Openings_Pro_Main {
	private static $instance = null;

	public function __construct() {
		$this->cpath = untrailingslashit( plugin_dir_path( __FILE__ ) );
		add_action( 'init', array( $this, 'register_application_status' ) );
		add_action( 'wp_loaded', array( $this, 'remove_hooks' ) );
		add_action( 'save_post', array( $this, 'save_awsm_jobs_posts' ), 100, 2 );
		add_filter( 'manage_awsm_job_application_posts_columns', array( $this, 'manage_job_application_posts_columns' ) );
		add_filter( 'manage_awsm_job_application_posts_custom_column', array( $this, 'manage_job_application_posts_custom_column' ), 10, 2 );
		add_filter( 'views_edit-awsm_job_application', array( $this, 'awsm_job_application_edit_views' ), 100 );
		add_filter( 'awsm_applicant_photo', array( $this, 'applicant_photo' ) );
	}

	public static function init() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function remove_hooks() {
		remove_filter( 'views_edit-awsm_job_application', array( AWSM_Job_Openings::init(), 'awsm_job_application_action_links' ) );
	}

	public function manage_job_application_posts_columns( $columns ) {
		$columns['awsm-application-status'] = esc_attr__( 'Status', 'pro-pack-for-wp-job-openings' );
		$columns['awsm-application-rating'] = esc_attr__( 'Rating', 'pro-pack-for-wp-job-openings' );
		return $columns;
	}

	public static function get_application_status() {
		return array(
			'publish'   => array(
				'default'     => true,
				'label'       => _x( 'New', 'post status', 'pro-pack-for-wp-job-openings' ),
				/* translators: %s: posts count with publish status */
				'label_count' => _n_noop( 'New <span class="count">(%s)</span>', 'New <span class="count">(%s)</span>', 'pro-pack-for-wp-job-openings' ),
			),
			'trash'     => array(
				'default'     => true,
				'label'       => _x( 'Trashed', 'post status', 'pro-pack-for-wp-job-openings' ),
				/* translators: %s: posts count with trash status */
				'label_count' => _n_noop( 'Trash <span class="count">(%s)</span>', 'Trash <span class="count">(%s)</span>', 'default' ),
			),
			'progress'  => array(
				'label'       => _x( 'In Progress', 'post status', 'pro-pack-for-wp-job-openings' ),
				/* translators: %s: posts count with progress status */
				'label_count' => _n_noop( 'In Progress <span class="count">(%s)</span>', 'In Progress <span class="count">(%s)</span>', 'pro-pack-for-wp-job-openings' ),
			),
			'shortlist' => array(
				'label'       => _x( 'Shortlisted', 'post status', 'pro-pack-for-wp-job-openings' ),
				/* translators: %s: posts count with shortlisted status */
				'label_count' => _n_noop( 'Shortlisted <span class="count">(%s)</span>', 'Shortlisted <span class="count">(%s)</span>', 'pro-pack-for-wp-job-openings' ),
			),
			'reject'    => array(
				'label'       => _x( 'Rejected', 'post status', 'pro-pack-for-wp-job-openings' ),
				/* translators: %s: posts count with rejected status */
				'label_count' => _n_noop( 'Rejected <span class="count">(%s)</span>', 'Rejected <span class="count">(%s)</span>', 'pro-pack-for-wp-job-openings' ),
			),
			'select'    => array(
				'label'       => _x( 'Selected', 'post status', 'pro-pack-for-wp-job-openings' ),
				/* translators: %s: posts count with selected status */
				'label_count' => _n_noop( 'Selected <span class="count">(%s)</span>', 'Selected <span class="count">(%s)</span>', 'pro-pack-for-wp-job-openings' ),
			),
		);
	}

	public function manage_job_application_posts_custom_column( $columns, $post_id ) {
		switch ( $columns ) {
			case 'awsm-application-status':
				$post_status      = get_post_status( $post_id );
				$available_status = self::get_application_status();
				$label            = isset( $available_status[ $post_status ] ) ? $available_status[ $post_status ]['label'] : $available_status['publish']['label'];
				$class_name       = "awsm-application-{$post_status}-status";
				printf( '<span class="%2$s">%1$s</span>', esc_html( $label ), esc_attr( $class_name ) );
				break;

			case 'awsm-application-rating':
				$rating = get_post_meta( $post_id, 'awsm_application_rating', true );
				$rating = ! empty( $rating ) ? $rating : 0;
				wp_star_rating(
					array(
						'rating' => (int) $rating,
						'type'   => 'rating',
					)
				);
		}
	}

	public function register_application_status() {
		$status = self::get_application_status();
		foreach ( $status as $name => $args ) {
			$default = isset( $args['default'] ) ? $args['default'] : false;
			if ( $default === false ) {
				register_post_status(
					$name,
					array(
						'label'                     => $args['label'],
						'public'                    => true,
						'exclude_from_search'       => false,
						'show_in_admin_all_list'    => true,
						'show_in_admin_status_list' => true,
						'label_count'               => $args['label_count'],
					)
				);
			}
		}
	}

	public function awsm_job_application_edit_views( $views ) {
		$remove_views = [ 'mine', 'future', 'sticky', 'draft', 'pending' ];
		foreach ( $remove_views as $view ) {
			if ( isset( $views[ $view ] ) ) {
				unset( $views[ $view ] );
			}
		}
		if ( isset( $views['publish'] ) ) {
			$views['publish'] = str_replace( esc_html__( 'Published', 'default' ), esc_html_x( 'New', 'post status', 'pro-pack-for-wp-job-openings' ), $views['publish'] );
		}
		return $views;
	}

	public function save_awsm_jobs_posts( $post_id, $post ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! isset( $_POST['awsm_jobs_posts_nonce'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_POST['awsm_jobs_posts_nonce'], 'awsm_save_post_meta' ) ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( $post->post_type === 'awsm_job_openings' ) {
			$cc_addresses = isset( $_POST['awsm_cc_email_notification'] ) ? sanitize_text_field( $_POST['awsm_cc_email_notification'] ) : '';
			update_post_meta( $post_id, 'awsm_job_cc_email_addresses', $cc_addresses );
		}

		if ( $post->post_type === 'awsm_job_application' ) {
			$user_id      = get_current_user_id();
			$current_time = current_time( 'timestamp' );

			if ( isset( $_POST['awsm_application_rating'] ) ) {
				$rating = intval( $_POST['awsm_application_rating'] );
				if ( $rating ) {
					$updated = update_post_meta( $post_id, 'awsm_application_rating', $rating );
					if ( $updated ) {
						$activities   = get_post_meta( $post_id, 'awsm_application_activity_log', true );
						$activities   = ! empty( $activities ) && is_array( $activities ) ? $activities : array();
						$activities[] = array(
							'user'          => $user_id,
							'activity_date' => $current_time,
							'rating'        => $rating,
						);
						update_post_meta( $post_id, 'awsm_application_activity_log', $activities );
					}
				}
			}

			if ( isset( $_POST['awsm_application_notes'] ) && ! empty( $_POST['awsm_application_notes'] ) ) {
				$notes   = get_post_meta( $post_id, 'awsm_application_notes', true );
				$notes   = ! empty( $notes ) && is_array( $notes ) ? $notes : array();
				$notes[] = array(
					'author_id'     => $user_id,
					'notes_date'    => $current_time,
					'notes_content' => sanitize_text_field( $_POST['awsm_application_notes'] ),
				);
				update_post_meta( $post_id, 'awsm_application_notes', $notes );
			}

			$status = get_post_status( $post_id );
			if ( $status === 'progress' || $status === 'shortlist' || $status === 'reject' || $status === 'select' ) {
				$activities        = get_post_meta( $post_id, 'awsm_application_activity_log', true );
				$activities        = ! empty( $activities ) && is_array( $activities ) ? $activities : array();
				$is_status_changed = true;
				$status_activity   = array();
				foreach ( $activities as $activity ) {
					if ( isset( $activity['status'] ) ) {
						$status_activity[] = $activity['status'];
					}
				}
				if ( ! empty( $status_activity ) ) {
					$last_status = end( $status_activity );
					if ( $status === $last_status ) {
						$is_status_changed = false;
					}
				}
				if ( $is_status_changed ) {
					$activities[] = array(
						'user'          => $user_id,
						'activity_date' => $current_time,
						'status'        => $status,
					);
					update_post_meta( $post_id, 'awsm_application_activity_log', $activities );
				}
			}
		}
	}

	public function applicant_photo( $avatar ) {
		global $post;
		if ( isset( $post ) ) {
			$custom_fields = get_post_meta( $post->ID, 'awsm_applicant_custom_fields', true );
			$photo_id      = isset( $custom_fields['awsm_applicant_photo'] ) ? $custom_fields['awsm_applicant_photo']['value'] : '';
			if ( ! empty( $photo_id ) ) {
				$photo_url = wp_get_attachment_url( $photo_id );
				if ( ! empty( $photo_url ) ) {
					$attrs_content = 'class="avatar photo avatar-%1$s" width="%1$s" height="%1$s"';
					$attrs         = sprintf( $attrs_content, 32 );
					$screen        = get_current_screen();
					if ( ! empty( $screen ) ) {
						if ( $screen->base === 'post' ) {
							$attrs = sprintf( $attrs_content, 130 );
						}
					}
					$avatar = sprintf( '<img src="%s" %s />', $photo_url, $attrs );
				}
			}
		}
		return $avatar;
	}
}

AWSM_Job_Openings_Pro_Main::init();
