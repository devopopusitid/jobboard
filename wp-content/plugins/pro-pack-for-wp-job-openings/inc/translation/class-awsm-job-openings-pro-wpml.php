<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AWSM_Job_Openings_Pro_WPML {
	private static $instance = null;

	public function __construct() {
		$this->cpath = untrailingslashit( plugin_dir_path( __FILE__ ) );

		add_action( 'update_option_awsm_jobs_form_builder', array( $this, 'form_builder_handler' ), 10, 2 );
		add_action( 'update_option_awsm_jobs_form_builder_other_options', array( $this, 'form_builder_other_options_handler' ), 10, 2 );
	}

	public static function init() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function form_builder_handler( $old_value, $fb_options ) {
		if ( ! empty( $fb_options ) && is_array( $fb_options ) ) {
			$name_format = 'Application Form: %s';
			foreach ( $fb_options as $fb_option ) {
				$value = $fb_option['label'];
				$name  = sprintf( $name_format, 'Label for ' . $fb_option['name'] );
				do_action( 'wpml_register_single_string', 'pro-pack-for-wp-job-openings', $name, $value );
			}
		}
	}

	public function form_builder_other_options_handler( $old_value, $other_options ) {
		if ( ! empty( $other_options ) && is_array( $other_options ) ) {
			$name_format = 'Application Form: %s';
			foreach ( $other_options as $name => $value ) {
				$name = sprintf( $name_format, ucwords( str_replace( '_', ' ', $name ) ) );
				do_action( 'wpml_register_single_string', 'pro-pack-for-wp-job-openings', $name, $value );
			}
		}
	}
}

AWSM_Job_Openings_Pro_WPML::init();
