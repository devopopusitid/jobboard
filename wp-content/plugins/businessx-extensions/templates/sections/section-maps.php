<?php
/* ------------------------------------------------------------------------- *
 *  Maps Section Wrapper
/* ------------------------------------------------------------------------- */

if( bx_ext_show_section( 'maps' ) ) :

	/**
	 * Hooked:
	 * bx_ext_part__map_wrap_start - 10
	 * bx_ext_part__map_overlay    - 20
	 * bx_ext_part__map_output     - 30
	 * bx_ext_part__map_wrap_end   - 999
	 *
	 * @since 1.0.4.3
	 * @see   ../inc/partials/sections/maps.php
	 */
	do_action( 'bx_ext_part__map' );

endif; // END Maps Section
