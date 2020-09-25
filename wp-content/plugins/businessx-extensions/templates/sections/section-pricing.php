<?php
/* ------------------------------------------------------------------------- *
 *  Pricing Section Wrapper
/* ------------------------------------------------------------------------- */

if( bx_ext_show_section( 'pricing' ) ) :

	/**
	 * Hooked:
	 * bx_ext_part__pricing_wrap_start - 10
	 * bx_ext_part__pricing_overlay    - 20
	 * bx_ext_part__pricing_container  - 30
	 * bx_ext_part__pricing_wrap_end   - 999
	 *
	 * @since 1.0.4.3
	 * @see   ../inc/partials/sections/pricing.php
	 */
	do_action( 'bx_ext_part__pricing' );

endif; // END Pricing Section
