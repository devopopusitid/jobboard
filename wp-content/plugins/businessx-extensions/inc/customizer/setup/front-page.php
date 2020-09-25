<?php
/**
 * Check if "Businessx Front Page" exists and if it's
 * set as a static front page
 * 
 * @since  1.4.0
 * @return boolean true or false
 */
if( ! function_exists( 'bxext_used_frontpage' ) ) {
	function bxext_used_frontpage() {
		$page_title = apply_filters( 'businessx_extensions___frontpage_name', 'Businessx Front Page' );
		$page = get_page_by_title( $page_title );
		$check = bxext_has_frontpage();

		if ( $check && get_option( 'page_on_front', -1 ) === $page->ID."" ) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 * Checks if a Businessx Extensions front page is published
 * 
 * @since  1.4.0
 * @return boolean true or false
 */
if( ! function_exists( 'bxext_has_frontpage' ) ) {
	function bxext_has_frontpage() {
		$page_title = apply_filters( 'businessx_extensions___frontpage_name', 'Businessx Front Page' );
		$page = get_page_by_title( $page_title );

		if ( $page ) {
			if ( is_object( $page ) && property_exists( $page, 'post_status' ) && $page->post_status === 'publish' ) {
				return true;
			}
			return false;
		}
		return false;
	}
}

/**
 * Creates a front page and blog page and sets up
 * the static page option.
 * 
 * @since  1.4.0
 * @return void
 */
if( ! function_exists( 'bxext_create_frontpage' ) ) {
	function bxext_create_frontpage() {
		// Check nonce
		$nonce = $_POST[ 'bxext_create_frontpage' ];
		if ( ! wp_verify_nonce( $nonce, 'bxext_create_frontpage' ) ) {
			die();
		}

		// Setup front page
		$page_title = apply_filters( 'businessx_extensions___frontpage_name', 'Businessx Front Page' );
		$page_slug  = apply_filters( 'businessx_extensions___frontpage_slug', 'businessx-front-page' );

		$page = get_page_by_title( $page_title );
		if ( $page == null  || $page->post_status !== 'publish' ) {
			// Front Page
			$page_id = wp_insert_post(
				array(
					'comment_status' => 'closed',
					'ping_status'    => 'closed',
					'post_name'      => $page_slug,
					'post_title'     => $page_title,
					'post_status'    => 'publish',
					'post_type'      => 'page',
					'page_template'  => 'template-frontpage.php',
				)
			);

			// Update static front page settings
			update_option('show_on_front', 'page');
			update_option('page_on_front', $page_id);
			update_option('bxext_fp_installed', true);

			// Blog view
			if ( get_page_by_title( 'Blog' ) == null ) {
				$page_id = wp_insert_post(
					array(
						'comment_status' => 'closed',
						'ping_status'    => 'closed',
						'post_name'      => 'blog',
						'post_title'     => 'Blog',
						'post_status'    => 'publish',
						'post_type'      => 'page',
					)
				);

				// Update option
				$blog = get_page_by_title( 'Blog' );
				update_option( 'page_for_posts', $blog->ID );
			}
		}

	}
}
add_action( 'wp_ajax_bxext_create_frontpage', 'bxext_create_frontpage' );

/**
 * Ajax action if the modal dismiss button is used
 * Updates the 'bxext_dismiss_fp_create' option to true
 * 
 * @since  1.4.0
 * @return void
 */
if( ! function_exists( 'bxext_dismiss_create_frontpage' ) ) {
	function bxext_dismiss_create_frontpage() {
		$nonce = $_POST[ 'bxext_create_frontpage' ];
		if ( ! wp_verify_nonce( $nonce, 'bxext_dismiss_create_frontpage' ) ) {
			die();
		}

		update_option( 'bxext_dismiss_fp_create', true );
	}
}
add_action( 'wp_ajax_bxext_dismiss_create_frontpage', 'bxext_dismiss_create_frontpage' );

/**
 * Adds an inline JS object and enqueues
 * thickbox scripts & styles
 * 
 * @todo   Maybe remove the `bxext_frontpage_vars` variable
 * @since  1.4.0
 * @return void
 */
if( ! function_exists( 'bxext_frontpage_vars' ) ) {
	function bxext_frontpage_vars() {
			$suffix = bx_ext_get_min_suffix();

			wp_localize_script( 'businessx-extensions-customizer-js', 'bxext_frontpage_vars', array(
				'used_frontpage' => bxext_used_frontpage(),
				'has_frontpage' => bxext_has_frontpage(),
			) );
			
			// Magnific Popup CSS
			// @since 1.0.6
			wp_enqueue_style( 
				'magnific-popup', 
				BUSINESSX_EXTS_URL . 'css/magnific-popup.css', 
				array(), 
				'1.1.0', 'all' 
			);

			// Magnific Popup JS
			// @since 1.0.6
			wp_enqueue_script(
				'magnific-popup',
				BUSINESSX_EXTS_URL . 'js/customizer/jquery.magnific-popup' . $suffix . '.js',
				array( 'jquery' ),
				'1.1.0', FALSE
			);
	}
}

/**
 * "Static Front Page" modal template
 * 
 * @since  1.4.0
 * @return html
 */
if( ! function_exists( 'bxext_frontpage_modal' ) ) {
	function bxext_frontpage_modal() {
		?>
		<div id="businessx-frontpage-modal" class="mfp-hide mfp-white-popup-block bxext-stp-modal-window">
			<h1><?php esc_html_e( 'Businessx Front Page Setup', 'businessx-extensions' ); ?></h1>
			<p><?php esc_html_e( 'Would you like to add a static front page as your homepage?', 'businessx-extensions' ); ?></p>
			<p><?php printf(
				esc_html__( 'This will add a page called "Businessx Front Page" with a page template that includes all 12 custom sections (Slider, Features, About us and so on). Or you can do this manually, %s.', 'businessx-extensions' ),
				'<a href="' . BUSINESSX_EXTS_THEME_DOCS . '#h10" target="_blank">' . esc_html_x( 'here is how', 'Front Page setup modal', 'businessx-extensions' ) . '</a>'
			);
			?></p>
			<div class="button-group">
				<a href="#" class="button-primary button button-hero" id="bxext-insert-frontpage"><?php esc_html_e( 'Insert Front Page', 'businessx-extensions' ); ?></a>
				<a href="#" class="button-secondary button button-hero" id="bxext-dismiss-frontpage"><?php esc_html_e( 'Never Ask Again', 'businessx-extensions' ); ?></a>
			</div>
      	</div>
		<?php
	}
}

/**
 * Init if front page doesn't exist.
 */
$bxext_check_fp = bxext_used_frontpage();
if( ! $bxext_check_fp && get_option( 'bxext_dismiss_fp_create', false ) === false ) {
	add_filter( 'customize_controls_enqueue_scripts', 'bxext_frontpage_vars', 20 );
	add_action( 'customize_controls_print_footer_scripts', 'bxext_frontpage_modal' );
}
