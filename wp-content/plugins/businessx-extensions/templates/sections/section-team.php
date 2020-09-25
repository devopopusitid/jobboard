<?php
/* ------------------------------------------------------------------------- *
 *  Team Section Wrapper
/* ------------------------------------------------------------------------- */

if( bx_ext_show_section( 'team' ) ) :

	/**
	 * Hooked:
	 * bx_ext_part__team_wrap_start - 10
	 * bx_ext_part__team_overlay    - 20
	 * bx_ext_part__team_container  - 30
	 * bx_ext_part__team_wrap_end   - 999
	 *
	 * @since 1.0.4.3
	 * @see   ../inc/partials/sections/team.php
	 */
	do_action( 'bx_ext_part__team' );

endif; // END Team Section
