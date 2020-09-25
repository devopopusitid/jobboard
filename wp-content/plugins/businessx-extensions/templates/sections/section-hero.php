<?php
/* ------------------------------------------------------------------------- *
 *  Hero Section Wrapper
/* ------------------------------------------------------------------------- */

if( bx_ext_show_section( 'hero' ) ) :

	/**
	 * Hooked:
	 * bx_ext_part__hero_wrap_start - 10
	 * bx_ext_part__hero_overlay    - 20
	 * bx_ext_part__hero_wrap_end   - 999
	 *
	 * @since 1.0.4.3
	 * @see   ../inc/partials/sections/hero.php
	 */
	do_action( 'bx_ext_part__hero' );

endif; // END Hero Section
