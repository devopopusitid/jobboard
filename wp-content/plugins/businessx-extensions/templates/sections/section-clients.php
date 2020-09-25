<?php
/* ------------------------------------------------------------------------- *
 *  Clients Section Wrapper
/* ------------------------------------------------------------------------- */

if( bx_ext_show_section( 'clients' ) ) :

	/**
	 * Hooked:
	 * bx_ext_part__clients_wrap_start - 10
	 * bx_ext_part__clients_overlay    - 20
	 * bx_ext_part__clients_container  - 30
	 * bx_ext_part__clients_js         - 40
	 * bx_ext_part__clients_wrap_end   - 999
	 *
	 * @since 1.0.4.3
	 * @see   ../inc/partials/sections/clients.php
	 */
	do_action( 'bx_ext_part__clients' );

endif; // END Clients Section
