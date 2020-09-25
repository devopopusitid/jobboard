<?php
/**
 * ------------------
 * Template functions
 * ------------------
 *
 * In case you need to add some custom functions,
 * add them below.
 *
 */




/**
 * -----------------
 * Template partials
 * -----------------
 *
 * @see ../inc/partials/sections/hooks.php
 */

	/**
	 * Actions Section
	 * ---------------
	 */

	// Display
	if( ! function_exists( 'bx_ext_part__actions_display' ) ) {
		function bx_ext_part__actions_display() {
			if ( is_active_sidebar( 'section-actions' ) && ! is_paged() ) {
				dynamic_sidebar( 'section-actions' );
			}
		}
	}

	// Helper
	if( ! function_exists( 'bx_ext_part__actions_helper' ) ) {
		function bx_ext_part__actions_helper() {
			if ( ! is_active_sidebar( 'section-actions' ) ) {
			?>
			<section id="section-actions" class="grid-wrap sec-action elements-left">
                <div class="grid-container grid-1 clearfix <?php businessx_anim_classes(); ?>">

                    <div class="grid-col grid-4x-col ta-center elements-meta">
                        <h2 class="hs-primary-medium"><?php _e( 'Actions Section', 'businessx-extensions' ); ?></h2>
                        <div class="elements-excerpt fs-large">
                            <?php _e( 'You can find options for this section in: <b>Customizer > Front Page Sections > Actions Section</b> and add items by clicking on <b>Add or edit actions</b>.', 'businessx-extensions' ); ?>
                        </div>
                         <div class="elements-buttons">
                        <a href="#" class="ac-btn btn-big btn-1"><?php _e( 'Button Example', 'businessx-extensions' ); ?></a>
                    </div>
                    </div><!-- END .elements-meta -->

                </div><!-- END .grid-container -->
            </section>
			<?php
			}
		}
	}
