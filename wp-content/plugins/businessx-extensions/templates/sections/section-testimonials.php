<?php
/* ------------------------------------------------------------------------- *
 *  Testimonials Section Wrapper
/* ------------------------------------------------------------------------- */

if( bx_ext_show_section( 'testimonials' ) ) :

	/**
	 * Hooked:
	 * bx_ext_part__testimonials_wrap_start - 10
	 * bx_ext_part__testimonials_overlay    - 20
	 * bx_ext_part__testimonials_container  - 30
	 * bx_ext_part__testimonials_helper     - 40
	 * bx_ext_part__testimonials_items      - 50
	 * bx_ext_part__testimonials_nav        - 60
	 * bx_ext_part__testimonials_js         - 70
	 * bx_ext_part__testimonials_wrap_end   - 999
	 *
	 * @since 1.0.4.3
	 * @see   ../inc/partials/sections/testimonials.php
	 */
	do_action( 'bx_ext_part__testimonials' );

endif; // END Testimonials Section
