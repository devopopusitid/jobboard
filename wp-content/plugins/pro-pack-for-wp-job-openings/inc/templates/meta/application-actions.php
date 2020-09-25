<?php
if ( ! class_exists( 'AWSM_Job_Openings_Pro_Main' ) ) {
	return;
}

	$application_id     = $post->ID;
	$application_status = get_post_status( $application_id );
	$available_status   = AWSM_Job_Openings_Pro_Main::get_application_status();

	unset( $available_status['trash'] );
if ( $application_status !== 'publish' ) {
	unset( $available_status['publish'] );
}
?>

<div class="submitbox" id="submitpost">
	<div id="minor-publishing">
		<div id="misc-publishing-actions">
			<div class="misc-pub-section">
				<div id="post-status-select" class="misc-pub-post-status">
					<label for="post_status"><?php esc_html_e( 'Application Status', 'pro-pack-for-wp-job-openings' ); ?></label>
					<select name="post_status" id="post_status" class="awsm-select-control">
						<?php
						foreach ( $available_status as $status_name => $status_details ) {
							printf( '<option value="%1$s"%3$s>%2$s</option>', esc_attr( $status_name ), esc_html( $status_details['label'] ), selected( $post->post_status, $status_name, false ) );
						}
						?>
					</select>
				</div>
			</div>
			<div class="misc-pub-section curtime misc-pub-curtime">
				<span id="timestamp">
					<?php
						/* translators: %s: application submission time */
						printf( esc_html__( 'Submitted on: %s', 'pro-pack-for-wp-job-openings' ), sprintf( '<strong>%s</strong>', esc_html( date_i18n( __( 'M j, Y @ H:i', 'default' ), strtotime( $post->post_date ) ) ) ) );
					?>
				</span>
			</div>
			<!-- Rating -->
			<div class="misc-pub-section awsm-application-rating-pub-section">
				<div class="awsm-application-rating-fieldset">
				  <span class="awsm-application-rating-container">
					<?php
						$rating = get_post_meta( get_the_ID(), 'awsm_application_rating', true );
					for ( $i = 5; $i >= 1; $i-- ) :
						$checked = ( $i === (int) $rating ) ? ' checked' : '';
						?>
							  <input type="radio" id="awsm_application_rating-<?php echo esc_attr( $i ); ?>" name="awsm_application_rating" value="<?php echo esc_attr( $i ); ?>"<?php echo esc_attr( $checked ); ?>/><label for="awsm_application_rating-<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $i ); ?></label>
					<?php endfor; ?>
							<input type="radio" id="awsm_application_rating-0" class="star-cb-clear" name="awsm_application_rating" value="0" /><label for="awsm_application_rating-0">0</label>
				  </span>
				</div>
			</div>
			<!-- End of Rating -->
		</div>
		<div class="clear"></div>
	</div><!-- #minor-publishing -->

	<div id="major-publishing-actions" class="awsm-application-major-actions">
		<div id="publishing-action">
			<span class="spinner"></span>
			<?php wp_nonce_field( 'awsm_save_post_meta', 'awsm_jobs_posts_nonce' ); ?>
			<input type="hidden" name="awsm_pro_post_id" id="awsm-pro-application-id" value="<?php echo esc_attr( $application_id ); ?>" />
			<input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e( 'Update', 'default' ); ?>" />
			<input name="save" type="submit" class="button button-primary button-large" id="publish" value="<?php esc_attr_e( 'Update', 'default' ); ?>" />
		</div>
		<div class="clear"></div>
	</div><!-- #major-publishing-actions -->
</div>
