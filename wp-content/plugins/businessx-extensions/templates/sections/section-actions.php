<?php
/* ------------------------------------------------------------------------- *
 *  Actions Section Wrapper
/* ------------------------------------------------------------------------- */

if( bx_ext_show_section( 'actions' ) ) :

	/**
	 * Hooked:
	 * bx_ext_part__actions_display - 10
	 * bx_ext_part__actions_helper  - 999
	 *
	 * @since 1.0.4.3
	 * @see   ../inc/partials/sections/actions.php
	 */
	do_action( 'bx_ext_part__actions' );

endif; // END Actions Section
