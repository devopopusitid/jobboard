<?php
	$application_id = $post->ID;
	$applicant_mail = get_post_meta( $application_id, 'awsm_applicant_email', true );
	$applicant_cc   = get_post_meta( $application_id, 'awsm_mail_meta_applicant_cc', true );
	$ets_data       = get_option( 'awsm_jobs_pro_mail_templates' );
?>

<div class="awsm-applicant-meta-mail-container">
	<div class="awsm-applicant-meta-mail-main posttypediv">
		<ul class="category-tabs awsm-applicant-meta-mail-tabs">
			<li class="tabs"><a href="#awsm-applicant-meta-new-mail"><?php esc_html_e( 'New Mail', 'pro-pack-for-wp-job-openings' ); ?></a></li>
			<li class="hide-if-no-js"><a href="#awsm-applicant-meta-sent-mails"><?php esc_html_e( 'Sent Mails', 'pro-pack-for-wp-job-openings' ); ?></a></li>
		</ul>
		<div id="awsm-applicant-meta-new-mail" class="tabs-panel awsm-applicant-meta-mail-tabs-panel">
			<div class="awsm-form-section-main">
				<div class="awsm-form-section">
					<div class="awsm-row">
						<div class="awsm-col awsm-form-group awsm-col-half">
							<label for="awsm_mail_meta_applicant_template"><?php esc_html_e( 'Email template', 'pro-pack-for-wp-job-openings' ); ?></label>
							<select name="awsm_mail_meta_applicant_template" id="awsm_mail_meta_applicant_template" class="awsm-select-control regular-text">
										<option value="" selected="selected"><?php echo esc_html_e( 'No template', 'pro-pack-for-wp-job-openings' ); ?></option>
										<?php
										if ( ! empty( $ets_data ) ) :
											foreach ( $ets_data as $et_data ) :
												?>
													<option value="<?php echo esc_attr( $et_data['key'] ); ?>"><?php echo esc_html( $et_data['name'] ); ?></option>
												<?php
												endforeach;
											endif;
										?>
								</select>
						</div><!-- .col -->
					</div><!-- row -->
					<div class="awsm-row" id="awsm_application_mail_ele">
							<div class="awsm-col awsm-form-group awsm-col-half">
							<label for="awsm_mail_meta_applicant_email"><?php esc_html_e( 'Applicant', 'pro-pack-for-wp-job-openings' ); ?></label>
								<input type="text" class="awsm-form-control" id="awsm_mail_meta_applicant_email" value="<?php echo esc_attr( $applicant_mail ); ?>" disabled />
						</div><!-- .col -->
						<div class="awsm-col awsm-form-group awsm-col-half">
							<label for="awsm_mail_meta_applicant_cc"><?php esc_html_e( 'CC:', 'pro-pack-for-wp-job-openings' ); ?></label>
								<input type="text" class="awsm-form-control awsm-applicant-mail-field" name="awsm_mail_meta_applicant_cc" id="awsm_mail_meta_applicant_cc" value="" />
						</div><!-- .col -->
						<div class="awsm-col awsm-form-group">
							<label for="awsm_mail_meta_applicant_subject"><?php esc_html_e( 'Subject ', 'pro-pack-for-wp-job-openings' ); ?></label>
								<input type="text" class="awsm-form-control wide-fat awsm-applicant-mail-field awsm-applicant-mail-req-field" id="awsm_mail_meta_applicant_subject" name="awsm_mail_meta_applicant_subject" value="" />
						</div><!-- .col -->
						<div class="awsm-col awsm-form-group">
							<textarea class="awsm-form-control awsm-applicant-mail-field awsm-applicant-mail-req-field" id="awsm_mail_meta_applicant_content" name="awsm_mail_meta_applicant_content" rows="5" cols="50"></textarea>
						</div><!-- .col -->
					</div>
					<ul class="awsm-list-inline">
						<li>
							<button type="button" name="awsm_applicant_mail_btn" class="button button-large" id="awsm_applicant_mail_btn" data-response-text="<?php esc_html_e( 'Sending...', 'pro-pack-for-wp-job-openings' ); ?>"><?php esc_html_e( 'Send', 'pro-pack-for-wp-job-openings' ); ?></button>
						</li>
					</ul>
					<div class="awsm-applicant-mail-message"></div>
				</div><!-- .awsm-form-section -->
			</div><!-- .awsm-form-section-main -->
		</div>
		<div id="awsm-applicant-meta-sent-mails" class="tabs-panel awsm-applicant-meta-mail-tabs-panel" style="display: none;">
			<div id="awsm-jobs-applicant-mails-container">
				<?php
					$mail_details = get_post_meta( $application_id, 'awsm_application_mails', true );
				if ( ! empty( $mail_details ) && is_array( $mail_details ) ) {
					$mail_details = array_reverse( $mail_details );
					foreach ( $mail_details as $mail_detail ) {
						$author_name = $mail_detail['send_by'] === 0 ? esc_html__( 'System', 'pro-pack-for-wp-job-openings' ) : $this->get_username( $mail_detail['send_by'] );
						$this->applicant_mail_template(
							array(
								'author'    => $author_name,
								'date_i18n' => esc_html( date_i18n( __( 'M j, Y @ H:i', 'default' ), $mail_detail['mail_date'] ) ),
								'subject'   => $mail_detail['subject'],
								'content'   => wpautop( $mail_detail['mail_content'] ),
							)
						);
					}
				} else {
					printf( '<div id="awsm_jobs_no_mail_wrapper"><p>%s</p></div>', esc_html__( 'No mails to show!', 'pro-pack-for-wp-job-openings' ) );
				}
				?>
			</div>
		</div>
	</div>
</div>

<script type="text/html" id="tmpl-awsm-pro-applicant-mail">
	<?php $this->applicant_mail_template(); ?>
</script>
