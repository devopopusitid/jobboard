<?php
/* ------------------------------------------------------------------------- *
 *  About Us Section Wrapper
/* ------------------------------------------------------------------------- */

if( bx_ext_show_section( 'about' ) ) :

	/**
	 * Hooked:
	 * bx_ext_part__about_wrap_start - 10
	 * bx_ext_part__about_overlay    - 20
	 * bx_ext_part__about_container  - 30
	 * bx_ext_part__about_wrap_end   - 999
	 *
	 * @since 1.0.4.3
	 * @see   ../inc/partials/sections/about.php
	 */
	do_action( 'bx_ext_part__about' );

endif; // END About Section
