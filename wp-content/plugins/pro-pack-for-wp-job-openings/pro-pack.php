<?php
/**
 * Plugin Name: Pro Pack for WP Job Openings
 * Description: Converts WP Job Openings to a powerful recruitment tool by adding some of the most sought features.
 * Author: AWSM Innovations
 * Author URI: https://awsm.in/
 * Version: 1.3.1
 * Licence: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text domain: pro-pack-for-wp-job-openings
 * Domain Path: /languages
 */

/**
 * Pro Pack for WP Job Openings
 *
 * Converts WP Job Openings to a powerful recruitment tool by adding some of the most sought features.
 *
 * @package wp-job-openings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Plugin Constants
if ( ! defined( 'AWSM_JOBS_MAIN_PLUGIN' ) ) {
	define( 'AWSM_JOBS_MAIN_PLUGIN', 'wp-job-openings/wp-job-openings.php' );
}
if ( ! defined( 'AWSM_JOBS_PRO_PLUGIN_BASENAME' ) ) {
	define( 'AWSM_JOBS_PRO_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
}
if ( ! defined( 'AWSM_JOBS_PRO_PLUGIN_DIR' ) ) {
	define( 'AWSM_JOBS_PRO_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
}
if ( ! defined( 'AWSM_JOBS_PRO_PLUGIN_URL' ) ) {
	define( 'AWSM_JOBS_PRO_PLUGIN_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
}
if ( ! defined( 'AWSM_JOBS_PRO_PLUGIN_VERSION' ) ) {
	define( 'AWSM_JOBS_PRO_PLUGIN_VERSION', '1.3.1' );
}
if ( ! defined( 'AWSM_JOBS_MAIN_REQ_VERSION' ) ) {
	define( 'AWSM_JOBS_MAIN_REQ_VERSION', '1.3' );
}
if ( ! defined( 'AWSM_JOBS_MAIN_REC_VERSION' ) ) {
	define( 'AWSM_JOBS_MAIN_REC_VERSION', '1.6.0' );
}

class AWSM_Job_Openings_Pro_Pack {
	private static $instance      = null;
	public static $kernl_base_url = 'https://kernl.us/api/v1';
	public static $uuid           = '5c49b2a0160ad03477ef2ec0';

	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_init', array( $this, 'handle_plugin_activation' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'admin_notices', array( $this, 'update_notice' ) );
		add_action( 'wp_ajax_awsm_job_pro_admin_notice', array( $this, 'admin_notice_ajax_handle' ) );
		add_action( 'after_plugin_row_' . AWSM_JOBS_PRO_PLUGIN_BASENAME, array( $this, 'after_plugin_row' ), 100 );
		add_action( 'init', array( $this, 'export_applications_handler' ) );
		add_action( 'restrict_manage_posts', array( $this, 'export_applications_form' ) );

		add_filter( 'puc_manual_check_link-pro-pack-for-wp-job-openings', '__return_false' );
		// handle automatic plugin update.
		$this->update_plugin();

		add_filter( 'awsm_job_query_args', array( $this, 'jobs_query_args' ), 10, 3 );
	}

	public static function init() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public static function load_classes() {
		require_once AWSM_JOBS_PRO_PLUGIN_DIR . '/inc/class-awsm-job-openings-pro-main.php';
		require_once AWSM_JOBS_PRO_PLUGIN_DIR . '/inc/class-awsm-job-openings-pro-form.php';

		// WPML support.
		if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
			require_once AWSM_JOBS_PRO_PLUGIN_DIR . '/inc/translation/class-awsm-job-openings-pro-wpml.php';
		}

		// Admin classes.
		if ( is_admin() ) {
			require_once AWSM_JOBS_PRO_PLUGIN_DIR . '/inc/class-awsm-job-openings-pro-meta.php';
			require_once AWSM_JOBS_PRO_PLUGIN_DIR . '/inc/class-awsm-job-openings-pro-settings.php';
		}
	}

	public function activate() {
		if ( defined( 'AWSM_JOBS_PLUGIN_DIR' ) ) {
			if ( ! class_exists( 'AWSM_Job_Openings_Settings' ) ) {
				require_once AWSM_JOBS_PLUGIN_DIR . '/admin/class-awsm-job-openings-settings.php';
			}
			if ( ! class_exists( 'AWSM_Job_Openings_Pro_Settings' ) ) {
				require_once AWSM_JOBS_PRO_PLUGIN_DIR . '/inc/class-awsm-job-openings-pro-settings.php';
			}
			AWSM_Job_Openings_Pro_Settings::register_pro_defaults();
		}
	}

	public function plugins_loaded() {
		// load classes
		if ( class_exists( 'AWSM_Job_Openings' ) ) {
			self::load_classes();
		}
		// load translated strings
		load_plugin_textdomain( 'pro-pack-for-wp-job-openings', false, basename( dirname( __FILE__ ) ) . '/languages' );
	}

	public function get_main_plugin_activation_link( $is_update = false ) {
		$content = $link_action = $action_url = $link_class = ''; // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments.Found

		if ( ! $is_update ) {
			// when plugin is not active.
			$link_action = esc_html__( 'Activate', 'pro-pack-for-wp-job-openings' );
			$action_url  = wp_nonce_url( self_admin_url( 'plugins.php?action=activate&plugin=' . AWSM_JOBS_MAIN_PLUGIN ), 'activate-plugin_' . AWSM_JOBS_MAIN_PLUGIN );
			$link_class  = ' activate-now';

			// when plugin is not installed.
			$plugin_arr       = explode( '/', esc_html( AWSM_JOBS_MAIN_PLUGIN ) );
			$plugin_slug      = $plugin_arr[0];
			$installed_plugin = get_plugins( '/' . $plugin_slug );
			if ( empty( $installed_plugin ) ) {
				if ( get_filesystem_method( array(), WP_PLUGIN_DIR ) === 'direct' ) {
					$link_action = esc_html__( 'Install', 'pro-pack-for-wp-job-openings' );
					$action_url  = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=' . $plugin_slug ), 'install-plugin_' . $plugin_slug );
					$link_class  = ' install-now';
				}
			}
		} else {
			// when plugin needs an update.
			$link_action = esc_html__( 'Update', 'pro-pack-for-wp-job-openings' );
			$action_url  = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' . AWSM_JOBS_MAIN_PLUGIN ), 'upgrade-plugin_' . AWSM_JOBS_MAIN_PLUGIN );
			$link_class  = ' update-now';
		}

		if ( ! empty( $link_action ) && ! empty( $action_url ) && ! empty( $link_class ) ) {
			$content = sprintf( '<a href="%2$s" class="button button-small%3$s">%1$s</a>', esc_html( $link_action ), esc_url( $action_url ), esc_attr( $link_class ) );
		}
		return $content;
	}

	public function admin_notices( $is_default = true, $req_plugin_version = AWSM_JOBS_MAIN_REQ_VERSION ) { ?>
		<div class="updated error">
				<p>
					<?php
						$req_plugin = sprintf( '<strong>"%s"</strong>', esc_html__( 'WP Job Openings', 'pro-pack-for-wp-job-openings' ) );
						$plugin     = sprintf( '<strong>"%s"</strong>', esc_html__( 'Pro Pack for WP Job Openings', 'pro-pack-for-wp-job-openings' ) );
					if ( $is_default ) {
						/* translators: %1$s: main plugin, %2$s: current plugin, %3$s: plugin activation link, %4$s: line break */
						printf( esc_html__( 'The plugin %2$s needs the plugin %1$s active. %4$s Please %3$s %1$s', 'pro-pack-for-wp-job-openings' ), $req_plugin, $plugin, $this->get_main_plugin_activation_link(), '<br />' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					} else {
						/* translators: %1$s: main plugin, %2$s: current plugin, %3$s: minimum required version of the main plugin, %4$s: plugin updation link */
						printf( esc_html__( '%2$s plugin requires %1$s version %3$s. Please %4$s %1$s plugin to the latest version.', 'pro-pack-for-wp-job-openings' ), $req_plugin, $plugin, esc_html( $req_plugin_version ), $this->get_main_plugin_activation_link( true ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					}
					?>
				</p>
			</div>
		<?php
	}

	public function handle_plugin_activation() {
		include_once ABSPATH . 'wp-admin/includes/plugin.php';
		if ( is_plugin_inactive( AWSM_JOBS_MAIN_PLUGIN ) || ! class_exists( 'AWSM_Job_Openings' ) ) {
			add_action(
				'admin_notices',
				function() {
					$this->admin_notices();
				}
			);
			deactivate_plugins( AWSM_JOBS_PRO_PLUGIN_BASENAME );
		}
		if ( defined( 'AWSM_JOBS_PLUGIN_VERSION' ) ) {
			if ( version_compare( AWSM_JOBS_PLUGIN_VERSION, AWSM_JOBS_MAIN_REQ_VERSION, '<' ) ) {
				add_action(
					'admin_notices',
					function() {
						$this->admin_notices( false );
					}
				);
				deactivate_plugins( AWSM_JOBS_PRO_PLUGIN_BASENAME );
			}
		}
	}

	public static function get_kernl_url( $endpoint_base = 'updates' ) {
		return esc_url( self::$kernl_base_url . '/' . $endpoint_base . '/' . self::$uuid . '/' );
	}

	public static function get_latest_version() {
		$version_data = array(
			'version' => AWSM_JOBS_PRO_PLUGIN_VERSION,
		);
		if ( get_transient( '_awsm_pro_latest_version_data' ) === false ) {
			$options  = array(
				'timeout' => 10,
				'headers' => array(
					'Accept' => 'application/json',
				),
			);
			$response = wp_remote_get( self::get_kernl_url( 'latest-version' ), $options );
			if ( ! is_wp_error( $response ) ) {
				$response_body = wp_remote_retrieve_body( $response );
				if ( ! is_wp_error( $response_body ) ) {
					if ( wp_remote_retrieve_response_code( $response ) === 200 ) {
						set_transient( '_awsm_pro_latest_version_data', $response_body, HOUR_IN_SECONDS );
					}
				}
			}
		}
		$json     = get_transient( '_awsm_pro_latest_version_data' );
		$api_data = json_decode( $json, true );
		if ( ! empty( $api_data ) && isset( $api_data['version'] ) ) {
			$version_data = $api_data;
		}
		return $version_data;
	}

	public function update_plugin() {
		$license_key = get_option( 'awsm_jobs_pro_license' );
		if ( ! empty( $license_key ) ) {
			require_once AWSM_JOBS_PRO_PLUGIN_DIR . '/lib/plugin-update-check.php';
			$pro_update_checker          = new AWSM_Job_Openings_Pro_Update_Checker(
				self::get_kernl_url(),
				__FILE__,
				'pro-pack-for-wp-job-openings',
				1
			);
			$pro_update_checker->license = $license_key;
		}
	}

	public static function get_automatic_update_notice() {
		$url = admin_url( 'edit.php?post_type=awsm_job_openings&page=awsm-jobs-settings&tab=license' );
		/* translators: %1$s: Opening anchor tag, %2$s: closing anchor tag */
		$notice = sprintf( esc_html__( 'Please %1$s activate your copy%2$s of Pro Pack for WP Job Openings to receive automatic updates.', 'pro-pack-for-wp-job-openings' ), sprintf( '<a href="%s">', esc_url( $url ) ), '</a>' );
		return $notice;
	}

	public function update_notice() {
		if ( current_user_can( 'install_plugins' ) ) {
			// show, automatic update notice.
			if ( ! get_option( 'awsm_jobs_pro_license' ) ) {
				wp_enqueue_style( 'awsm-job-pro-admin' );
				wp_enqueue_script( 'awsm-job-pro-admin' );
				$is_dismissed = get_user_meta( get_current_user_id(), 'awsm_jobs_pro_activate_notice', true );
				if ( ! $is_dismissed ) {
					$nonce = wp_create_nonce( 'awsm-pro-admin-notice' );
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					printf( '<div class="awsm-pro-activate-notice notice notice-error notice" data-nonce="%2$s"><p>%1$s</p><a href="#" class="notice-dismiss">%3$s</a></div>', self::get_automatic_update_notice(), esc_attr( $nonce ), esc_html__( 'Dismiss', 'pro-pack-for-wp-job-openings' ) );
				}
			}

			// show, update to recommended version notice.
			if ( defined( 'AWSM_JOBS_PLUGIN_VERSION' ) && version_compare( AWSM_JOBS_PLUGIN_VERSION, AWSM_JOBS_MAIN_REC_VERSION, '<' ) ) {
				$plugin_updates = get_site_transient( 'update_plugins' );
				if ( $plugin_updates && isset( $plugin_updates->response ) && isset( $plugin_updates->response[ AWSM_JOBS_MAIN_PLUGIN ] ) ) {
					$this->admin_notices( false, AWSM_JOBS_MAIN_REC_VERSION );
				}
			}
		}
	}

	public function admin_notice_ajax_handle() {
		$response    = array(
			'dismiss' => false,
			'error'   => array(),
		);
		$generic_msg = esc_html__( 'Error in dismissing the notice. Please try again!', 'pro-pack-for-wp-job-openings' );
		if ( isset( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'awsm-pro-admin-notice' ) ) {
			if ( current_user_can( 'install_plugins' ) ) {
				$response['dismiss'] = update_user_meta( get_current_user_id(), 'awsm_jobs_pro_activate_notice', true );
			} else {
				$response['error'][] = esc_html__( 'You don&#8217;t have the permission to dismiss this notice!', 'pro-pack-for-wp-job-openings' );
			}
		} else {
			$response['error'][] = $generic_msg;
		}
		wp_send_json( $response );
	}

	public function after_plugin_row() {
		$license_key = get_option( 'awsm_jobs_pro_license' );

		if ( ! $license_key ) :
			?>
			<tr class="plugin-update-tr">
				<td colspan="3" class="plugin-update colspanchange">
					<div class="update-message notice inline notice-warning notice-alt">
						<?php
							$html         = self::get_automatic_update_notice();
							$version_data = self::get_latest_version();
						if ( version_compare( AWSM_JOBS_PRO_PLUGIN_VERSION, $version_data['version'], '<' ) ) {
							$plugin = esc_html__( 'Pro Pack for WP Job Openings', 'pro-pack-for-wp-job-openings' );
							/* translators: %1$s: plugin latest version, %2$s: plugin name, %3$s: html content */
							$html = sprintf( esc_html__( 'There is a new version %1$s of %2$s available. %3$s', 'pro-pack-for-wp-job-openings' ), esc_html( $version_data['version'] ), $plugin, $html );
						}
							printf( '<p>%s</p>', $html ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>
					</div>
				</td>
			</tr>
			<?php
		endif;
	}

	public function enqueue_scripts() {
		wp_enqueue_style( 'awsm-job-pro-style', AWSM_JOBS_PRO_PLUGIN_URL . '/assets/css/style.min.css', array( 'awsm-jobs-style' ), AWSM_JOBS_PRO_PLUGIN_VERSION, 'all' );
	}

	public function admin_enqueue_scripts() {
		$screen = get_current_screen();
		wp_register_style( 'awsm-job-pro-admin', AWSM_JOBS_PRO_PLUGIN_URL . '/assets/css/admin.min.css', array( 'awsm-job-admin' ), AWSM_JOBS_PRO_PLUGIN_VERSION, 'all' );

		wp_register_script( 'awsm-job-pro-admin', AWSM_JOBS_PRO_PLUGIN_URL . '/assets/js/admin.min.js', array( 'jquery', 'jquery-ui-sortable', 'awsm-job-admin', 'wp-util' ), AWSM_JOBS_PRO_PLUGIN_VERSION, true );

		if ( ! empty( $screen ) ) {
			$post_type = $screen->post_type;
			if ( ( $post_type === 'awsm_job_openings' ) || ( $post_type === 'awsm_job_application' ) ) {
				wp_enqueue_style( 'awsm-job-pro-admin' );
				wp_enqueue_script( 'awsm-job-pro-admin' );
			}
		}

		wp_localize_script(
			'awsm-job-pro-admin',
			'awsmProJobsAdmin',
			array(
				'nonce' => wp_create_nonce( 'awsm-pro-admin-nonce' ),
				'i18n'  => array(),
			)
		);
	}

	public function export_applications_form( $post_type ) {
		if ( current_user_can( 'edit_others_applications' ) && $post_type === 'awsm_job_application' ) :
			$query_vars   = array(
				'awsm_nonce'  => wp_create_nonce( 'awsm_export_nonce' ),
				'awsm_action' => 'export_applications',
			);
			$download_url = add_query_arg( $query_vars );
			?>
			<a href="<?php echo esc_url( $download_url ); ?>" class="button awsm-export-applications-btn button-primary" style="display:none;" rel="nofollow"><strong><?php esc_html_e( 'Export Applications', 'pro-pack-for-wp-job-openings' ); ?></strong></a>
			<?php
		endif;
	}

	public function export_applications_handler() {
		if ( isset( $_GET['awsm_action'] ) && $_GET['awsm_action'] === 'export_applications' ) {
			if ( ! is_user_logged_in() || ! current_user_can( 'edit_others_applications' ) ) {
				wp_die( esc_html__( 'You are not authorized to make this request!', 'pro-pack-for-wp-job-openings' ) );
			}

			if ( ! isset( $_GET['awsm_nonce'] ) || ! wp_verify_nonce( $_GET['awsm_nonce'], 'awsm_export_nonce' ) ) {
				wp_die( esc_html__( 'Invalid request!', 'pro-pack-for-wp-job-openings' ) );
			}

			$args = array(
				'post_type'      => 'awsm_job_application',
				'post_status'    => 'any',
				'posts_per_page' => -1,
				'order'          => 'ASC',
				'orderby'        => 'ID',
			);

			$meta_query = array();
			$job_filter = isset( $_GET['awsm_filter_posts'] ) ? intval( $_GET['awsm_filter_posts'] ) : '';
			if ( ! empty( $job_filter ) && get_post_type( $job_filter ) === 'awsm_job_openings' ) {
				$meta_query[] = array(
					'key'   => 'awsm_job_id',
					'value' => $job_filter,
				);
			}
			if ( ! empty( $meta_query ) ) {
				$args['meta_query'] = $meta_query;
			}

			$applications = get_posts( $args );

			if ( ! empty( $applications ) ) {
				// Generate Header.
				$data       = array(
					array(
						'awsm_application_id'   => esc_html__( 'Application ID', 'pro-pack-for-wp-job-openings' ),
						'awsm_applicant_name'   => esc_html__( 'Applicant Name', 'pro-pack-for-wp-job-openings' ),
						'awsm_applicant_email'  => esc_html__( 'Email', 'pro-pack-for-wp-job-openings' ),
						'awsm_job_id'           => esc_html__( 'Job ID', 'pro-pack-for-wp-job-openings' ),
						'awsm_apply_for'        => esc_html__( 'Job Title', 'pro-pack-for-wp-job-openings' ),
						'awsm_application_date' => esc_html__( 'Applied on', 'pro-pack-for-wp-job-openings' ),
					),
				);
				$fb_options = get_option( 'awsm_jobs_form_builder' );
				if ( empty( $fb_options ) ) {
					$fb_options = array();
					if ( method_exists( 'AWSM_Job_Openings_Pro_Settings', 'form_builder_default_options' ) ) {
						$fb_options = AWSM_Job_Openings_Pro_Settings::form_builder_default_options();
					}
				}
				foreach ( $fb_options as $fb_option ) {
					if ( $fb_option['name'] !== 'awsm_applicant_name' && $fb_option['name'] !== 'awsm_applicant_email' ) {
						$data[0][ $fb_option['name'] ] = $fb_option['label'];
					}
				}
				$data[0]['application_status'] = esc_html__( 'Status', 'pro-pack-for-wp-job-openings' );

				// Now, generate content.
				foreach ( $applications as $application ) {
					$application_id    = $application->ID;
					$applicant_details = array();

					// Fixed fields.
					$applicant_details['awsm_application_id'] = $application_id;
					$general_fields                           = array( 'awsm_applicant_name', 'awsm_applicant_email', 'awsm_job_id', 'awsm_apply_for' );
					foreach ( $general_fields as $general_field ) {
						$applicant_details[ $general_field ] = get_post_meta( $application_id, $general_field, true );
					}
					$applicant_details['awsm_application_date'] = get_the_date( '', $application_id );

					// Custom fields.
					$custom_fields = get_post_meta( $application_id, 'awsm_applicant_custom_fields', true );
					foreach ( $fb_options as $fb_option ) {
						if ( $fb_option['super_field'] !== true ) {
							$field_value = '';
							$name        = $fb_option['name'];
							$field_type  = $fb_option['field_type'];
							if ( $fb_option['default_field'] !== true ) {
								if ( isset( $custom_fields[ $name ]['value'] ) ) {
									$field_value = $custom_fields[ $name ]['value'];
									if ( $field_type === 'photo' || $field_type === 'file' ) {
										$field_value = ! empty( $field_value ) ? wp_get_attachment_url( $field_value ) : '';
									}
								}
							} else {
								if ( $field_type === 'resume' ) {
									$attachment_id = get_post_meta( $application_id, 'awsm_attachment_id', true );
									$field_value   = ! empty( $attachment_id ) ? wp_get_attachment_url( $attachment_id ) : '';
								} else {
									$field_value = get_post_meta( $application_id, $name, true );
								}
							}
							if ( empty( $field_value ) ) {
								$field_value = esc_html__( 'NA', 'pro-pack-for-wp-job-openings' );
							}
							$applicant_details[ $name ] = $field_value;
						}
					}
					$post_status = get_post_status( $application_id );
					if ( method_exists( 'AWSM_Job_Openings_Pro_Main', 'get_application_status' ) ) {
						$available_status = AWSM_Job_Openings_Pro_Main::get_application_status();
						if ( isset( $available_status[ $post_status ] ) ) {
							$post_status = $available_status[ $post_status ]['label'];
						}
					}
					$applicant_details['application_status'] = $post_status;

					$data[] = $applicant_details;
				}
				$file_name = sanitize_file_name( 'job-applications-' . current_time( 'Y-m-d' ) . '.csv' );
				header( 'Content-Encoding: UTF-8' );
				header( 'Content-Type: text/csv; charset=utf-8' );
				header( 'Content-Disposition: attachment; filename="' . $file_name . '"' );
				header( 'Pragma: no-cache' );
				header( 'Expires: 0' );
				$file = fopen( 'php://output', 'w' );
				foreach ( $data as $rows ) {
					fputcsv( $file, $rows );
				}
				exit;
			}
		}
	}

	public function jobs_query_args( $args, $filters, $shortcode_atts ) {
		$spec_details = isset( $shortcode_atts['specs'] ) ? $shortcode_atts['specs'] : '';
		if ( ! empty( $spec_details ) ) {
			$specs = explode( ',', $spec_details );
			foreach ( $specs as $spec ) {
				if ( strpos( $spec, ':' ) !== false ) {
					list( $taxonomy, $spec_terms ) = explode( ':', $spec );
					$args['tax_query'][]           = array(
						'taxonomy' => sanitize_text_field( $taxonomy ),
						'field'    => 'id',
						'terms'    => array_map( 'intval', explode( ' ', $spec_terms ) ),
					);
				}
			}
		}
		return $args;
	}
}

$awsm_pro_job_openings = AWSM_Job_Openings_Pro_Pack::init();

// activation
register_activation_hook( __FILE__, array( $awsm_pro_job_openings, 'activate' ) );
