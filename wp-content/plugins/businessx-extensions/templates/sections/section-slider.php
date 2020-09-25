<?php
/* ------------------------------------------------------------------------- *
 *  Slider Section Wrapper
/* ------------------------------------------------------------------------- */

if( bx_ext_show_section( 'slider' ) ) :

	/**
	 * Hooked:
	 * bx_ext_part__slider_wrap_start - 10
	 * bx_ext_part__slider_arrows     - 20
	 * bx_ext_part__slider_items      - 30
	 * bx_ext_part__slider_js         - 40
	 * bx_ext_part__slider_wrap_end   - 999
	 *
	 * @since 1.0.4.3
	 * @see   ../inc/partials/sections/slider.php
	 */
	do_action( 'bx_ext_part__slider' );

endif; // END Slider Section
