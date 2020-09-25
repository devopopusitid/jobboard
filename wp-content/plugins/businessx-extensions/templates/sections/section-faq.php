<?php
/* ------------------------------------------------------------------------- *
 *  Frequently Asked Questions Section Wrapper
/* ------------------------------------------------------------------------- */

if( bx_ext_show_section( 'faq' ) ) :

	/**
	 * Hooked:
	 * bx_ext_part__faq_wrap_start - 10
	 * bx_ext_part__faq_overlay    - 20
	 * bx_ext_part__faq_container  - 30
	 * bx_ext_part__faq_js         - 40
	 * bx_ext_part__faq_wrap_end   - 999
	 *
	 * @since 1.0.4.3
	 * @see   ../inc/partials/sections/faq.php
	 */
	do_action( 'bx_ext_part__faq' );

endif; // END FAQ Section
