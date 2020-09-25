<?php
/* ------------------------------------------------------------------------- *
 *  Portfolio Section Wrapper
/* ------------------------------------------------------------------------- */

if( bx_ext_show_section( 'portfolio' ) ) :

	/**
	 * Hooked:
	 * bx_ext_part__portfolio_wrap_start - 10
	 * bx_ext_part__portfolio_overlay    - 20
	 * bx_ext_part__portfolio_container  - 30
	 * bx_ext_part__portfolio_wrap_end   - 999
	 *
	 * @since 1.0.4.3
	 * @see   ../inc/partials/sections/portfolio.php
	 */
	do_action( 'bx_ext_part__portfolio' );

endif; // END Portfolio Section
