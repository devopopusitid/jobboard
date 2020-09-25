<div class="awsm-sub-options-container" id="awsm-templates-notification-options-container" style="display: none;">
	<?php
		$options = get_option( 'awsm_jobs_pro_mail_templates' );
	?>
	<div id="settings-awsm-settings-notification-templates">
		<div class="awsm-form-section-main awsm-acc-section-main" id="awsm-repeatable-mail-templates" data-next="<?php echo ( ! empty( $options ) ) ? count( $options ) : 1; ?>">
			<div class="awsm-form-section awsm-acc-secton awsm-mail-templates-acc-section">
				<?php
				if ( empty( $options ) ) {
					$index = 0;
					$this->mail_template( $index );
				} else {
					foreach ( $options as $index => $template ) {
						$this->mail_template( $index, $template );
					}
				}
				?>
			</div><!-- .awsm-form-section -->
		</div><!-- .awsm-form-section-main -->

		 <!-- notification-templates -->
		 <script type="text/html" id="tmpl-awsm-pro-notification-settings">
			<?php $this->mail_template( '{{data.index}}' ); ?>
		</script>
		<!-- /notification-templates -->

		<p><a class="button awsm-add-mail-templates" href="#"><?php esc_html_e( 'Add new template', 'pro-pack-for-wp-job-openings' ); ?></a></p>

		<div class="awsm-form-footer">
			<?php echo apply_filters( 'awsm_job_settings_submit_btn', get_submit_button(), 'notification' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div><!-- .awsm-form-footer -->
	</div><!-- #settings-awsm-settings-notification-templates -->
</div><!-- .awsm-templates-notification-options-container -->
