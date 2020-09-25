<div class="awsm-jobs-application-notes">
	<div class="awsm-jobs-application-notes-field">
		<input type="text" name="awsm_application_notes" id="awsm_application_notes" class="widefat" placeholder="<?php esc_html_e( 'Write your notes here...', 'pro-pack-for-wp-job-openings' ); ?>" />
	</div>
	<ul class="awsm-jobs-application-notes-list awsm-jobs-application-list tagchecklist awsm-jobs-loading-container">
		<?php
			$notes = get_post_meta( $post->ID, 'awsm_application_notes', true );
		if ( ! empty( $notes ) && is_array( $notes ) ) {
			$notes       = array_reverse( $notes );
			$total_notes = count( $notes );
			foreach ( $notes as $key => $note ) {
				$author_name = $this->get_username( $note['author_id'] );
				$index       = $total_notes - ( $key + 1 );
				$this->notes_template(
					array(
						'index'     => $index,
						'time'      => $note['notes_date'],
						'date_i18n' => esc_html( date_i18n( __( 'M j, Y @ H:i', 'default' ), $note['notes_date'] ) ),
						'author'    => $author_name,
						'content'   => $note['notes_content'],
					)
				);
			}
		}
		?>
	</ul>
</div>

<script type="text/html" id="tmpl-awsm-pro-notes">
	<?php $this->notes_template(); ?>
</script>
