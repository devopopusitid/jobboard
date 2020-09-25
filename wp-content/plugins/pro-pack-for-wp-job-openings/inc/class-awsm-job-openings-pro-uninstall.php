<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AWSM_Job_Openings_Pro_Uninstall {

	public static function pro_uninstall() {
		self::delete_pro_options();
	}

	public static function get_all_pro_options() {
		$pro_options = array(
			'awsm_jobs_pro_version',
			'awsm_jobs_form_builder',
			'awsm_jobs_form_builder_other_options',
			'awsm_jobs_pro_mail_templates',
			'awsm_jobs_pro_license',
			'awsm_register_pro_default_settings',
		);
		return $pro_options;
	}

	public static function delete_pro_options() {
		if ( get_option( 'awsm_delete_data_on_uninstall' ) === 'delete_data' ) {
			$pro_options = self::get_all_pro_options();
			foreach ( $pro_options as $pro_option ) {
				delete_option( $pro_option );
			}
		}
	}
}


