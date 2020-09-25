<?php
/* ------------------------------------------------------------------------- *
 *  Features Section Wrapper
/* ------------------------------------------------------------------------- */

if( bx_ext_show_section( 'features' ) ) :

	/**
	 * Hooked:
	 * bx_ext_part__features_wrap_start - 10
	 * bx_ext_part__features_overlay    - 20
	 * bx_ext_part__features_container  - 30
	 * bx_ext_part__features_wrap_end   - 999
	 *
	 * @since 1.0.4.3
	 * @see   ../inc/partials/sections/features.php
	 */
	do_action( 'bx_ext_part__features' );

endif; // END Features Section
