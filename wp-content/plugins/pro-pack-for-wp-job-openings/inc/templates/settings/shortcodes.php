<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$taxonomy_objects = get_object_taxonomies( 'awsm_job_openings', 'objects' );
?>
<div id="settings-awsm-settings-shortcodes" class="awsm-admin-settings">
	<div class="awsm-settings-col-left">
		<?php do_action( 'before_awsm_settings_main_content', 'shortcodes' ); ?>

		<div class="awsm-form-section-main awsm-sub-options-container" id="awsm-job-shortcodes-options-container">
			<div class="awsm-form-section">
				<table width="100%" class="awsm-settings-shortcodes-table form-table">
					<thead>
						 <tr>
						   <th scope="row" colspan="2" class="awsm-form-head-title">
								   <h2><?php esc_html_e( 'Generate shortcode', 'pro-pack-for-wp-job-openings' ); ?></h2>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php do_action( 'before_awsm_shortcodes_settings' ); ?>
						<tr>
							<th scope="row"><?php echo esc_html__( 'Job listing', 'pro-pack-for-wp-job-openings' ); ?></th>
							<td>
								<ul class="awsm-list-inline">
									<li>
										<label for="awsm_jobs_listing_all">
											<input type="radio" name="awsm_jobs_listing" value="all_jobs" id="awsm_jobs_listing_all" class="awsm-check-toggle-control awsm-shortcodes-job-listing-control" data-toggle-target="#awsm-jobs-filters-container" checked>
											<?php echo esc_html__( 'All Jobs', 'pro-pack-for-wp-job-openings' ); ?>
										</label>
									</li>
									<li>
										<label for="awsm_jobs_listing_filtered">
											<input type="radio" name="awsm_jobs_listing" id="awsm_jobs_listing_filtered" value="filter_jobs" class="awsm-check-toggle-control awsm-shortcodes-job-listing-control" data-toggle="true" data-toggle-target="#awsm-jobs-filters-container">
											<?php echo esc_html__( 'Filtered list of jobs', 'pro-pack-for-wp-job-openings' ); ?>
										</label>
									</li>
								</ul>
								<div id="awsm-jobs-filters-container" class="awsm-hide">
									<br />
									<fieldset>
									<ul class="awsm-check-list">
										<?php
										foreach ( $taxonomy_objects as $spec => $spec_details ) :
											?>
											<li>
											<div class="awsm-shortcodes-filter-item">
												<label for="awsm_jobs_filter_by_<?php echo esc_attr( $spec ); ?>">
													<input type="checkbox" id="awsm_jobs_filter_by_<?php echo esc_attr( $spec ); ?>" value="yes" class="awsm-check-toggle-control" data-toggle="true" data-toggle-target="#awsm_jobs_filter_<?php echo esc_attr( $spec ); ?>">
													<?php
														/* translators: %s: specification label */
														printf( esc_html__( 'Filter by %s', 'pro-pack-for-wp-job-openings' ), esc_html( $spec_details->label ) );
													?>
												</label>
												<p id="awsm_jobs_filter_<?php echo esc_attr( $spec ); ?>" class="awsm-hide">
													<select class="awsm-shortcodes-filters-select-control" multiple="multiple" style="width: 100%;" data-filter="<?php echo esc_attr( $spec ); ?>">
												<?php
													$spec_terms = get_terms( $spec, 'orderby=name&hide_empty=1' );
												if ( ! empty( $spec_terms ) ) {
													foreach ( $spec_terms as $spec_term ) {
														echo sprintf( '<option value="%1$s" data-slug="%3$s">%2$s</option>', esc_attr( $spec_term->term_id ), esc_html( $spec_term->name ), esc_attr( $spec_term->slug ) );
													}
												}
												?>
													</select>
												</p>
											</div>
										</li>
											<?php
											endforeach;
										?>
									</ul>  
									<p class="description"><?php echo esc_html__( 'Check the options only if you want to filter the listing by specification(s).', 'pro-pack-for-wp-job-openings' ); ?></p>
									</fieldset>
								</div>
							</td>
						</tr>
						<tr id="awsm-jobs-enable-filters-container">
							<th scope="row"><?php echo esc_html__( 'Filters', 'pro-pack-for-wp-job-openings' ); ?></th>
							<td>
								<label for="awsm_jobs_enable_filters"><input type="checkbox" id="awsm_jobs_enable_filters" value="yes" checked /><?php echo esc_html__( 'Enable job filters', 'pro-pack-for-wp-job-openings' ); ?></label>
								<p class="description"><?php echo esc_html__( 'Checking this option enables filter option', 'pro-pack-for-wp-job-openings' ); ?></p>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="awsm_jobs_listings"><?php echo esc_html__( 'Number of jobs to show', 'pro-pack-for-wp-job-openings' ); ?></label></th>
							<td>
								<input type="text" class="small-text"  id="awsm_jobs_listings" />
								<p class="description"><?php echo esc_html__( 'Default Number of Job Listings to display', 'pro-pack-for-wp-job-openings' ); ?></p>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php echo esc_html__( 'Pagination', 'pro-pack-for-wp-job-openings' ); ?>
							</th>
							<td>
								<label for="awsm_jobs_pagination">
									<input type="checkbox" id="awsm_jobs_pagination" value="yes" checked />
									<?php echo esc_html__( 'Enable "Load More"', 'pro-pack-for-wp-job-openings' ); ?>
								</label>
								<p class="description"><?php echo esc_html__( 'Unchecking this option disables pagination for the listing', 'pro-pack-for-wp-job-openings' ); ?></p>
							</td>
						</tr>
						<?php do_action( 'after_awsm_shortcodes_settings' ); ?>
					</tbody>
				</table>
			</div><!-- .awsm-form-section -->
		</div><!-- .awsm-form-section-main -->

		<?php do_action( 'after_awsm_settings_main_content', 'shortcodes' ); ?>
		<div class="awsm-form-footer">
			<button class="button button-primary button-large" id="awsm-jobs-generate-shortcode"><?php echo esc_html__( 'Generate Shortcode', 'pro-pack-for-wp-job-openings' ); ?></button>
		</div><!-- .awsm-form-footer -->
	</div>
	
	<div class="awsm-settings-col-right">
		<div class="awsm-settings-shortcodes-aside">
			<h3><?php echo esc_html__( 'Your shortcode', 'pro-pack-for-wp-job-openings' ); ?></h3>
			<div class="awsm-settings-shortcodes-wrapper">
				<?php printf( '<p><code>%1$s</code></p>', esc_html( '[awsmjobs]' ) ); ?>
			</div>
		</div><!-- .awsm-settings-aside -->
		<?php
		printf(
			'<button id="awsm-copy-clip" type="button" data-clipboard-text="%1$s" class="button">%2$s</button>
			',
			esc_attr( '[awsmjobs]' ),
			esc_html__( 'Copy', 'wp-job-openings' )
		);
		?>
	</div><!-- .awsm-settings-col-right -->	
</div><!-- .awsm-admin-settings -->

