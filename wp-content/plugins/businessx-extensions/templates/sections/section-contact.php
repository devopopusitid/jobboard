<?php
/* ------------------------------------------------------------------------- *
 *  Contact Section Wrapper
/* ------------------------------------------------------------------------- */

if( bx_ext_show_section( 'contact' ) ) :

	/**
	 * Hooked:
	 * bx_ext_part__contact_wrap_start - 10
	 * bx_ext_part__contact_overlay    - 20
	 * bx_ext_part__contact_container  - 30
	 * bx_ext_part__contact_wrap_end   - 999
	 *
	 * @since 1.0.4.3
	 * @see   ../inc/partials/sections/contact.php
	 */
	do_action( 'bx_ext_part__contact' );

endif; // END Contact Section
