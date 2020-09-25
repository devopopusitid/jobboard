<div class="awsm-form-section-main awsm-sub-options-container" id="awsm-builder-form-options-container" style="display: none;">
	<?php
		// form builder fields options.
		$form_builder_options = get_option( 'awsm_jobs_form_builder', AWSM_Job_Openings_Pro_Settings::form_builder_default_options() );

		// form builder other options.
		$other_options    = get_option(
			'awsm_jobs_form_builder_other_options',
			array(
				'form_title' => esc_html__( 'Apply for this position', 'wp-job-openings' ),
				'btn_text'   => esc_html__( 'Submit', 'wp-job-openings' ),
			)
		);
		$form_title       = isset( $other_options['form_title'] ) ? $other_options['form_title'] : '';
		$form_description = isset( $other_options['form_description'] ) ? $other_options['form_description'] : '';
		$btn_text         = isset( $other_options['btn_text'] ) ? $other_options['btn_text'] : '';
		?>
	<div class="awsm-jobs-settings-subtitle">
		<h2><?php esc_html_e( 'Form Builder', 'pro-pack-for-wp-job-openings' ); ?></h2>
	</div>
	<div class="awsm-jobs-form-builder-main">

		<?php do_action( 'before_awsm_form_builder_settings' ); ?>

		<div class="awsm-jobs-form-builder-head">
			<p>
			<abbr title="<?php esc_html_e( 'Click to edit', 'pro-pack-for-wp-job-openings' ); ?>"><input type="text" placeholder="<?php esc_html_e( 'Form Title', 'pro-pack-for-wp-job-openings' ); ?>" class="regular-text awsm-jobs-form-builder-control" name="awsm_jobs_form_builder_other_options[form_title]" value="<?php echo esc_attr( $form_title ); ?>" /></abbr>
			</p>
			<p>
			<abbr title="<?php esc_html_e( 'Click to edit', 'pro-pack-for-wp-job-openings' ); ?>"><textarea name="awsm_jobs_form_builder_other_options[form_description]" cols="25" rows="2" class="awsm-jobs-form-builder-control" placeholder="<?php esc_html_e( '(Optional description)', 'pro-pack-for-wp-job-openings' ); ?>"><?php echo esc_textarea( $form_description ); ?></textarea></abbr>
			</p>
		</div><!-- .awsm-jobs-form-builder-head -->

		<div class="awsm-jobs-form-builder" id="awsm-jobs-form-builder" data-next="<?php echo ( ! empty( $form_builder_options ) ) ? count( $form_builder_options ) : 1; ?>">
			<?php
			if ( empty( $form_builder_options ) ) {
				$index = 0;
				$this->fb_template( $index );
			} else {
				foreach ( $form_builder_options as $key => $form_builder_option ) {
					$this->fb_template( $key, $form_builder_option );
				}
			}
			?>
		</div><!-- .awsm-jobs-form-builder -->

		<!-- fb-templates -->
		<script type="text/html" id="tmpl-awsm-pro-fb-settings">
			<?php $this->fb_template( '{{data.index}}' ); ?>
		</script>

		<script type="text/html" id="tmpl-awsm-pro-fb-field-options">
			<?php $this->fb_field_options_template( '{{data.index}}' ); ?>
		</script>

		<script type="text/html" id="tmpl-awsm-pro-fb-file-options">
			<?php $this->fb_file_type_options_template( '{{data.index}}' ); ?>
		</script>

		<script type="text/html" id="tmpl-awsm-pro-fb-template-tag">
			<?php $this->fb_field_tag_template( '{{data.index}}' ); ?>
		</script>

		<script type="text/html" id="tmpl-awsm-pro-fb-error">
			<div class="awsm-jobs-error-container">
				<div class="awsm-jobs-error">
					<p>
						<strong>
							<# if( data.isFieldType ) { #>
								<?php
									/* translators: %s: form field type */
									printf( esc_html__( 'Sorry! You can only have one %s field', 'pro-pack-for-wp-job-openings' ), '{{data.fieldType}}' );
								?>
							<# } #>
							<# if( data.invalidKey ) { #>
								<?php
									echo esc_html__( 'The template tag should only contain alphanumeric, latin characters separated by hyphen/underscore', 'pro-pack-for-wp-job-openings' );
								?>
							<# } #>
						</strong>
					</p>
				</div>
			</div>
		</script>
		<!-- /fb-templates -->

		<div class="awsm-jobs-form-builder-footer">
			<div class="awsm-jobs-form-element-main">
				<div class="awsm-jobs-form-element-head">
					<div class="awsm-jobs-form-element-head-title">
						<h3>
							<span class="awm-jobs-form-builder-title">
								<?php echo esc_html( $btn_text ); ?>
							</span>
							<span class="awm-jobs-form-builder-input-type">
								<?php esc_html_e( 'Submit Button', 'pro-pack-for-wp-job-openings' ); ?>
							</span>
						</h3>
					</div>
				</div><!-- .awsm-jobs-form-element-head -->

				<div class="awsm-jobs-form-element-content">
					<div class="awsm-jobs-form-element-content-in">
						<p>
							<label for="awsm-job-form-submit-btn-txt"><?php esc_html_e( 'Label:', 'pro-pack-for-wp-job-openings' ); ?>
								<input type="text" class="widefat" id="awsm-job-form-submit-btn-txt" name="awsm_jobs_form_builder_other_options[btn_text]" value="<?php echo esc_attr( $btn_text ); ?>" required />
							</label>
						</p>
						<p>
							<button type="button" class="button-link awsm-jobs-form-element-close"><?php esc_html_e( 'Close', 'pro-pack-for-wp-job-openings' ); ?></button>
						</p>
					</div><!-- .awsm-jobs-form-element-content-in -->
				</div><!-- .awsm-jobs-form-element-content -->
			</div><!-- .awsm-jobs-form-element-main -->

			<p><a class="button awsm-add-form-field-row" href="#"><?php esc_html_e( 'Add new Field', 'pro-pack-for-wp-job-openings' ); ?></a></p>
		</div><!-- .awsm-jobs-form-builder-footer -->

		<?php do_action( 'after_awsm_form_builder_settings' ); ?>

	</div><!-- .awsm-jobs-form-builder-main -->
</div><!-- #awsm-builder-form-options-container -->
