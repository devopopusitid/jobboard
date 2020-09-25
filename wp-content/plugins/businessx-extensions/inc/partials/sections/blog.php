<?php
/**
 * ------------------
 * Template functions
 * ------------------
 *
 * In case you need to add some custom functions,
 * add them below.
 *
 */




/**
 * -----------------
 * Template partials
 * -----------------
 *
 * @see ../inc/partials/sections/hooks.php
 */

	/**
	 * Blog Section
	 * ---------------
	 */

	// Section wrapper - start
	if( ! function_exists( 'bx_ext_part__blog_wrap_start' ) ) {
		function bx_ext_part__blog_wrap_start() {
			$mod      = 'blog_bg_parallax';
			$enabled  = bx_ext_tm( $mod, false );
			$class    = $enabled ? ' bx-ext-parallax' : '';
			$parallax = bxext_section_parallax( $mod, 'blog_bg_parallax_img', true );
			$format   = '<section id="section-blog" class="grid-wrap sec-blog%1$s"%2$s>';

			$output = sprintf( $format, $class, $parallax );
			$output = apply_filters( 'bx_ext_part___blog_wrap_start', $output, $format, $class, $parallax );

			echo $output;
		}
	}

	// Section wrapper - end
	if( ! function_exists( 'bx_ext_part__blog_wrap_end' ) ) {
		function bx_ext_part__blog_wrap_end() {
			?></section><?php
		}
	}

		// Overlay
		if( ! function_exists( 'bx_ext_part__blog_overlay' ) ) {
			function bx_ext_part__blog_overlay() {
				$section = 'blog';
				$show    = bx_ext_tm( 'blog_bg_overlay', false );
				$output  = '<div class="grid-overlay"></div>';
				$output  = apply_filters( 'bx_ext_part___overlay', $output, $section );

				// Do nothing if hidden
				if( ! $show ) return;

				echo $output;
			}
		}

		/**
		 * Container
		 */
		if( ! function_exists( 'bx_ext_part__blog_container' ) ) {
 			function bx_ext_part__blog_container() {
 				/**
 				 * Hooked:
 				 * bx_ext_part__blog_container_start   - 10
 				 * bx_ext_part__blog_items             - 20
 				 * bx_ext_part__blog_container_end     - 999
 				 */
 				do_action( 'bx_ext_part__blog_container' );
 			}
 		}

			// Container start
			if( ! function_exists( 'bx_ext_part__blog_container_start' ) ) {
				function bx_ext_part__blog_container_start() {
					?><div class="grid-container grid-1 clearfix"><?php
				}
			}

			// Container end
			if( ! function_exists( 'bx_ext_part__blog_container_end' ) ) {
				function bx_ext_part__blog_container_end() {
					?></div><?php
				}
			}

			/**
			 * Items
			 */
			if( ! function_exists( 'bx_ext_part__blog_items' ) ) {
				function bx_ext_part__blog_items() {
					/**
					 * Hooked:
					 * bx_ext_part__blog_items_header   - 10
					 * bx_ext_part__blog_items_posts    - 20
					 * bx_ext_part__blog_items_end      - 999
					 */
					do_action( 'bx_ext_part__blog_items' );
				}
			}

				// Items header
				if( ! function_exists( 'bx_ext_part__blog_items_header' ) ) {
					function bx_ext_part__blog_items_header() {
						/**
						 * Hooked:
						 * bx_ext_part__blog_items_header_start       - 10
						 * bx_ext_part__blog_items_header_title       - 20
						 * bx_ext_part__blog_items_header_description - 30
						 * bx_ext_part__blog_items_header_end         - 999
						 */
						do_action( 'bx_ext_part__blog_items_header' );
					}
				}

					// Header start
					if( ! function_exists( 'bx_ext_part__blog_items_header_start' ) ) {
						function bx_ext_part__blog_items_header_start() {
							?><header class="section-header"><?php
						}
					}

					// Header end
					if( ! function_exists( 'bx_ext_part__blog_items_header_end' ) ) {
						function bx_ext_part__blog_items_header_end() {
							?></header><?php
						}
					}

					// Section title
					if( ! function_exists( 'bx_ext_part__blog_items_header_title' ) ) {
						function bx_ext_part__blog_items_header_title() {
							$section = 'blog';
							$title   = bxext_sections_strings( $section, 'title' );
							$format  = '<h2 class="section-title hs-primary-medium hb-bottom-large %1$s">%2$s</h2>%3$s';
							$divider = '<div class="divider"></div>';
							$anim    = businessx_anim_classes( true );

							$output  = sprintf( $format, $anim, esc_html( $title ), $divider );
							$output  = apply_filters(
								'bx_ext_part___blog_info_output_title',
								$output, $format, $anim, $title, $divider, $section
							);

							if( $title == '' ) return; // Do nothing

							echo $output;
						}
					}

					// Section description
					if( ! function_exists( 'bx_ext_part__blog_items_header_description' ) ) {
						function bx_ext_part__blog_items_header_description() {
							$section = 'blog';
							$desc    = bxext_sections_strings( $section, 'description' );
							$format  = '<p class="section-description fs-large %1$s">%2$s</p>';
							$anim    = businessx_anim_classes( true );

							$output  = sprintf( $format, $anim, bxext_escape_content_filtered_nonp( $desc ) );
							$output  = apply_filters(
								'bx_ext_part___blog_info_output_description',
								$output, $format, $anim, $desc, $section
							);

							if( $desc == '' ) return; // Do nothing

							echo $output;
						}
					}

				// Items posts
				if( ! function_exists( 'bx_ext_part__blog_items_posts' ) ) {
					function bx_ext_part__blog_items_posts() {
						/**
						 * Hooked:
						 * bx_ext_part__blog_items_posts_start   - 10
						 * bx_ext_part__blog_items_posts_sizers  - 20
						 * bx_ext_part__blog_items_posts_loop    - 30
						 * bx_ext_part__blog_items_posts_end     - 999
						 * bx_ext_part__blog_items_posts_js      - 1010
						 * bx_ext_part__blog_items_posts_action  - 1020
						 */
						do_action( 'bx_ext_part__blog_items_posts' );
					}
				}

					// Posts start
					if( ! function_exists( 'bx_ext_part__blog_items_posts_start' ) ) {
						function bx_ext_part__blog_items_posts_start() {
							?><div id="sec-blog-wrap" class="js-masonry grid-masonry-wrap <?php businessx_anim_classes(); ?>" data-masonry-options='{ "columnWidth": ".sec-blog-grid-sizer", "gutter": ".sec-blog-gutter-sizer", "percentPosition": true, "itemSelector": ".grid-col" }'><?php
						}
					}

					// Posts end
					if( ! function_exists( 'bx_ext_part__blog_items_posts_end' ) ) {
						function bx_ext_part__blog_items_posts_end() {
							?></div><?php
						}
					}

					// Masonry JS
					if( ! function_exists( 'bx_ext_part__blog_items_posts_js' ) ) {
						function bx_ext_part__blog_items_posts_js() {
							?>
							<script type='text/javascript'>
								jQuery( document ).ready( function( $ ) {
									var $sec_blogwrap = $('#sec-blog-wrap').masonry();
									$sec_blogwrap.imagesLoaded( function() {
										$sec_blogwrap.masonry();
									});
								});
							</script>
							<?php
						}
					}

					// Action button
					if( ! function_exists( 'bx_ext_part__blog_items_posts_action' ) ) {
						function bx_ext_part__blog_items_posts_action() {
							$show   = bx_ext_tm( 'blog_action_btn_show', false );
							$label  = bxext_sections_strings( 'blog', 'button' );
							$url    = bx_ext_tm( 'blog_action_btn_url', '#' );
							$format = '<div class="grid-col grid-4x-col blog-action ta-center"><a href="%1$s" class="ac-btn btn-biggest blog-action-btn">%2$s</a></div>';

							$output = sprintf( $format, esc_url( $url ), esc_html( $label ) );
							$output = apply_filters( 'bx_ext_part___blog_items_posts_action', $output, $format, $label, $url, $show );

							if( ! $show ) return;

							echo $output;
						}
					}

						// Posts sizers
						if( ! function_exists( 'bx_ext_part__blog_items_posts_sizers' ) ) {
							function bx_ext_part__blog_items_posts_sizers() {
								?><div class="sec-blog-grid-sizer"></div><div class="sec-blog-gutter-sizer"></div><?php
							}
						}

						// Posts loop
						if( ! function_exists( 'bx_ext_part__blog_items_posts_loop' ) ) {
							function bx_ext_part__blog_items_posts_loop() {
								$numb = bx_ext_tm( 'blog_section_nr_posts', 4 );
								$args = apply_filters( 'bx_ext_part___blog_items_posts_loop_args', array(
									'order'           	=> 'desc',
									'orderby'         	=> 'date',
									'posts_per_page' 	=> absint( $numb ),
									'post__not_in' 		=> get_option( 'sticky_posts' ),
								) );
								$query = new WP_Query( $args );

								/* start loop */
								if ( $query->have_posts() ) :
									while ( $query->have_posts() ) : $query->the_post();

									/**
									 * Hooked:
									 * bx_ext_part__blog_items_posts_loop_post_start   - 10
									 * bx_ext_part__blog_items_posts_loop_post_thumb   - 20
									 * bx_ext_part__blog_items_posts_loop_post_title   - 30
									 * bx_ext_part__blog_items_posts_loop_post_excerpt - 40
									 * bx_ext_part__blog_items_posts_loop_post_meta    - 50
									 * bx_ext_part__blog_items_posts_loop_post_end     - 999
									 */
									do_action( 'bx_ext_part__blog_items_posts_loop_post' );

									endwhile;

									/* reset query */
									wp_reset_postdata();

									/* if no posts are found */
									else :
										$no_posts         = '<p class="ta-center">%s</p>';
										$no_posts_msg     = __( 'There are no posts to display. Maybe add some!', 'businessx-extensions' );
										$display_no_posts = sprintf( $no_posts, $no_posts_msg );
										$display_no_posts = apply_filters( 'bx_ext_part__blog_items_no_posts', $display_no_posts, esc_html( $no_posts_msg ), $no_posts );

										echo $display_no_posts;

									/* end query */
									endif;
							}
						}

							// Post start
							if( ! function_exists( 'bx_ext_part__blog_items_posts_loop_post_start' ) ) {
								function bx_ext_part__blog_items_posts_loop_post_start() {
									?><div class="grid-col grid-2x-col sec-blog-post"><?php
								}
							}

							// Post end
							if( ! function_exists( 'bx_ext_part__blog_items_posts_loop_post_end' ) ) {
								function bx_ext_part__blog_items_posts_loop_post_end() {
									?></div><!-- .sec-blog-post --><?php
								}
							}

							// Post thumbnail
							if( ! function_exists( 'bx_ext_part__blog_items_posts_loop_post_thumb' ) ) {
								function bx_ext_part__blog_items_posts_loop_post_thumb() {
									$post_id = get_the_ID();
									$wrap    = '<figure class="sec-blog-post-thumbnail">%s</figure>';
									$before  = '<a href="' . esc_url( get_permalink() ) . '" rel="nofollow">';
									$after   = '</a>';
									$image   = get_the_post_thumbnail( $post_id, 'businessx-tmb-blog-wide' );
									$format  = '%1$s%2$s%3$s';
									$inner   = sprintf( $format, $before, $image, $after );
									$output  = sprintf( $wrap, $inner );

									$output = apply_filters(
										'bx_ext_part___blog_items_posts_loop_post_thumb', $output, $wrap, $before, $after, $image, $format, $inner );

									if( has_post_thumbnail( $post_id ) ) {
										echo $output;
									}
								}
							}

							// Post title
							if( ! function_exists( 'bx_ext_part__blog_items_posts_loop_post_title' ) ) {
								function bx_ext_part__blog_items_posts_loop_post_title() {
									$wrap   = '<header class="sec-blog-post-title">%s</header>';
									$before = '<h3 class="hs-secondary-large fw-light"><a href="' . esc_url( get_permalink() ) . '" title="' . the_title_attribute( array( 'echo' => false ) ) . '">';
									$after  = '</a></h3>';
									$title  = the_title( '', '', false );
									$format = '%1$s%2$s%3$s';
									$inner  = sprintf( $format, $before, $title, $after );
									$output = sprintf( $wrap, $inner );

									$output = apply_filters(
										'bx_ext_part___blog_items_posts_loop_post_thumb', $output, $wrap, $before, $after, $title, $format, $inner );

									if( $title != '' ){
										echo $output;
									}
								}
							}

							// Post excerpt
							if( ! function_exists( 'bx_ext_part__blog_items_posts_loop_post_excerpt' ) ) {
								function bx_ext_part__blog_items_posts_loop_post_excerpt() {
									?><div class="sec-blog-post-excerpt"><?php the_excerpt(); ?></div><?php
								}
							}

							// Post meta
							if( ! function_exists( 'bx_ext_part__blog_items_posts_loop_post_meta' ) ) {
								function bx_ext_part__blog_items_posts_loop_post_meta() {
									?>
									<footer class="sec-blog-post-meta">
										<ul class="sec-blog-post-meta-list">
											<?php businessx_post_meta(); ?>
										</ul>
									</footer>
									<?php
								}
							}
