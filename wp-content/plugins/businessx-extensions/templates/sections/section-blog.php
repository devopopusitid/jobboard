<?php
/* ------------------------------------------------------------------------- *
 *  Blog Section Wrapper
/* ------------------------------------------------------------------------- */

if( bx_ext_show_section( 'blog' ) ) :

	/**
	 * Hooked:
	 * bx_ext_part__blog_wrap_start - 10
	 * bx_ext_part__blog_overlay    - 20
	 * bx_ext_part__blog_container  - 30
	 * bx_ext_part__blog_wrap_end   - 999
	 *
	 * @since 1.0.4.3
	 * @see   ../inc/partials/sections/blog.php
	 */
	do_action( 'bx_ext_part__blog' );

endif; // END Blog Section
