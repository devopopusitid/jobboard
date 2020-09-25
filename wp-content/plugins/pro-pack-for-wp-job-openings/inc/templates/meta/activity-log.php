<?php
if ( ! class_exists( 'AWSM_Job_Openings_Pro_Main' ) ) {
	return;
}

	$application_id     = get_the_ID();
	$applicant_name     = get_post_meta( $application_id, 'awsm_applicant_name', true );
	$available_status   = AWSM_Job_Openings_Pro_Main::get_application_status();
	$activities         = get_post_meta( $application_id, 'awsm_application_activity_log', true );
	$current_activities = ! empty( $activities ) && is_array( $activities ) ? $activities : array();
	$update_meta        = false;
if ( ! empty( $current_activities ) ) {
	if ( ! $this->is_applicant_viewed( $current_activities ) ) {
		$current_activities[] = $this->get_view_activity();
		$update_meta          = true;
	}
} else {
	// update initial activity log.
	$current_activities   = array(
		array(
			'user'          => $applicant_name,
			'activity_date' => strtotime( $post->post_date ),
			'submit'        => true,
		),
	);
	$current_activities[] = $this->get_view_activity();
	$update_meta          = true;
}
if ( $update_meta ) {
	$updated = update_post_meta( $application_id, 'awsm_application_activity_log', $current_activities );
	if ( $updated ) {
		$activities = $current_activities;
	}
}
?>

<div class="awsm-application-activity-container">
	<ul class="awsm-application-activity-log awsm-jobs-application-list">
		<?php
		if ( ! empty( $activities ) && is_array( $activities ) ) {
			$activities = array_reverse( $activities );
			foreach ( $activities as $activity ) {
				$content = '';
				if ( isset( $activity['status'] ) ) {
					$application_status = $activity['status'];
					$content            = isset( $available_status[ $application_status ] ) ? $available_status[ $application_status ]['label'] : '';
				}
				if ( isset( $activity['rating'] ) ) {
					$rating = intval( $activity['rating'] );
					/* translators: %s: application rating */
					$content = sprintf( esc_html__( '%s-star rated', 'pro-pack-for-wp-job-openings' ), $rating );
				}
				if ( isset( $activity['viewed'] ) ) {
					$content = esc_html__( 'Viewed', 'pro-pack-for-wp-job-openings' );
				}
				if ( isset( $activity['submit'] ) ) {
					$content = esc_html__( 'Submitted', 'pro-pack-for-wp-job-openings' );
				}

				$output = '';
				if ( isset( $activity['mail'] ) ) {
					$output = esc_html__( 'Sent email to the applicant', 'pro-pack-for-wp-job-openings' );
				} else {
					$output = sprintf( 'Application %s', $content );
				}
				$user = $activity['user'];
				if ( intval( $user ) ) {
					$user = $this->get_username( $user );
				}

				if ( ! empty( $content ) || isset( $activity['mail'] ) ) :
					?>
					<li>
						<div class="awsm-application-activity"><?php echo esc_html( $output ); ?></div>
						<div class="awsm-application-activity-details">
							<p class="description">
								<span><?php echo esc_html( $user ); ?></span>, <span><?php echo esc_html( date_i18n( __( 'M j, Y @ H:i', 'default' ), $activity['activity_date'] ) ); ?></span>
							</p>
						</div>
					</li>
					<?php
				endif;
			}
		}
		?>
	</ul>
</div>
