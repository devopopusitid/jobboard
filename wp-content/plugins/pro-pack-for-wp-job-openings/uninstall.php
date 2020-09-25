<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die();
}

if ( get_option( 'awsm_delete_data_on_uninstall' ) !== 'delete_data' ) {
	return;
}

	require_once dirname( __FILE__ ) . '/inc/class-awsm-job-openings-pro-uninstall.php';

if ( class_exists( 'AWSM_Job_Openings_Pro_Uninstall' ) ) {
	AWSM_Job_Openings_Pro_Uninstall::pro_uninstall();
}


