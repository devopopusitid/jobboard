<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$license_key = get_option( 'awsm_jobs_pro_license' );
?>

<div id="settings-awsm-settings-license" class="awsm-admin-settings">
	<?php do_action( 'awsm_settings_form_elem_start', 'license' ); ?>
	<form method="POST" action="options.php" id="awsm-jobs-pro-license-form">
		<?php
		settings_fields( 'awsm-jobs-license-settings' );
		do_action( 'before_awsm_settings_main_content', 'license' );
		?>

		<div class="awsm-form-section-main awsm-sub-options-container" id="awsm-license-options-container">
			<table class="form-table">
				<tbody>
					<?php do_action( 'before_awsm_license_settings' ); ?>

					<tr>
						<th scope="row">
							<label for="awsm_jobs_pro_license"><?php esc_html_e( 'Envato purchase key', 'pro-pack-for-wp-job-openings' ); ?></label>
						</th>
						<td>
							<div class="awsm-jobs-pro-inputholder">
								<input type="text" name="awsm_jobs_pro_license" id="awsm_jobs_pro_license" value="<?php echo esc_attr( $license_key ); ?>" class="regular-text" required />
							</div>
							<div class="awsm-jobs-pro-instructions">
								<ol>
									<li>
										<a href="https://codecanyon.net/downloads" target="_blank">
											<?php esc_html_e( 'Obtain purchase key', 'pro-pack-for-wp-job-openings' ); ?>
										</a>
									</li>
									<li>
										<a href="https://1.envato.market/getcode" target="_blank">
											<?php esc_html_e( 'How to get it ?', 'pro-pack-for-wp-job-openings' ); ?>
										</a>
									</li>
								</ol>
							</div>
						</td>
					</tr>

					<?php do_action( 'after_awsm_license_settings' ); ?>
				</tbody>
			</table>
		</div><!-- #awsm-license-options-container -->
		
		<div class="awsm-form-footer">
			<?php echo apply_filters( 'awsm_job_settings_submit_btn', get_submit_button(), 'license' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div><!-- .awsm-form-footer -->
		
		<?php do_action( 'after_awsm_settings_main_content', 'license' ); ?>

	</form>
	<?php do_action( 'awsm_settings_form_elem_end', 'license' ); ?>
</div> 
